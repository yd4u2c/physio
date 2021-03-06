<?php

class Swift_Plugins_ReporterPluginTest extends \SwiftMailerTestCase
{
    public function testReportingPasses()
    {
        $message = $this->createMessage();
        $evt = $this->createSendEvent();
        $reporter = $this->createReporter();

        $message->shouldReceive('getTo')->zeroOrMoreTimes()->andReturn(['foo@bar.tld' => 'Foo']);
        $evt->shouldReceive('getMessage')->zeroOrMoreTimes()->andReturn($message);
        $evt->shouldReceive('getFailedRecipients')->zeroOrMoreTimes()->andReturn([]);
        $reporter->shouldReceive('notify')->once()->with($message, 'foo@bar.tld', Swift_Plugins_Reporter::RESULT_PASS);

        $plugin = new Swift_Plugins_ReporterPlugin($reporter);
        $plugin->sendPerformed($evt);
    }

    public function testReportingFailedTo()
    {
        $message = $this->createMessage();
        $evt = $this->createSendEvent();
        $reporter = $this->createReporter();

        $message->shouldReceive('getTo')->zeroOrMoreTimes()->andReturn(['foo@bar.tld' => 'Foo', 'zip@button' => 'Zip']);
        $evt->shouldReceive('getMessage')->zeroOrMoreTimes()->andReturn($message);
        $evt->shouldReceive('getFailedRecipients')->zeroOrMoreTimes()->andReturn(['zip@button']);
        $reporter->shouldReceive('notify')->once()->with($message, 'foo@bar.tld', Swift_Plugins_Reporter::RESULT_PASS);
        $reporter->shouldReceive('notify')->once()->with($message, 'zip@button', Swift_Plugins_Reporter::RESULT_FAIL);

        $plugin = new Swift_Plugins_ReporterPlugin($reporter);
        $plugin->sendPerformed($evt);
    }

    public function testReportingFailedCc()
    {
        $message = $this->createMessage();
        $evt = $this->createSendEvent();
        $reporter = $this->createReporter();

        $message->shouldReceive('getTo')->zeroOrMoreTimes()->andReturn(['foo@bar.tld' => 'Foo']);
        $message->shouldReceive('getCc')->zeroOrMoreTimes()->andReturn(['zip@button' => 'Zip', 'test@test.com' => 'Test']);
        $evt->shouldReceive('getMessage')->zeroOrMoreTimes()->andReturn($message);
        $evt->shouldReceive('getFailedRecipients')->zeroOrMoreTimes()->andReturn(['zip@button']);
        $reporter->shouldReceive('notify')->once()->with($message, 'foo@bar.tld', Swift_Plugins_Reporter::RESULT_PASS);
        $reporter->shouldReceive('notify')->once()->with($message, 'zip@button', Swift_Plugins_Reporter::RESULT_FAIL);
        $reporter->shouldReceive('notify')->once()->with($message, 'test@test.com', Swift_Plugins_Reporter::RESULT_PASS);

        $plugin = new Swift_Plugins_ReporterPlugin($reporter);
        $plugin->sendPerformed($evt);
    }

    public function testReportingFailedBcc()
    {
        $message = $this->createMessage();
        $evt = $this->createSendEvent();
        $reporter = $this->createReporter();

        $message->shouldReceive('getTo')->zeroOrMoreTimes()->andReturn(['foo@bar.tld' => 'Foo']);
        $message->shouldReceive('getBcc')->zeroOrMoreTimes()->andReturn(['zip@button' => 'Zip', 'test@test.com' => 'Test']);
        $evt->shouldReceive('getMessage')->zeroOrMoreTimes()->andReturn($message);
        $evt->shouldReceive('getFailedRecipients')->zeroOrMoreTimes()->andReturn(['zip@button']);
        $reporter->shouldReceive('notify')->once()->with($message, 'foo@bar.tld', Swift_Plugins_Reporter::RESULT_PASS);
        $reporter->shouldReceive('notify')->once()->with($message, 'zip@button', Swift_Plugins_Reporter::RESULT_FAIL);
        $reporter->shouldReceive('notify')->once()->with($message, 'test@test.com', Swift_Plugins_Reporter::RESULT_PASS);

        $plugin = new Swift_Plugins_ReporterPlugin($reporter);
        $plugin->sendPerformed($evt);
    }

    private function createMessage()
    {
        return $this->getMockery('Swift_Mime_SimpleMessage')->shouldIgnoreMissing();
    }

    private function createSendEvent()
    {
        return $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();
    }

    private function createReporter()
    {
        return $this->getMockery('Swift_Plugins_Reporter')->shouldIgnoreMissing();
    }
}
  <?php

class Swift_Plugins_ThrottlerPluginTest extends \SwiftMailerTestCase
{
    public function testBytesPerMinuteThrottling()
    {
        $sleeper = $this->createSleeper();
        $timer = $this->createTimer();

        //10MB/min
        $plugin = new Swift_Plugins_ThrottlerPlugin(
            10000000, Swift_Plugins_ThrottlerPlugin::BYTES_PER_MINUTE,
            $sleeper, $timer
            );

        $timer->shouldReceive('getTimestamp')->once()->andReturn(0);
        $timer->shouldReceive('getTimestamp')->once()->andReturn(1); //expected 0.6
        $timer->shouldReceive('getTimestamp')->once()->andReturn(1); //expected 1.2 (sleep 1)
        $timer->shouldReceive('getTimestamp')->once()->andReturn(2); //expected 1.8
        $timer->shouldReceive('getTimestamp')->once()->andReturn(2); //expected 2.4 (sleep 1)
        $sleeper->shouldReceive('sleep')->twice()->with(1);

        //10,000,000 bytes per minute
        //100,000 bytes per email

        // .: (10,000,000/100,000)/60 emails per second = 1.667 emais/sec

        $message = $this->createMessageWithByteCount(100000); //100KB

        $evt = $this->createSendEvent($message);

        for ($i = 0; $i < 5; ++$i) {
            $plugin->beforeSendPerformed($evt);
            $plugin->sendPerformed($evt);
        }
    }

    public function 