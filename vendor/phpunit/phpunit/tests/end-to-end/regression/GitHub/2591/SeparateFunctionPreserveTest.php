ectationFailedException('message');
        $failure   = new TestFailure($test, $exception);

        $this->assertTrue($failure->isFailure());
    }

    public function testIsFailureFalse(): void
    {
        $test      = new self(__FUNCTION__);
        $exception = new Warning('message');
        $failure   = new TestFailure($test, $exception);

        $this->assertFalse($failure->isFailure());
    }
}
                                                                                                                                                                                                                                                                                            