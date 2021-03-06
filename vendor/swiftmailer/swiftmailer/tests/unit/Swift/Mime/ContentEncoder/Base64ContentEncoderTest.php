<?php

class Swift_StreamFilters_StringReplacementFilterFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testInstancesOfStringReplacementFilterAreCreated()
    {
        $factory = $this->createFactory();
        $this->assertInstanceOf(
            'Swift_StreamFilters_StringReplacementFilter',
            $factory->createFilter('a', 'b')
        );
    }

    public function testSameInstancesAreCached()
    {
        $factory = $this->createFactory();
        $filter1 = $factory->createFilter('a', 'b');
        $filter2 = $factory->createFilter('a', 'b');
        $this->assertSame($filter1, $filter2, '%s: Instances should be cached');
    }

    public function testDifferingInstancesAreNotCached()
    {
        $factory = $this->createFactory();
        $filter1 = $factory->createFilter('a', 'b');
        $filter2 = $factory->createFilter('a', 'c');
        $this->assertNotEquals($filter1, $filter2,
            '%s: Differing instances should not be cached'
            );
    }

    private function createFactory()
    {
        return new Swift_StreamFilters_StringReplacementFilterFactory();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

class Swift_StreamFilters_StringReplacementFilterTest extends \PHPUnit\Framework\TestCase
{
    public function testBasicReplacementsAreMade()
    {
        $filter = $this->createFilter('foo', 'bar');
        $this->assertEquals('XbarYbarZ', $filter->filter('XfooYfooZ'));
    }

    public function testShouldBufferReturnsTrueIfPartialMatchAtEndOfBuffer()
    {
        $filter = $this->createFilter('foo', 'bar');
        $this->assertTrue($filter->shouldBuffer('XfooYf'),
            '%s: Filter should buffer since "foo" is the needle and the ending '.
            '"f" could be from "foo"'
            );
    }

    public function testFilterCanMakeMultipleReplacements()
    {
        $filter = $this->createFilter(['a', 'b'], 'foo');
        $this->assertEquals('XfooYfooZ', $filter->filter('XaYbZ'));
    }

    public function testMultipleReplacementsCanBeDifferent()
    {
        $filter = $this->createFilter(['a', 'b'], ['foo', 'zip']);
        $this->assertEquals('XfooYzipZ', $filter->filter('XaYbZ'));
    }

    public function testShouldBufferReturnsFalseIfPartialMatchNotAtEndOfString()
    {
        $filter = $this->createFilter("\r\n", "\n");
        $this->assertFalse($filter->shouldBuffer("foo\r\nbar"),
            '%s: Filter should not buffer since x0Dx0A is the needle and is not at EOF'
            );
    }

    public function testShouldBufferReturnsTrueIfAnyOfMultipleMatchesAtEndOfString()
    {
        $filter = $this->createFilter(['foo', 'zip'], 'bar');
        $this->assertTrue($filter->shouldBuffer('XfooYzi'),
            '%s: Filter should buffer since "zip" is a needle and the ending '.
            '"zi" could be from "zip"'
            );
    }

    public function testShouldBufferReturnsFalseOnEmptyBuffer()
    {
        $filter = $this->createFilter("\r\n", "\n");
        $this->assertFalse($filter->shouldBuffer(''));
    }

    private function createFilter($search, $replace)
    {
        return new Swift_StreamFilters_StringReplacementFilter($search, $replace);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

require_once __DIR__.'/AbstractSmtpTest.php';

abstract class Swift_Transport_AbstractSmtpEventSupportTest extends Swift_Transport_AbstractSmtpTest
{
    public function testRegisterPluginLoadsPluginInEventDispatcher()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $listener = $this->getMockery('Swift_Events_EventListener');
        $smtp = $this->getTransport($buf, $dispatcher);
        $dispatcher->shouldReceive('bindEventListener')
                   ->once()
                   ->with($listener);

        $smtp->registerPlugin($listener);
    }

    public function testSendingDispatchesBeforeSendEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $message = $this->createMessage();
        $smtp = $this->getTransport($buf, $dispatcher);
        $evt = $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();

        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['chris@swiftmailer.org' => null]);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['mark@swiftmailer.org' => 'Mark']);
        $dispatcher->shouldReceive('createSendEvent')
                   ->once()
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'beforeSendPerformed');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->zeroOrMoreTimes()
            ->andReturn(false);

        $this->finishBuffer($buf);
        $smtp->start();
        $this->assertEquals(1, $smtp->send($message));
    }

    public function testSendingDispatchesSendEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $message = $this->createMessage();
        $smtp = $this->getTransport($buf, $dispatcher);
        $evt = $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();

        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['chris@swiftmailer.org' => null]);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['mark@swiftmailer.org' => 'Mark']);
        $dispatcher->shouldReceive('createSendEvent')
                   ->once()
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'sendPerformed');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->zeroOrMoreTimes()
            ->andReturn(false);

        $this->finishBuffer($buf);
        $smtp->start();
        $this->assertEquals(1, $smtp->send($message));
    }

    public function testSendEventCapturesFailures()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createE