ning());
    }

    public function testFluidInterface()
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $buf->shouldReceive('setParam')
            ->once()
            ->with('timeout', 30);

        $ref = $smtp
            ->setHost('foo')
            ->setPort(25)
            ->setEncryption('tls')
            ->setTimeout(30)
            ->setPipelining(false)
            ;
        $this->assertEquals($ref, $smtp);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

class Swift_Transport_FailoverTransportTest extends \SwiftMailerTestCase
{
    public function testFirstTransportIsUsed()
    {
        $message1 = $this->getMockery('Swift_Mime_SimpleMessage');
        $message2 = $this->getMockery('Swift_Mime_SimpleMessage');
        $t1 = $this->getMockery('Swift_Transport');
        $t2 = $this->getMockery('Swift_Transport');
        $connectionState = false;

        $t1->shouldReceive('isStarted')
           ->zeroOrMoreTimes()
           ->andReturnUsing(function () use (&$connectionState) {
               return $connectionState;
           });
        $t1->shouldReceive('start')
           ->once()
           ->andReturnUsing(function () use (&$connectionState) {
               if (!$connectionState) {
                   $connectionState = true;
               }
           });
        $t1->shouldReceive('send')
           ->twice()
           ->with(\Mockery::anyOf($message1, $message2), \Mockery::any())
           ->andReturnUsing(function () use (&$connectionState) {
               if ($connectionState) {
                   return 1;
               }
           });
        $t2->shouldReceive('start')->never();
        $t2->shouldReceive('send')->never();

        $transport = $this->getTransport([$t1, $t2]);
        $transport->start();
        $this->assertEquals(1, $transport->send($message1));
        $this->assertEquals(1, $transport->send($message2));
    }

    public function testMessageCanBeTriedOnNextTransportIfExceptionThrown()
    {
        $e = new Swift_TransportException('b0rken');

        $message = $this->getMockery('Swift_Mime_SimpleMessage');
        $t1 = $this->getMockery('Swift_Transport');
        $t2 = $this->getMockery('Swift_Transport');
        $connectionState1 = false;
        $connectionState2 = false;

        $t1->shouldReceive('isStarted')
           ->zeroOrMoreTimes()
           ->andReturnUsing(function () use (&$connectionState1) {
               return $connectionState1;
           });
        $t1->shouldReceive('start')
           ->once()
           ->andReturnUsing(function () use (&$connectionState1) {
               if (!$connectionState1) {
                   $connectionState1 = true;
               }
           });
        $t1->shouldReceive('send')
           ->once()
           ->with($message, \Mockery::any())
           ->andReturnUsing(function () use (&$connectionState1, $e) {
               if ($connectionState1) {
                   throw $e;
               }
           });

        $t2->shouldReceive('isStarted')
           ->zeroOrMoreTimes()
           ->andReturnUsing(function () use (&$connectionState2) {
               return $connectionState2;
           });
        $t2->shouldReceive('start')
           ->once()
           ->andReturnUsing(function () use (&$connectionState2) {
               if (!$connectionState2) {
                   $connectionState2 = true;
               }
           });
        $t2->shouldReceive('send')
           ->once()
           ->with($message, \Mockery::any())
           ->andReturnUsing(function () use (&$connectionState2, $e) {
               if ($connectionState2) {
                   return 1;
               }
           });

        $transport = $this->getTransport([$t1, $t2]);
        $transport->start();
        $this->assertEquals(1, $transport->send($message));
    }

    public function testZeroIsReturnedIfTransportReturnsZero()
    {
        $message = $this->getMockery('Swift_Mime_SimpleMessage')->shouldIgnoreMissing();
        $t1 = $this->getMockery('Swift_Transport')->shouldIgnoreMissing();

        $connectionState = false;
        $t1->shouldReceive('isStarted')
           ->zeroOrMoreTimes()
           ->andReturnUsing(function () use (&$connectionState) {
               return $connectionState;
           });
        $t1->shouldReceive('start')
           ->once()
           ->andReturnUsing(function () use (&$connectionState) {
               if (!$connectionState) {
                   $connectionState = true;
               }
           });
        $testCase = $this;
        $t1->shouldReceive('send')
           ->once()
           ->with($message, \Mockery::any())
           ->andReturnUsing(function () use (&$connectionState, $testCase) {
               if (!$connectionState) {
                   $testCase->fail();
               }

               return 0;
           });

        $transport = $this->getTransport([$t1]);
        $transport->start();
        $this->assertEquals(0, $transport->send($message));
    }

    public function testTransportsWhichThrowExceptionsAreNotRetried()
    {
        $e = new Swift_TransportException('maur b0rken');

        $message1 = $this->getMockery('Swift_Mime_SimpleMessage');
        $message2 = $this->getMockery('Swift_Mime_SimpleMessage');
        $message3 = $this->getMockery('Swift_Mime_SimpleMessage');
        $message4 = $this->getMockery('Swift_Mime_SimpleMessage');
        $t1 = $this->getMockery('Swift_Transport');
        $t2 = $this->getMockery('Swift_Transport');
        $connectionState1 = false;
        $connectionState2 = false;

        $t1->shouldReceive('isStarted')
           ->zeroOrMoreTimes()
           ->andReturnUsing(function () use (&$connectionState1) {
               return $connectionState1;
           });
        $t1->shouldReceive('start')
           ->once()
           ->andReturnUsing(function () use (&$connectionState1) {
               if (!$connectionState1) {
                   $connectionState1 = true;
               }
           });
        $t1->shouldReceive('send')
           ->once()
           ->with($message1, \Mockery::any())
           ->andReturnUsing(function () use (&$connectionState1, $e) {
               if ($connectionState1) {
                   throw $e;
               }
           });
        $t1->shouldReceive('send')
           ->never()
           ->with($message2, \Mockery::any());
        $t1->shouldReceive('send')
           ->never()
           ->with($message3, \Mockery::any());
        $t1->shouldReceive('send')
           ->never()
           ->with($message4, \Mockery::any());

        $t2->shouldReceive('isStarted')
           ->zeroOrMoreTimes()
           ->andReturnUsing(function () use (&$connectionState2) {
               return $connectionState2;
           });
        $t2->shouldReceive('start')
           ->once()
           ->andReturnUsing(function () use (&$connectionState2) {
               if (!$connectionState2) {
                   $connectionState2 = true;
               }
           });
        $t2->shouldReceive('send')
           ->times(4)
           ->with(\Mockery::anyOf($message1, $message2, $message3, $message4), \Mockery::any())
           ->andReturnUsing(function () use (&$connectionState2, $e) {
               if ($connectionState2) {
                   return 1;
               }
           });

        $transport = $this->getTransport([$t1, $t2]);
        $transport->start();
        $this->assertEquals(1, $transport->send($message1));
        $this->assertEquals(1, $transport->send($message2));
        $this->assertEquals(1, $transport->send($message3));
        $this->assertEquals(1, $transport->send($message4));
    }

    public function testExceptionIsThrownIfAllTransportsDie()
    {
        $e = new Swift_TransportException('b0rken');

        $message = $this->getMockery('Swift_Mime_SimpleMessage');
        $t1 = $this->getMockery('Swift_Transport');
        $t2 = $this->getMockery('Swift_Transport');
        $connectionState1 = false;
        $connectionState2 = false;

        $t1->shouldReceive('isStarted')
           ->zeroOrMoreTimes()
           ->andReturnUsing(function () use (&$connectionState1) {
               return $connectionState1;
           });
        $t1->shouldReceive('start')
           ->once()
           ->andReturnUsing(function () use (&$connectionState1) {
               if (!$connectionState1) {
                   $connectionState1 = true;
               }
           });
        $t1->shouldReceive('send')
           ->once()
           ->with($message, \Mockery::any())
           ->andReturnUsing(function () use (&$connectionState1, $e) {
               if ($connectionState1) {
                   throw $e;
               }
           });

        $t2->shouldReceive('isStarted')
           ->zeroOrMoreTimes()
           ->andReturnUsing(function () use (&$connectionState2) {
               return $connectionState2;
           });
        $t2->shouldReceive('start')
           ->once()
           ->andReturnUsing(function () use (&$connectionState2) {
               if (!$connectionState2) {
                   $connectionState2 = true;
               }
           });
        $t2->shouldReceive('send')
           ->once()
           ->with($message, \Mockery::any())
           ->andReturnUsing(function () use (&$connectionState2, $e) {
               if ($connectionState2) {
                   throw $e;
               }
           });

        $transport = $this->getTransport([