रखति आवश्यकत प्रेरना मुख्यतह हिंदी किएलोग असक्षम कार्यलय करते विवरण किके मानसिक दिनांक पुर्व संसाध एवम् कुशलता अमितकुमार प्रोत्साहित जनित देखने उदेशीत विकसित बलवान ब्रौशर किएलोग विश्लेषण लोगो कैसे जागरुक प्रव्रुति प्रोत्साहित सदस्य आवश्यकत प्रसारन उपलब्धता अथवा हिंदी जनित दर्शाता यन्त्रालय बलवान अतित सहयोग शुरुआत सभीकुछ माहितीवानीज्य लिये खरिदे है।अभी एकत्रित सम्पर्क रिती मुश्किल प्राथमिक भेदनक्षमता विश्व उन्हे गटको द्वारा तकरीबन

विश्व द्वारा व्याख्या सके। आजपर वातावरण व्याख्यान पहोच। हमारी कीसे प्राथमिक विचारशिलता पुर्व करती कम्प्युटर भेदनक्षमता लिये बलवान और्४५० यायेका वार्तालाप सुचना भारत शुरुआत लाभान्वित पढाए संस्था वर्णित मार्गदर्शन चुनने                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Tests\Header;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Header\DateHeader;

class DateHeaderTest extends TestCase
{
    /* --
    The following tests refer to RFC 2822, section 3.6.1 and 3.3.
    */

    public function testGetDateTime()
    {
        $header = new DateHeader('Date', $dateTime = new \DateTimeImmutable());
        $this->assertSame($dateTime, $header->getDateTime());
    }

    public function testDateTimeCanBeSetBySetter()
    {
        $header = new DateHeader('Date', new \DateTimeImmutable());
        $header->setDateTime($dateTime = new \DateTimeImmutable());
        $this->assertSame($dateTime, $header->getDateTime());
    }

    public function testDateTimeIsConvertedToImmutable()
    {
        $dateTime = new \DateTime();
        $header = new DateHeader('Date', $dateTime);
        $this->assertInstanceOf('DateTimeImmutable', $header->getDateTime());
        $this->assertEquals($dateTime->getTimestamp(), $header->getDateTime()->getTimestamp());
        $this->assertEquals($dateTime->getTimezone(), $header->getDateTime()->getTimezone());
    }

    public function testDateTimeIsImmutable()
    {
        $header = new DateHeader('Date', $dateTime = new \DateTime('2000-01-01 12:00:00 Europe/Berlin'));
        $dateTime->setDate(2002, 2, 2);
        $this->assertEquals('Sat, 01 Jan 2000 12:00:00 +0100', $header->getDateTime()->format('r'));
        $this->assertEquals('Sat, 01 Jan 2000 12:00:00 +0100', $header->getBodyAsString());
    }

    public function testDateTimeIsConvertedToRfc2822Date()
    {
        $header = new DateHeader('Date', $dateTime = new \DateTimeImmutable('2000-01-01 12:00:00 Europe/Berlin'));
        $header->setDateTime($dateTime);
        $this->assertEquals('Sat, 01 Jan 2000 12:00:00 +0100', $header->getBodyAsString());
    }

    public function testSetBody()
    {
        $header = new DateHeader('Date', $dateTime = new \DateTimeImmutable());
        $header->setBody($dateTime);
        $this->assertEquals($dateTime->format('r'), $header->getBodyAsString());
    }

    public function testGetBody()
    {
        $header = new DateHeader('Date', $dateTime = new \DateTimeImmutable());
        $header->setDateTime($dateTime);
        $this->assertEquals($dateTime, $header->getBody());
    }

    public function testToString()
    {
        $header = new DateHeader('Date', $dateTime = new \DateTimeImmutable('2000-01-01 12:00:00 Europe/Berlin'));
        $header->setDateTime($dateTime);
        $this->assertEquals('Date: Sat, 01 Jan 2000 12:00:00 +0100', $header->toString());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Tests\Header;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Header\IdentificationHeader;
use Symfony\Component\Mime\Header\MailboxListHeader;
use Symfony\Component\Mime\Header\UnstructuredHeader;

class HeadersTest extends TestCase
{
    public function testAddMailboxListHeaderDelegatesToFactory()
    {
        $headers = new Headers();
        $headers->addMailboxListHeader('From', ['person@domain']);
        $this->assertNotNull($headers->get('From'));
    }

    public function testAddDateHeaderDelegatesToFactory()
    {
        $dateTime = new \DateTimeImmutable();
        $headers = new Headers();
        $headers->addDateHeader('Date', $dateTime);
        $this->assertNotNull($headers->get('Date'));
    }

    public function testAddTextHeaderDelegatesToFactory()
    {
        $headers = new Headers();
        $headers->addTextHeader('Subject', 'some text');
        $this->assertNotNull($headers->get('Subject'));
    }

    public function testAddParameterizedHeaderDelegatesToFactory()
    {
        $headers = new Headers();
        $headers->addParameterizedHeader('Content-Type', 'text/plain', ['charset' => 'utf-8']);
        $this->assertNotNull($headers->get('Content-Type'));
    }

    public function testAddIdHeaderDelegatesToFactory()
    {
        $headers = new Headers();
        $headers->addIdHeader('Message-ID', 'some@id');
        $this->assertNotNull($headers->get('Message-ID'));
    }

    public function testAddPathHeaderDelegatesToFactory()
    {
        $headers = new Headers();
        $headers->addPathHeader('Return-Path', 'some@path');
        $this->assertNotNull($headers->get('Return-Path'));
    }

    public function testHasReturnsFalseWhenNoHeaders()
    {
        $headers = new Headers();
        $this->assertFalse($headers->has('Some-Header')