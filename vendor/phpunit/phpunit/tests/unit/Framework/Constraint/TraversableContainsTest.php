hesesAreAllowedWithWhitespace(): void
    {
        $this->assertSame(
            [TEST_FILES_PATH . 'CoveredClass.php' => \range(29, 33)],
            Test::getLinesToBeCovered(
                'CoverageMethodParenthesesWhitespaceTest',
                'testSomething'
            )
        );
    }

    public function testNamespacedFunctionCanBeCoveredOrUsed(): void
    {
        $this->assertEquals(
            [
                TEST_FILES_PATH . 'NamespaceCoveredFunction.php' => \range(12, 15),
            ],
            Test::getLinesToBeCovered(
                \CoverageNamespacedFunctionTest::class,
                'testFunc'
            )
        );
    }

    public function getLinesToBeCoveredProvider(): array
    {
        return [
            [
                'CoverageNoneTest',
                [],
            ],
            [
                'CoverageClassExtendedTest',
                \array_merge(\range(27, 44), \range(10, 25)),
            ],
            [
                'CoverageClassTest',
                \range(27, 44),
            ],
            [
                'CoverageMethodTest',
                \range(29, 33),
            ],
            [
                'CoverageMethodOneLineAnnotationTest',
                \range(29, 33),
            ],
            [
                'CoverageNotPrivateTest',
                \array_merge(\range(29, 33), \range(35, 39)),
            ],
            [
                'CoverageNotProtectedTest',
                \array_merge(\range(29, 33), \range(41, 43)),
            ],
            [
                'CoverageNotPublicTest',
                \array_merge(\range(35, 39), \range(41, 43)),
            ],
            [
                'CoveragePrivateTest',
                \range(41, 43),
            ],
            [
                'CoverageProtectedTest',
                \range(35, 39),
            ],
            [
                'CoveragePublicTest',
                \range(29, 33),
            ],
            [
                'CoverageFunctionTest',
                \range(10, 12),
            ],
            [
                'NamespaceCoverageClassExtendedTest',
                \array_merge(\range(29, 46), \range(12, 27)),
            ],
            [
                'NamespaceCoverageClassTest',
                \range(29, 46),
            ],
            [
                'NamespaceCoverageMethodTest',
                \range(31, 35),
            ],
            [
                'NamespaceCoverageNotPrivateTest',
                \array_merge(\range(31, 35), \range(37, 41)),
            ],
            [
                'NamespaceCoverageNotProtectedTest',
                \array_merge(\range(31, 35), \range(43, 45)),
            ],
            [
                'NamespaceCoverageNotPublicTest',
                \array_merge(\range(37, 41), \range(43, 45)),
            ],
            [
                'NamespaceCoveragePrivateTest',
                \range(43, 45),
            ],
            [
                'NamespaceCoverageProtectedTest',
                \range(37, 41),
            ],
            [
                'NamespaceCoveragePublicTest',
                \range(31, 35),
            ],
            [
                'NamespaceCoverageCoversClassTest',
                \array_merge(\range(43, 45), \range(37, 41), \range(31, 35), \range(24, 26), \range(19, 22), \range(14, 17)),
            ],
            [
                'NamespaceCoverageCoversClassPublicTest',
                \range(31, 35),
            ],
            [
                'CoverageNothingTest',
                false,
            ],
            [
                'CoverageCoversOverridesCoversNothingTest',
                \range(29, 33),
            ],
        ];
    }

    public function testParseTestMethodAnnotationsIncorporatesTraits(): void
    {
        $result = Test::parseTestMethodAnnotations(\ParseTestMethodAnnotationsMock::class);

        $this->assertArrayHasKey('class', $result);
        $this->assertArrayHasKey('method', $result);
        $this->assertArrayHasKey('theClassAnnotation', $result['class']);
        $this->assertArrayHasKey('theTraitAnnotation', $result['class']);
    }

    public function testCoversAnnotationIncludesTraitsUsedByClass(): void
    {
        $this->assertSame(
            [
                TEST_FILES_PATH . '3194.php' => \array_merge(\range(21, 29), \range(13, 19)),
            ],
            Test::getLinesToBeCovered(
                \Test3194::class,
                'testOne'
            )
        );
    }
}
                                                                                                                                                                                                                                                                  