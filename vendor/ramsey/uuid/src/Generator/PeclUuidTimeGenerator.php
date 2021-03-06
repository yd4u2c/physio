tual);
    }

    public function testRegister(): void
    {
        $comparator = new TestClassComparator;

        $factory = new Factory;
        $factory->register($comparator);

        $a        = new TestClass;
        $b        = new TestClass;
        $expected = 'SebastianBergmann\\Comparator\\TestClassComparator';
        $actual   = $factory->getComparatorFor($a, $b);

        $factory->unregister($comparator);
        $this->assertInstanceOf($expected, $actual);
    }

    public function testUnregister(): void
    {
        $comparator = new TestClassComparator;

        $factory = new Factory;
        $factory->register($comparator);
        $factory->unregister($comparator);

        $a        = new TestClass;
        $b        = new TestClass;
        $expected = 'SebastianBergmann\\Comparator\\ObjectComparator';
        $actual   = $factory->getComparatorFor($a, $b);

        $this->assertInstanceOf($expected, $actual);
    }

    public function testIsSingleton(): void
    {
        $f = Factory::getInstance();
        $this->assertSame($f, Factory::getInstance());
    }
}
                                                     