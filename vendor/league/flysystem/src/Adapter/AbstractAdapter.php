->ordered();
            $mock->shouldReceive('update')->andReturn(NULL)->once()->ordered();

            // ... test code here using the mock
        }
    }

Creating a mock object where all queries occur after startup, but before finish,
and where queries are expected with several different params:

.. code-block:: php

    use \Mockery\Adapter\Phpunit\MockeryTestCase;

    class DbTest extends MockeryTestCase
    {
        public function testOrderedQueries()
        {
            $db = \Mockery::mock('db');
            $db->shouldReceive('startup')->once()->ordered();
            $db->shouldReceive('query')->with('CPWR')->andReturn(12.3)->once()->ordered('queries');
            $db->shouldReceive('query')->with('MSFT')->andReturn(10.0)->once()->ordered('queries');
            $db->shouldReceive('query')->with(\Mockery::pattern("/^....$/"))->andReturn(3.3)->atLeast()->once()->ordered('queries');
            $db->shouldReceive('finish')->once()->ordered();

            // ... test code here using the mock
        }
    }
                                                                                                                                                                                                                                                                                                                              