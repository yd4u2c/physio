   public function testDataCanBeExportedToByteStream()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );

        $is = new Swift_ByteStream_ArrayByteStream();

        $this->cache->exportToByteStream($this->key1, 'foo', $is);

        $string = '';
        while (false !== $bytes = $is->read(8192)) {
            $string .= $bytes;
        }

        $this->assertEquals('test', $string);
    }

    public function testKeyCanBeCleared()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->assertTrue($this->cache->hasKey($this->key1, 'foo'));
        $this->cache->clearKey($this->key1, 'foo');
        $this->assertFalse($this->cache->hasKey($this->key1, 'foo'));
    }

    public function testNsKeyCanBeCleared()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->cache->setString(
            $this->key1, 'bar', 'xyz', Swift_KeyCache::MODE_WRITE
            );
        $this->assertTrue($this->cache->hasKey($this->key1, 'foo'));
        $this->assertTrue($this->cache->hasKey($this->key1, 'bar'));
        $this->cache->clearAll($this->key1);
        $this->assertFalse($this->cache->hasKey($this->key1, 'foo'));
        $this->assertFalse($this->cache->hasKey($this->key1, 'bar'));
    }

    public function testKeyCacheInputStream()
    {
        $is = $this->cache->getInputByteStream($this->key1, 'foo');
        $is->write('abc');
        $is->write('xyz');
        $this->assertEquals('abcxyz', $this->cache->getString($this->key1, 'foo'));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

use Egulias\EmailValidator\EmailValidator;

class Swift_Mime_AttachmentAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $contentEncoder;
    private $cache;
    private $headers;
    private $emailValidator;

    protected function setUp()
    {
        $this->cache = new Swift_KeyCache_ArrayKeyCache(
            new Swift_KeyCache_SimpleKeyCacheInputStream()
            );
        $factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
        $this->contentEncoder = new Swift_Mime_ContentEncoder_Base64ContentEncoder();

        $headerEncoder = new Swift_Mime_HeaderEncoder_QpHeaderEncoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
            );
        $paramEncoder = new Swift_Encoder_Rfc2231Encoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
            );
        $this->emailValidator = new EmailValidator();
        $this->idGenerator = new Swift_Mime_IdGenerator('example.com');
        $this->headers = new Swift_Mime_SimpleHeaderSet(
            new Swift_Mime_SimpleHeaderFactory($headerEncoder, $paramEncoder, $this->emailValidator)
            );
    }

    public function testDispositionIsSetInHeader()
    {
        $attachment = $this->createAttachment();
        $attachment->setContentType('application/pdf');
        $attachment->setDisposition('inline');
        $this->assertEquals(
            'Content-Type: application/pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-Disposition: inline'."\r\n",
            $attachment->toString()
            );
    }

    public function testDispositionIsAttachmentByDefault()
    {
        $attachment = $this->createAttachment();
        $attachment->setContentType('application/pdf');
        $this->assertEquals(
            'Content-Type: application/pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-Disposition: attachment'."\r\n",
            $attachment->toString()
            );
    }

    public function testFilenameIsSetInHeader()
    {
        $attachment = $this->createAttachment();
        $attachment->setContentType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $this->assertEquals(
            'Content-Type: application/pdf; name=foo.pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-Disposition: attachment; filename=foo.pdf'."\r\n",
            $attachment->toString()
            );
    }

    public function testSizeIsSetInHeader()
    {
        $attachment = $this->createAttachment();
        $attachment->setContentType('application/pdf');
        $attachment->setSize(12340);
        $this->assertEquals(
            'Content-Type: application/pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-Disposition: attachment; size=12340'."\r\n",
            $attachment->toString()
            );
    }

    public function testMultipleParametersInHeader()
    {
        $attachment = $this->createAttachment();
        $attachment->setContentType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $attachment->setSize(12340);
        $this->assertEquals(
            'Content-Type: application/pdf; name=foo.pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-Disposition: attachment; filename=foo.pdf; size=12340'."\r\n",
            $attachment->toString()
            );
    }

    public function testEndToEnd()
    {
        $attachment = $this->createAttachment();
        $attachment->setContentType('application/pdf');
        $attachment->setFilename('foo.pdf');
        $attachment->setSize(12340);
        $attachment->setBody('abcd');
        $this->assertEquals(
            'Content-Type: application/pdf; name=foo.pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-Disposition: attachment; filename=foo.pdf; size=12340'."\r\n".
            "\r\n".
            base64_encode('abcd'),
            $attachment->toString()
            );
    }

    protected function createAttachment()
    {
        $entity = new Swift_Mime_Attachment(
            $this->headers,
            $this->contentEncoder,
            $this->cache,
            $this->idGenerator
            );

        return $entity;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

use Egulias\EmailValidator\EmailValidator;

class Swift_Mime_EmbeddedFileAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $contentEncoder;
    private $cache;
    private $headers;
    private $emailValidator;

    protected function setUp()
    {
        $this->cache = new Swift_KeyCache_ArrayKeyCache(
            new Swift_KeyCache_SimpleKeyCacheInputStream()
            );
        $factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
        $this->contentEncoder = new Swift_Mime_ContentEncoder_Base64ContentEncoder();

        $headerEncoder = new Swift_Mime_HeaderEncoder_QpHeaderEncoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
            );
        $paramEncoder = new Swift_Encoder_Rfc2231Encoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
            );
        $this->emailValidator = new EmailValidator();
        $this->idGenerator = new Swift_Mime_IdGenerator('example.com');
        $this->headers = new Swift_Mime_SimpleHeaderSet(
            new Swift_Mime_SimpleHeaderFactory($headerEncoder, $paramEncoder, $this->emailValidator)
            );
    }

    public function testContentIdIsSetInHeader()
    {
        $file = $this->createEmbeddedFile();
        $file->setContentType('application/pdf');
        $file->setId('foo@bar');
        $this->assertEquals(
            'Content-Type: application/pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-ID: <foo@bar>'."\r\n".
            'Content-Disposition: inline'."\r\n",
            $file->toString()
            );
    }

    public function testDispositionIsSetInHeader()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setContentType('application/pdf');
        $file->setDisposition('attachment');
        $this->assertEquals(
            'Content-Type: application/pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-ID: <'.$id.'>'."\r\n".
            'Content-Disposition: attachment'."\r\n",
            $file->toString()
            );
    }

    public function testFilenameIsSetInHeader()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setContentType('application/pdf');
        $file->setFilename('foo.pdf');
        $this->assertEquals(
            'Content-Type: application/pdf; name=foo.pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-ID: <'.$id.'>'."\r\n".
            'Content-Disposition: inline; filename=foo.pdf'."\r\n",
            $file->toString()
            );
    }

    public function testSizeIsSetInHeader()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setContentType('application/pdf');
        $file->setSize(12340);
        $this->assertEquals(
            'Content-Type: application/pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-ID: <'.$id.'>'."\r\n".
            'Content-Disposition: inline; size=12340'."\r\n",
            $file->toString()
            );
    }

    public function testMultipleParametersInHeader()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setContentType('application/pdf');
        $file->setFilename('foo.pdf');
        $file->setSize(12340);

        $this->assertEquals(
            'Content-Type: application/pdf; name=foo.pdf'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-ID: <'.$id.'>'."\r\n".
            'Content-Disposition: inline; filename=foo.pdf; size=12340'."\r\n",
            $file->toString()
            );
    }

    public function testEndToEnd()
    {
        $file = $this->createEmbeddedFile();
        $id = $file->getId();
        $file->setContentType('application/pdf');
        $file->setFilename('foo.pdf');
        $file->setSize(12340);
        $file->setBody('abcd');
        $this->assertEquals(
            'Content-Type: app