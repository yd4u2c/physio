ache,
            $this->idGenerator
        );

        return $entity;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

class Swift_Mime_SimpleMessageAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        Swift_Preferences::getInstance()->setCharset(null); //TODO: Test with the charset defined
    }

    public function testBasicHeaders()
    {
        /* -- RFC 2822, 3.6.
     */

        $message = $this->createMessage();
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/plain'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString(),
            '%s: Only required headers, and non-empty headers should be displayed'
            );
    }

    public function testSubjectIsDisplayedIfSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/plain'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testDateCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $id = $message->getId();
        $date = new DateTimeImmutable();
        $message->setDate($date);
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/plain'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testMessageIdCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setId('foo@bar');
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <foo@bar>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/plain'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testContentTypeCanBeChanged()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setContentType('text/html');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/html'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testCharsetCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setContentType('text/html');
        $message->setCharset('iso-8859-1');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/html; charset=iso-8859-1'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testFormatCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFormat('flowed');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/plain; format=flowed'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testEncoderCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setContentType('text/html');
        $message->setEncoder(
            new Swift_Mime_ContentEncoder_PlainContentEncoder('7bit')
            );
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: '."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/html'."\r\n".
            'Content-Transfer-Encoding: 7bit'."\r\n",
            $message->toString()
            );
    }

    public function testFromAddressCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom('chris.corbyn@swiftmailer.org');
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: chris.corbyn@swiftmailer.org'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/plain'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testFromAddressCanBeSetWithName()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom(['chris.corbyn@swiftmailer.org' => 'Chris Corbyn']);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/plain'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }

    public function testMultipleFromAddressesCanBeSet()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn',
            'mark@swiftmailer.org',
            ]);
        $id = $message->getId();
        $date = $message->getDate();
        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>, mark@swiftmailer.org'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/plain'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n",
            $message->toString()
            );
    }
