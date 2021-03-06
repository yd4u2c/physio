ers->getCacheControlDirective('s-maxage'));
    }

    public function testResponseIsExpirableButNotValidateableWhenMasterResponseCombinesExpirationAndValidation()
    {
        $cacheStrategy = new ResponseCacheStrategy();

        $masterResponse = new Response();
        $masterResponse->setSharedMaxAge(3600);
        $masterResponse->setEtag('foo');
        $masterResponse->setLastModified(new \DateTime());

        $embeddedResponse = new Response();
        $embeddedResponse->setSharedMaxAge(60);

        $cacheStrategy->add($embeddedResponse);
        $cacheStrategy->update($masterResponse);

        $this->assertSame('60', $masterResponse->headers->getCacheControlDirective('s-maxage'));
        $this->assertFalse($masterResponse->isValidateable());
    }

    /**
     * @dataProvider cacheControlMergingProvider
     */
    public function testCacheControlMerging(array $expects, array $master, array $surrogates)
    {
        $cacheStrategy = new ResponseCacheStrategy();
        $buildResponse = function ($config) {
            $response = new Response();

            foreach ($config as $key => $value) {
                switch ($key) {
                    case 'age':
                        $response->headers->set('Age', $value);
                        break;

                    case 'expires':
                        $expires = clone $response->getDate();
                        $expires->modify('+'.$value.' seconds');
                        $response->setExpires($expires);
                        break;

                    case 'max-age':
                        $response->setMaxAge($value);
                        break;

                    case 's-maxage':
                        $response->setSharedMaxAge($value);
                        break;

                    case 'private':
                        $response->setPrivate();
                        break;

                    case 'public':
                        $response->setPublic();
                        break;

                    default:
                        $response->headers->addCacheControlDirective($key, $value);
                }
            }

            return $response;
        };

        foreach ($surrogates as $config) {
            $cacheStrategy->add($buildResponse($config));
        }

        $response = $buildResponse($master);
        $cacheStrategy->update($response);

        foreach ($expects as $key => $value) {
            if ('expires' === $key) {
                $this->assertSame($value, $response->getExpires()->format('U') - $response->getDate()->format('U'));
            } elseif ('age' === $key) {
                $this->assertSame($value, $response->getAge());
            } elseif (true === $value) {
                $this->assertTrue($response->headers->hasCacheControlDirective($key), sprintf('Cache-Control header must have "%s" flag', $key));
            } elseif (false === $value) {
                $this->assertFalse(
                    $response->headers->hasCacheControlDirective($key),
                    sprintf('Cache-Control header must NOT have "%s" flag', $key)
                );
            } else {
                $this->assertSame($value, $response->headers->getCacheControlDirective($key), sprintf('Cache-Control flag "%s" should be "%s"', $key, $value));
            }
        }
    }

    public function cacheControlMergingProvider()
    {
        yield 'result is public if all responses are public' => [
            ['private' => false, 'public' => true],
            ['public' => true],
            [
                ['public' => true],
            ],
        ];

        yield 'result is private by default' => [
            ['private' => true, 'public' => false],
            ['public' => true],
            [
                [],
            ],
        ];

        yield 'combines public and private responses' => [
            ['must-revalidate' => false, 'private' => true, 'public' => false],
            ['public' => true],
            [
                ['private' => true],
            ],
        ];

        yield 'inherits no-cache from surrogates' => [
            ['no-cache' => true, 'public' => false],
            ['public' => true],
            [
                ['no-cache' => true],
            ],
        ];

        yield 'inherits no-store from surrogate' => [
            ['no-store' => true, 'public' => false],
            ['public' => true],
            [
                ['no-store' => true],
            ],
        ];

        yield 'resolve to lowest possible max-age' => [
            ['public' => false, 'private' => true, 's-maxage' => false, 'max-age' => '60'],
            ['public' => true, 'max-age' => 3600],
            [
                ['private' => true, 'max-age' => 60],
            ],
        ];

        yield 'resolves multiple max-age' => [
            ['public' => false, 'private' => true, 's-maxage' => false, 'max-age' => '60'],
            ['private' => true, 'max-age' => 100],
            [
                ['private' => true, 'max-age' => 3600],
                ['public' => true, 'max-age' => 60, 's-maxage' => 60],
                ['private' => true, 'max-age' => 60],
            ],
        ];

        yield 'merge max-age and s-maxage' => [
            ['public' => true, 's-maxage' => '60', 'max-age' => null],
            ['public' => true, 's-maxage' => 3600],
            [
                ['public' => true, 'max-age' => 60],
            ],
        ];

        yield 'result is private when combining private responses' => [
            ['no-cache' => false, 'must-revalidate' => false, 'private' => true],
            ['s-maxage' => 60, 'private' => true],
            [
                ['s-maxage' => 60, 'private' => true],
            ],
        ];

        yield 'result can have s-maxage and max-age' => [
            ['public' => true, 'private' => false, 's-maxage' => '60', 'max-age' => '30'],
            ['s-maxage' => 100, 'max-age' => 2000],
            [
                ['s-maxage' => 1000, 'max-age' => 30],
                ['s-maxage' => 500, 'max-age' => 500],
                ['s-maxage' => 60, 'max-age' => 1000],
            ],
        ];

        yield 'does not set headers without value' => [
            ['max-age' => null, 's-maxage' => null, 'public' => null],
            ['private' => true],
            [
                ['private' => true],
            ],
        ];

        yield 'max-age 0 is sent to the client' => [
            ['private' => true, 'max-age' => '0'],
            ['max-age' => 0, 'private' => true],
            [
                ['max-age' => 60, 'private' => true],
            ],
        ];

        yield 'max-age is relative to age' => [
            ['max-age' => '240', 'age' => 60],
            ['max-age' => 180],
            [
                ['max-age' => 600, 'age' => 60],
            ],
        ];

        yield 'retains lowest age of all responses' => [
            ['max-age' => '160', 'age' => 60],
            ['max-age' => 600, 'age' => 60],
            [
                ['max-age' => 120, 'age' => 20],
            ],
        ];

        yield 'max-age can be less than age, essentially expiring the response' => [
            ['age' => 120, 'max-age' => '90'],
            ['max-age' => 90, 'age' => 120],
            [
                ['max-age' => 120, 'age' => 60],
            ],
        ];

        yield 'max-age is 0 regardless of age' => [
            ['max-age' => '0'],
            ['max-age' => 60],
            [
                ['max-age' => 0, 'age' => 60],
            ],
        ];

        yield 'max-age is not negative' => [
            ['max-age' => '0'],
            ['max-age' => 0],
            [
                ['max-age' => 0, 'age' => 60],
            ],
        ];

        yield 'calculates lowest Expires header' => [
            ['expires' => 60],
            ['expires' => 60],
            [
                ['expires' => 120],
            ],
        ];

        yield 'calculates Expires header relative to age' => [
            ['expires' => 210, 'age' => 120],
            ['expires' => 90],
            [
                ['expires' => 600, 'age' => '120'],
            ],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     