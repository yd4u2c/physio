<?php

class Swift_Plugins_Reporters_HitReporterTest extends \PHPUnit\Framework\TestCase
{
    private $hitReporter;
    private $message;

    protected function setUp()
    {
        $this->hitReporter = new Swift_Plugins_Reporters_HitReporter();
        $this->message = $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();
    }

    public function testReportingFail()
    {
        $this->hitReporter->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->assertEquals(['foo@bar.tld'],
            $this->hitReporter->getFailedRecipients()
            );
    }

    public function testMultipleReports()
    {
        $this->hitReporter->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->hitReporter->notify($this->message, 'zip@button',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->assertEquals(['foo@bar.tld', 'zip@button'],
            $this->hitReporter->getFailedRecipients()
            );
    }

    public function testReportingPassIsIgnored()
    {
        $this->hitReporter->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->hitReporter->notify($this->message, 'zip@button',
            Swift_Plugins_Reporter::RESULT_PASS
            );
        $this->assertEquals(['foo@bar.tld'],
            $this->hitReporter->getFailedRecipients()
            );
    }

    public function testBufferCanBeCleared()
    {
        $this->hitReporter->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->hitReporter->notify($this->message, 'zip@button',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->assertEquals(['foo@bar.tld', 'zip@button'],
            $this->hitReporter->getFailedRecipients()
            );
        $this->hitReporter->clear();
        $this->assertEquals([], $this->hitReporter->getFailedRecipients());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

class Swift_Plugins_Reporters_HtmlReporterTest extends \PHPUnit\Framework\TestCase
{
    private $html;
    private $message;

    protected function setUp()
    {
        $this->html = new Swift_Plugins_Reporters_HtmlReporter();
        $this->message = $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();
    }

    public function testReportingPass()
    {
        ob_start();
        $this->html->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_PASS
            );
        $html = ob_get_clean();

        $this->assertRegExp('~ok|pass~i', $html, '%s: Reporter should indicate pass');
        $this->assertRegExp('~foo@bar\.tld~', $html, '%s: Reporter should show address');
    }

    public function testReportingFail()
    {
        ob_start();
        $this->html->notify($this->message, 'zip@button',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $html = ob_get_clean();

        $this->assertRegExp('~fail~i', $html, '%s: Reporter should indicate fail');
        $this->assertRegExp('~zip@button~', $html, '%s: Reporter should show address');
    }

    public function testMultipleReports()
    {
        ob_start();
        $this->html->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_PASS
            );
        $this->html->notify($this->message, 'zip@button',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $html = ob_get_clean();

        $this->assertRegExp('~ok|pass~i', $html, '%s: Reporter should indicate pass');
        $this->assertRegExp('~foo@bar\.tld~', $html, '%s: Reporter should show address');
        $this->assertRegExp('~fail~i', $html, '%s: Reporter should indicate fail');
        $this->assertRegExp('~zip@button~', $html, '%s: Reporter should show address');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

use Egulias\EmailValidator\EmailValidator;

class Swift_Signers_DKIMSignerTest extends \SwiftMailerTestCase
{
    public function testBasicSigningHeaderManipulation()
    {
        $headers = $this->createHeaders();
        $messageContent = 'Hello World';
        $signer = new Swift_Signers_DKIMSigner(file_get_contents(dirname(dirname(dirname(__DIR__))).'/_samples/dkim/dkim.test.priv'), 'dummy.nxdomain.be', 'dummySelector');
        /* @var $signer Swift_Signers_HeaderSigner */
        $altered = $signer->getAlteredHeaders();
        $signer->reset();
        // Headers
        $signer->setHeaders($headers);
        // Body
        $signer->startBody();
        $signer->write($messageContent);
        $signer->endBody();
        // Signing
        $signer->addSignature($headers);
    }

    // SHA1 Signing
    public function testSigningSHA1()
    {
        $headerSet = $this->createHeaderSet();
        $messageContent = 'Hello World';
        $signer = new Swift_Signers_DKIMSigner(file_get_contents(dirname(dirname(dirname(__DIR__))).'/_samples/dkim/dkim.test.priv'), 'dummy.nxdomain.be', 'dummySelector');
        $signer->setHashAlgorithm('rsa-sha1');
        $signer->setSignatureTimestamp('1299879181');
        $altered = $signer->getAlteredHeaders();
        $this->assertEquals(['DKIM-Signature'], $altered);
        $signer->reset();
        $signer->setHeaders($headerSet);
        $this->assertFalse($headerSet->has('DKIM-Signature'));
        $signer->startBody();
        $signer->write($messageContent);
        $signer->endBody();
        $signer->addSignature($headerSet);
        $this->assertTrue($headerSet->has('DKIM-Signature'));
        $dkim = $headerSet->getAll('DKIM-Signature');
        $sig = reset($dkim);
        $this->assertEquals($sig->getValue(), 'v=1; a=rsa-sha1; bh=wlbYcY9O9OPInGJ4D0E/rGsvMLE=; d=dummy.nxdomain.be; h=; i=@dummy.nxdomain.be; s=dummySelector; t=1299879181; b=RMSNelzM2O5MAAnMjT3G3/VF36S3DGJXoPCXR001F1WDReu0prGphWjuzK/m6V1pwqQL8cCNg Hi74mTx2bvyAvmkjvQtJf1VMUOCc9WHGcm1Yec66I3ZWoNMGSWZ1EKAm2CtTzyG0IFw4ml9DI wSkyAFxlgicckDD6FibhqwX4w=');
    }

    // SHA256 Signing
    public function testSigning256()
    {
        $headerSet = $this->createHeaderSet();
        $messageContent = 'Hello World';
        $signer = new Swift_Signers_DKIMSigner(file_get_contents(dirname(dirname(dirname(__DIR__))).'/_samples/dkim/dkim.test.priv'), 'dummy.nxdomain.be', 'dummySelector');
        $signer->setHashAlgorithm('rsa-sha256');
        $signer->setSignatureTimestamp('1299879181');
        $altered = $signer->getAlteredHeaders();
        $this->assertEquals(['DKIM-Signature'], $altered);
        $signer->reset();
        $signer->setHeaders($headerSet);
        $this->assertFalse($headerSet->has('DKIM-Signature'));
        $signer->startBody();
        $signer->write($messageContent);
        $signer->endBody();
        $signer->addSignature($headerSet);
        $this->assertTrue($headerSet->has('DKIM-Signature'));
        $dkim = $headerSet->getAll('DKIM-Signature');
        $sig = reset($dkim);
        $this->assertEquals($sig->getValue(), 'v=1; a=rsa-sha256; bh=f+W+hu8dIhf2VAni89o8lF6WKTXi7nViA4RrMdpD5/U=; d=dummy.nxdomain.be; h=; i=@dummy.nxdomain.be; s=dummySelector; t=1299879181; b=jqPmieHzF5vR9F4mXCAkowuphpO4iJ8IAVuioh1BFZ3VITXZj5jlOFxULJMBiiApm2keJirnh u4mzogj444QkpT3lJg8/TBGAYQPdcvkG3KC0jdyN6QpSgpITBJG2BwWa+keXsv2bkQgLRAzNx qRhP45vpHCKun0Tg9LrwW/KCg=');
    }

    // Relaxed/Relaxed Hash Signing
    public function testSigningRelaxedRelaxed256()
    {
        $headerSet = $this->createHeaderSet();
        $messageContent = 'Hello World';
        $signer = new Swift_Signers_DKIMSigner(file_get_contents(dirname(dirname(dirname(__DIR__))).'/_samples/dkim/dkim.test.priv'), 'dummy.nxdomain.be', 'dummySelector');
        $signer->setHashAlgorithm('rsa-sha256');
        $signer->setSignatureTimestamp('1299879181');
        $signer->setBodyCanon('relaxed');
        $signer->setHeaderCanon('relaxed');
        $altered = $signer->getAlteredHeaders();
        $this->assertEquals(['DKIM-Signature'], $altered);
        $signer->reset();
        $signer->setHeaders($headerSet);
        $this->assertFalse($headerSet->has('DKIM-Signature'));
        $signer->startBody();
        $signer->write($messageContent);
        $signer->endBody();
        $signer->addSignature($headerSet);
        $this->assertTrue($headerSet->has('DKIM-Signature'));
        $dkim = $headerSet->getAll('DKIM-Signature');
        $sig = reset($dkim);
        $this->assertEquals($sig->getValue(), 'v=1; a=rsa-sha256; bh=f+W+hu8dIhf2VAni89o8lF6WKTXi7nViA4RrMdpD5/U=; d=dummy.nxdomain.be; h=; i=@dummy.nxdomain.be; s=dummySelector; c=relaxed/relaxed; t=1299879181; b=gzOI+PX6HpZKQFzwwmxzcVJsyirdLXOS+4pgfCpVHQIdqYusKLrhlLeFBTNoz75HrhNvGH6T0 Rt3w5aTqkrWfUuAEYt0Ns14GowLM7JojaFN+pZ4eYnRB3CBBgW6fee4NEMD5WPca3uS09tr1E 10RYh9ILlRtl+84sovhx5id3Y=');
    }

    // Relaxed/Simple Hash Signing
    public function testSigningRelaxedSimple256()
    {
        $headerSet = $this->createHeaderSet();
        $messageContent = 'Hello World';
        $signer = new Swift_Signers_DKIMSigner(file_get_contents(dirname(dirname(dirname(__DIR__))).'/_samples/dkim/dkim.test.priv'), 'dummy.nxdomain.be', 'dummySelector');
        $signer->setHashAlgorithm('rsa-sha256');
        $signer->setSignatureTimestamp('1299879181');
        $signer->setHeaderCanon('relaxed');
        $altered = $signer->getAlteredHeaders();
        $this->assertEquals(['DKIM-Signature'], $altered);
        $signer->reset();
        $signer->setHeaders($headerSet);
        $this->assertFalse($headerSet->has('DKIM-Signature'));
        $signer->startBody();
        $signer->write($messageContent);
        $signer->endBody();
        $signer->addSignature($headerSet);
        $this->assertTrue($headerSet->has('DKIM-Signature'));
        $dkim = $headerSet->getAll('DKIM-Signature');
        $sig = reset($dkim);
        $this->assertEquals($sig->getValue(), 'v=1; a=rsa-sha256; bh=f+W+hu8dIhf2VAni89o8lF6WKTXi7nViA4RrMdpD5/U=; d=dummy.nxdomain.be; h=; i=@dummy.nxdomain.be; s=dummySelector; c=relaxed; t=1299879181; b=dLPJNec5v81oelyzGOY0qPqTlGnQeNfUNBOrV/JKbStr3NqWGI9jH4JAe2YvO2V32lfPNoby1 4MMzZ6EPkaZkZDDSPa+53YbCPQAlqiD9QZZIUe2UNM33HN8yAMgiWEF5aP7MbQnxeVZMfVLEl 9S8qOImu+K5JZqhQQTL0dgLwA=');
    }

    // Simple/Relaxed Hash Signing
    public function testSigningSimpleRelaxed256()
    {
        $headerSet = $this->createHeaderSet();
        $messageContent = 'Hello World';
        $signer = new Swift_Signers_DKIMSigner(file_get_contents(dirname(dirname(dirname(__DIR__))).'/_samples/dkim/dkim.test.priv'), 'dummy.nxdomain.be', 'dummySelector');
        $signer->setHashAlgorithm('rsa-sha256');
        $signer->setSignatureTimestamp('1299879181');
        $signer->setBodyCanon('relaxed');
        $altered = $signer->getAlteredHeaders();
        $this->assertEquals(['DKIM-Signature'], $altered);
        $signer->reset();
        $signer->setHeaders($headerSet);
        $this->assertFalse($headerSet->has('DKIM-Signature'));
        $signer->startBody();
        $signer->write($messageContent);
        $signer->endBody();
        $signer->addSignature($headerSet);
        $this->assertTrue($headerSet->has('DKIM-Signature'));
        $dkim = $headerSet->getAll('DKIM-Signature');
        $sig = reset($dkim);
        $this->assertEquals($sig->getValue(), 'v=1; a=rsa-sha256; bh=f+W+hu8dIhf2VAni89o8lF6WKTXi7nViA4RrMdpD5/U=; d=dummy.nxdomain.be; h=; i=@dummy.nxdomain.be; s=dummySelector; c=simple/relaxed; t=1299879181; b=M5eomH/zamyzix9kOes+6YLzQZxuJdBP4x3nP9zF2N26eMLG2/cBKbnNyqiOTDhJdYfWPbLIa 1CWnjST0j5p4CpeOkGYuiE+M4TWEZwhRmRWootlPO3Ii6XpbBJKFk1o9zviS7OmXblUUE4aqb yRSIMDhtLdCK5GlaCneFLN7RQ=');
    }

    private function createHeaderSet()
    {
        $cache = new Swift_KeyCache_ArrayKeyCache(new Swift_KeyCache_SimpleKeyCacheInputStream());
        $factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
        $contentEncoder = new Swift_Mime_ContentEncoder_Base64ContentEncoder();

        $headerEncoder = new Swift_Mime_HeaderEncoder_QpHeaderEncoder(new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8'));
        $paramEncoder = new Swift_Encoder_Rfc2231Encoder(new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8'));
        $emailValidator = new EmailValidator();
        $headers = new Swift_Mime_SimpleHeaderSet(new Swift_Mime_SimpleHeaderFactory($headerEncoder, $paramEncoder, $emailValidator));

        return $headers;
    }

    /**
     * @return Swift_Mime_Headers
     */
    private function createHeaders()
    {
        $x = 0;
        $cache = new Swift_KeyCache_ArrayKeyCache(new Swift_KeyCache_SimpleKeyCacheInputStream());
        $factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
        $contentEncoder = new Swift_Mime_ContentEncoder_Base64ContentEncoder();

        $headerEncoder = new Swift_Mime_HeaderEncoder_QpHeaderEncoder(new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8'));
        $paramEncoder = new Swift_Encoder_Rfc2231Encoder(new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8'));
        $emailValidator = new EmailValidator();
        $headerFactory = new Swift_Mime_SimpleHeaderFactory($headerEncoder, $paramEncoder, $emailValidator);
        $headers = $this->getMockery('Swift_Mime_SimpleHeaderSet');

        $headers->shouldReceive('listAll')
                ->zeroOrMoreTimes()
                ->andReturn(['From', 'To', 'Date', 'Subject']);
        $headers->shouldReceive('has')
                ->zeroOrMoreTimes()
                ->with('From')
                ->andReturn(true);
        $headers->shouldReceive('getAll')
                ->zeroOrMoreTimes()
                ->with('From')
                ->andReturn([$headerFactory->createMailboxHeader('From', 'test@test.test')]);
        $headers->shouldReceive('has')
                ->zeroOrMoreTimes()
                ->with('To')
                ->andReturn(true);
        $headers->shouldReceive('getAll')
                ->zeroOrMoreTimes()
                ->with('To')
                ->andReturn([$headerFactory->createMailboxHeader('To', 'test@test.test')]);
        $headers->shouldReceive('has')
                ->zeroOrMoreTimes()
                ->with('Date')
                ->andReturn(true);
        $headers->shouldReceive('getAll')
                ->zeroOrMoreTimes()
                ->with('Date')
                ->andReturn([$headerFactory->createTextHeader('Date', 'Fri, 11 Mar 2011 20:56:12 +0000 (GMT)')]);
        $headers->shouldReceive('has')
                ->zeroOrMoreTimes()
                ->with('Subject')
                ->andReturn(true);
        $headers->shouldReceive('getAll')
                ->zeroOrMoreTimes()
                ->with('Subject')
                ->andReturn([$headerFactory->createTextHeader('Subject', 'Foo Bar Text Message')]);
        $headers->shouldReceive('addTextHeader')
                ->zeroOrMoreTimes()
                ->with('DKIM-Signature', \Mockery::any())
                ->andReturn(true);
        $headers->shouldReceive('getAll')
                ->zeroOrMoreTimes()
                ->with('DKIM-Signature')
                ->andReturn([$headerFactory->createTextHeader('DKIM-Signature', 'Foo Bar Text Message')]);

        return $headers;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/**
 * @todo
 */
class Swift_Signers_OpenDKIMSignerTest extends \SwiftMailerTestCase
{
    protected function setUp()
    {
        if (!extension_loaded('opendkim')) {
            $this->markTestSkipped(
                'Need OpenDKIM extension run these tests.'
             );
        }
    }

    public function testBasicSigningHeaderManipulation()
    {
    }

    // Default Signing
    public function testSigningDefaults()
    {
    }

    // SHA256 Signing
    public function testSigning256()
    {
    }

    // Relaxed/Relaxed Hash Signing
    public function testSigningRelaxedRelaxed256()
    {
    }

    // Relaxed/Simple Hash Signing
    public function testSigningRelaxedSimple256()
    {
    }

    // Simple/Relaxed Hash Signing
    public function testSigningSimpleRelaxed256()
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

class Swift_Signers_SMimeSignerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Swift_StreamFilters_StringReplacementFilterFactory
     */
    protected $replacementFactory;

    protected $samplesDir;

    protected function setUp()
    {
        $this->replacementFactory = Swift_DependencyContainer::getInstance()
            ->lookup('transport.replacementfactory');

        $this->samplesDir = str_replace('\\', '/', realpath(__DIR__.'/../../../_samples/')).'/';
    }

    public function testUnSignedMessage()
    {
        $message = (new Swift_Message('Wonderful Subject'))
          ->setFrom(['john@doe.com' => 'John Doe'])
          ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
          ->setBody('Here is the message itself');

        $this->assertEquals('Here is the message itself', $message->getBody());
    }

    public function testSignedMessage()
    {
        $message = (new Swift_Message('Wonderful Subject'))
          ->setFrom(['john@doe.com' => 'John Doe'])
          ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
          ->setBody('Here is the message itself');

        $signer = new Swift_Signers_SMimeSigner();
        $signer->setSignCertificate($this->samplesDir.'smime/sign.crt', $this->samplesDir.'smime/sign.key');
        $message->attachSigner($signer);

        $messageStream = $this->newFilteredStream();
        $message->toByteStream($messageStream);
        $messageStream->commit();

        $entityString = $messageStream->getContent();
        $headers = self::getHeadersOfMessage($entityString);

        if (!($boundary = $this->getBoundary($headers['content-type']))) {
            return false;
        }

        $expectedBody = <<<OEL
This is an S/MIME signed message

--$boundary
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: quoted-printable

Here is the message itself
--$boundary
Content-Type: application/(x\-)?pkcs7-signature; name="smime\.p7s"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename="smime\.p7s"

(?:^[a-zA-Z0-9\/\\r\\n+]*={0,2})

--$boundary--
OEL;
        $this->assertValidVerify($expectedBody, $messageStream);
        unset($messageStream);
    }

    public function testSignedMessageWithFullyWrappedMessage()
    {
        $message = (new Swift_Message('Middle-out compression secrets'))
          ->setFrom(['richard@piedpiper.com' => 'Richard Hendricks'])
          ->setTo(['jared@piedpiper.com' => 'Jared Dun