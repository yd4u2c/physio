quals('a@[1.2.3.4]', $header->getId());
        $this->assertEquals('<a@[1.2.3.4]>', $header->getFieldBody());
    }

    public function testIdRigthIsIdnEncoded()
    {
        $header = $this->getHeader('References');
        $header->setId('a@ä');
        $this->assertEquals('a@ä', $header->getId());
        $this->assertEquals('<a@xn--4ca>', $header->getFieldBody());
    }

    /**
     * @expectedException \Exception
     * @expectedMessageException "b c d" is not valid id-right
     */
    public function testInvalidIdRightThrowsException()
    {
        $header = $this->getHeader('References');
        $header->setId('a@b c d');
    }

    /**
     * @expectedException \Exception
     * @expectedMessageException "abc" is does not contain @
     */
    public function testMissingAtSignThrowsException()
    {
        /* -- RFC 2822, 3.6.4.
     msg-id          =       [CFWS] "<" id-left "@" id-right ">" [CFWS]
     */
        $header = $this->getHeader('References');
        $header->setId('abc');
    }

    public function testSetBodyModel()
    {
        $header = $this->getHeader('Message-ID');
        $header->setFieldBodyModel('a@b');
        $this->assertEquals(['a@b'], $header->getIds());
    }

    public function testGetBodyModel()
    {
        $header = $this->getHeader('Message-ID');
        $header->setId('a@b');
        $this->assertEquals(['a@b'], $header->getFieldBodyModel());
    }

    public function testStringValue()
    {
        $header = $this->getHeader('References');
        $header->setIds(['a@b', 'x@y']);
        $this->assertEquals('References: <a@b> <x@y>'."\r\n", $header->toString());
    }

    private function getHeader($name)
    {
        return new Swift_Mime_Headers_IdentificationHeader($name, new EmailValidator(), new Swift_AddressEncoder_IdnAddressEncoder());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

use Egulias\EmailValidator\EmailValidator;

class Swift_Mime_Headers_MailboxHeaderTest extends \SwiftMailerTestCase
{
    /* -- RFC 2822, 3.6.2 for all tests.
     */

    private $charset = 'utf-8';

    public function testTypeIsMailboxHeader()
    {
        $header = $this->getHeader('To');
        $this->assertEquals(Swift_Mime_Header::TYPE_MAILBOX, $header->getFieldType());
    }

    public function testMailboxIsSetForAddress()
    {
        $header = $this->getHeader('From');
        $header->setAddresses('chris@swiftmailer.org');
        $this->assertEquals(['chris@swiftmailer.org'],
            $header->getNameAddressStrings()
            );
    }

    public function testMailboxIsRenderedForNameAddress()
    {
        $header = $this->getHeader('From');
        $header->setNameAddresses(['chris@swiftmailer.org' => 'Chris Corbyn']);
        $this->assertEquals(
            ['Chris Corbyn <chris@swiftmailer.org>'], $header->getNameAddressStrings()
            );
    }

    public function testAddressCanBeReturnedForAddress()
    {
        $header = $this->getHeader('From');
        $header->setAddresses('chris@swiftmailer.org');
        $this->assertEquals(['chris@swiftmailer.org'], $header->getAddresses());
    }

    public function testAddressCanBeReturnedForNameAddress()
    {
        $header = $this->getHeader('From');
        $header->setNameAddresses(['chris@swiftmailer.org' => 'Chris Corbyn']);
        $this->assertEquals(['chris@swiftmailer.or