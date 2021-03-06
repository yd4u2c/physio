  $generator->next();
        $this->assertEquals(3, $generator->current());
        $countConstraint->evaluate($generator, '', true);
        $this->assertEquals(null, $generator->current());
    }

    public function testCountTraversable(): void
    {
        $countConstraint = new Count(5);

        // DatePeriod is used as an object that is Traversable but does not
        // implement Iterator or IteratorAggregate. The following ISO 8601
        // recurring time interval will yield five total DateTime objects.
        $datePeriod = new \DatePeriod('R4/2017-05-01T00:00:00Z/P1D');

        $this->assertInstanceOf(\Traversable::class, $datePeriod);
        $this->assertNotInstanceOf(\Iterator::class, $datePeriod);
        $this->assertNotInstanceOf(\IteratorAggregate::class, $datePeriod);
        $this->assertTrue($countConstraint->evaluate($datePeriod, '', true));
    }
}
                                                                                                                                                                                     