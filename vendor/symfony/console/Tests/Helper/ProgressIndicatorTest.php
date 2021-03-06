    );

        $this->question->setAutocompleterValues($values);
    }

    public function testSetAutocompleterValuesWithTraversable()
    {
        $question1 = new Question('Test question 1');
        $iterator1 = $this->getMockForAbstractClass(\IteratorAggregate::class);
        $iterator1
            ->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator(['Potato']));
        $question1->setAutocompleterValues($iterator1);

        $question2 = new Question('Test question 2');
        $iterator2 = $this->getMockForAbstractClass(\IteratorAggregate::class);
        $iterator2
            ->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator(['Carrot']));
        $question2->setAutocompleterValues($iterator2);

        // Call multiple times to verify that Traversable result is cached, and
        // that there is no crosstalk between cached copies.
        self::assertSame(['Potato'], $question1->getAutocompleterValues());
        self::assertSame(['Carrot'], $question2->getAutocompleterValues());
        self::assertSame(['Potato'], $question1->getAutocompleterValues());
        self::assertSame(['Carrot'], $question2->getAutocompleterValues());
    }

    public function testGetAutocompleterValuesDefault()
    {
        self::assertNull($this->question->getAutocompleterValues());
    }

    public function testGetSetAutocompleterCallback()
    {
        $callback = function (string $input): array { return []; };

        $this->question->setAutocompleterCallback($callback);
        self::assertSame($callback, $this->question->getAutocompleterCallback());
    }

    public function testGetAutocompleterCallbackDefault()
    {
        self::assertNull($this->question->getAutocompleterCallback());
    }

    public function testSetAutocompleterCallbackWhenHidden()
    {
        $this->question->setHidden(true);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage(
            'A hidden question cannot use the autocompleter.'
        );

        $this->question->setAutocompleterCallback(
            function (string $input): array { return []; }
        );
    }

    public function testSetAutocompleterCallbackWhenNotHidden()
    {
        $this->question->setHidden(true);
        $this->question->setHidden(false);

        $exception = null;
        try {
            $this->question->setAutocompleterCallback(
                function (string $input): array { return []; }
            );
        } catch (\Exception $exception) {
            // Do nothing
        }

        $this->assertNull($exception);
    }

    public function providerGetSetValidator()
    {
        return [
            [function ($input) { return $input; }],
            [null],
        ];
    }

    /**
     * @dataProvider providerGetSetValidator
     */
    public function testGetSetValidator($callback)
    {
        $this->question->setValidator($callback);
        self::assertSame($callback, $this->question->getValidator());
    }

    public function testGetValidatorDefault()
    {
        self::assertNull($this->question->getValidator());
    }

    public function providerGetSetMaxAttempts()
    {
        return [[1], [5], [null]];
    }

    /**
     * @dataProvider providerGetSetMaxAttempts
     */
    public function testGetSetMaxAttempts($attempts)
    {
        $this->question->setMaxAttempts($attempts);
        self::assertSame($attempts, $this->question->getMaxAttempts());
    }

    public function providerSetMaxAttemptsInvalid()
    {
        return [['Potato'], [0], [-1]];
    }

    /**
     * @dataProvider providerSetMaxAttemptsInvalid
     */
    public function testSetMaxAttemptsInvalid($attempts)
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Maximum number of attempts must be a positive value.');

        $this->question->setMaxAttempts($attempts);
    }

    public function testGetMaxAttemptsDefault()
    {
        self::assertNull($this->question->getMaxAttempts());
    }

    public function testGetSetNormalizer()
    {
        $normalizer = function ($input) { return $input; };
        $this->question->setNormalizer($normalizer);
        self::assertSame($normalizer, $this->question->getNormalizer());
    }

    public function testGetNormalizerDefault()
    {
        self::assertNull($this->question->getNormalizer());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      