      'Hello world' => 6,
                'world' => false,
            );

            return $map[$arg];
        };

        $this->handler->expects($this->exactly(2))
            ->method('fwrite')
            ->will($this->returnCallback($callback));

        $this->writeRecord('Hello world');
    }

    /**
     * @expectedException RuntimeException
     */
    public function testWriteFailsIfStreamTimesOut()
    {
        $this->setMockHandler(array('fwrite', 'streamGetMetadata'));

        $callback = function ($arg) {
            $map = array(
                'Hello world' => 6,
                'world' => 5,
            );

            return $map[$arg];
        };

        $this->handler->expects($this->exactly(1))
            ->method('fwrite')
            ->will($this->returnCallback($callback));
        $this->handler->expects($this->exactly(1))
            ->method('streamGetMetadata')
            ->will($this->returnValue(array('timed_out' => true)));

        $this->writeRecord('Hello world');
    }

    /**
     * @expectedException RuntimeException
     */
    public function testWriteFailsOnIncompleteWrite()
    {
        $this->setMockHandler(array('fwrite', 'streamGetMetadata'));

        $res = $this->res;
        $callback = function ($string) use ($res) {
            fclose($res);

            return strlen('Hello');
        };

        $this->handler->expects($this->exactly(1))
            ->method('fwrite')
            ->will($this->returnCallback($callback));
        $this->handler->expects($this->exactly(1))
            ->method('streamGetMetadata')
            ->will($this->returnValue(array('timed_out' => false)));

        $this->writeRecord('Hello world');
    }

    public function testWriteWithMemoryFile()
    {
        $this->setMockHandler();
        $this->writeRecord('test1');
        $this->writeRecord('test2');
        $this->writeRecord('test3');
        fseek($this->res, 0);
        $this->assertEquals('test1test2test3', fread($this->res, 1024));
    }

    public function testWriteWithMock()
    {
        $this->setMockHandler(array('fwrite'));

        $callback = function ($arg) {
            $map = array(
                'Hello world' => 6,
                'world' => 5,
            );

            return $map[$arg];
        };

        $this->handler->expects($this->exactly(2))
            ->method('fwrite')
            ->will($this->returnCallback($callback));

        $this->writeRecord('Hello world');
    }

    public function testClose()
    {
        $this->setMockHandler();
        $this->writeRecord('Hello world');
        $this->assertInternalType('resource', $this->res);
        $this->handler->close();
        $this->assertFalse(is_resource($this->res), "Expected resource to be closed after closing handler");
    }

    public function testCloseDoesNotClosePersistentSocket()
    {
        $this->setMockHandler();
        $this->handler->setPersistent(true);
        $this->writeRecord('Hello world');
        $this->assertTrue(is_resource($this->res));
        $this->handler->close();
        $this->assertTrue(is_resource($this->res));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testAvoidInfiniteLoopWhenNoDataIsWrittenForAWritingTimeoutSeconds()
    {
        $this->setMockHandler(array('fwrite', 'streamGetMetadata'));

        $this->handler->expects($this->any())
            ->method('fwrite')
            ->will($this->returnValue(0));

        $this->handler->expects($this->any())
            ->method('streamGetMetadata')
            ->will($this->returnValue(array('timed_out' => false)));

        $this->handler->setWritingTimeout(1);

        $this->writeRecord('Hello world');
    }

    private function createHandler($connectionString)
    {
        $this->handler = new SocketHandler($connectionString);
        $this->handler->setFormatter($this->getIdentityFormatter());
    }

    private function writeRecord($string)
    {
        $this->handler->handle($this->getRecord(Logger::WARNING, $string));
    }

    private function setMockHandler(array $methods = array())
    {
        $this->res = fopen('php://memory', 'a');

        