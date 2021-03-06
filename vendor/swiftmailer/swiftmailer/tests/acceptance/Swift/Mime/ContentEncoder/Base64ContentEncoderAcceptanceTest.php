ects($this->never())
                    ->method('sendPerformed');

        $this->dispatcher->dispatchEvent($evt, 'sendPerformed');
    }

    public function testListenersCanCancelBubblingOfEvent()
    {
        $transport = $this->getMockBuilder('Swift_Transport')->getMock();
        $message = $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();

        $evt = $this->dispatcher->createSendEvent($transport, $message);

        $listenerA = $this->getMockBuilder('Swift_Events_SendListener')->getMock();
        $listenerB = $this->getMockBuilder('Swift_Events_SendListener')->getMock();

        $this->dispatcher->bindEventListener($listenerA);
        $this->dispatcher->bindEventListener($listenerB);

        $listenerA->expects($this->once())
                  ->method('sendPerformed')
                  ->with($evt)
                  ->will($this->returnCallback(function ($object) {
                      $object->cancelBubble(true);
                  }));
        $listenerB->expects($this->never())
                  ->method('sendPerformed');

        $this->dispatcher->dispatchEvent($evt, 'sendPerformed');

        $this->assertTrue($evt->bubbleCancelled());
    }

    private function createDispatcher(array $map)
    {
        return new Swift_Events_SimpleEventDispatcher($map);
    }
}

class DummyListener implements Swift_Events_EventListener
{
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
    }
}
                                                                                                                                                                                                                                                                                                                                            