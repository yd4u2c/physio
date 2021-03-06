Header->expects($this->once())
                ->method('setCharset')
                ->with('utf-8');

        $set = $this->createSet($factory);
        $set->addTextHeader('Subject', 'some text');
        $set->addTextHeader('X-Header', 'some text');

        $set->setCharset('utf-8');
    }

    public function testCharsetChangeNotifiesAlreadyExistingHeaders()
    {
        $subject = $this->createHeader('Subject', 'some text');
        $xHeader = $this->createHeader('X-Header', 'some text');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createTextHeader')
                ->with('Subject', 'some text')
                ->will($this->returnValue($subject));
        $factory->expects($this->at(1))
                ->method('createTextHeader')
                ->with('X-Header', 'some text')
                ->will($this->returnValue($xHeader));
        $subject->expects($this->once())
                ->method('setCharset')
                ->with('utf-8');
        $xHeader->expects($this->once())
                ->method('setCharset')
                ->with('utf-8');

        $set = $this->createSet($factory);
        $set->addTextHeader('Subject', 'some text');
        $set->addTextHeader('X-Header', 'some text');

        $set->charsetChanged('utf-8');
    }

    public function testCharsetChangeNotifiesFactory()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('charsetChanged')
                ->with('utf-8');

        $set = $this->createSet($factory);

        $set->setCharset('utf-8');
    }

    private function createSet($factory)
    {
        return new Swift_Mime_SimpleHeaderSet($factory);
    }

    private function createFactory()
    {
        return $this->getMockBuilder('Swift_Mime_SimpleHeaderFactory')->disableOriginalConstructor()->getMock();
    }

    private function createHeader($name, $body = '')
    {
        $header = $this->getMockBuilder('Swift_Mime_Header')->getMock();
        $header->expects($this->any())
               ->method('getFieldName')
               ->will($this->returnValue($name));
        $header->expects($this->any())
               ->method('toString')
               ->will($this->returnValue(sprintf("%s: %s\r\n", $name, $body)));
        $header->expects($this->any())
               ->method('getFieldBody')
               ->will($this->returnValue($body));

        return $header;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php


class Swift_Mime_SimpleMessageTest extends Swift_Mime_MimePartTest
{
    public function testNestingLevelIsSubpart()
    {
        // not relevant
        $this->addToAssertionCount(1);
    }

    public function testNestingLevelIsTop()
    {
        $message = $this->createMessage($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertEquals(
            Swift_Mime_SimpleMimeEntity::LEVEL_TOP, $message->getNestingLevel()
            );
    }

    public function testDateIsReturnedFromHeader()
    {
        $dateTime = new DateTimeImmutable();

        $date = $this->createHeader('Date', $dateTime);
        $message = $this->createMessage(
            $this->createHeaderSet(['Date' => $date]),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertEquals($dateTime, $message->getDate());
    }

    public function testDateIsSetInHeader()
    {
        $dateTime = new DateTimeImmutable();

        $date = $this->createHeader('Date', new DateTimeImmutable(), [], false);
        $date->shouldReceive('setFieldBodyModel')
             ->once()
             ->with($dateTime);
        $date->shouldReceive('setFieldBodyModel')
             ->zeroOrMoreTimes();

        $message = $this->createMessage(
            $this->createHeaderSet(['Date' => $date]),
            $this->createEncoder(), $this->createCache()
            );
        $message->setDate($dateTime);
    }

    public function testDateHeaderIsCreatedIfNonePresent()
    {
        $dateTime = new DateTimeImmutable();

        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('addDateHeader')
                ->once()
                ->with('Date', $dateTime);
        $headers->shouldReceive('addDateHeader')
                ->zeroOrMoreTimes();

        $message = $this->createMessage($headers, $this->createEncoder(),
            $this->createCache()
            );
        $message->setDate($dateTime);
    }

    public function testDateHeaderIsAddedDuringConstruction()
    