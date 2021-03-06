Copyright (c) 2013-2018 Fabien Potencier

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?xml version="1.0" encoding="UTF-8"?>
<phpunit backupGlobals="false"
         backupStaticAttributes="false"
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false"
         syntaxCheck="false"
         bootstrap="tests/bootstrap.php"
>
    <php>
        <ini name="intl.default_locale" value="en"/>
        <ini name="intl.error_level" value="0"/>
        <ini name="memory_limit" value="-1"/>
        <ini name="error_reporting" value="-1" />
    </php>

    <testsuites>
        <testsuite name="SwiftMailer unit tests">
            <directory>tests/unit</directory>
        </testsuite>
        <testsuite name="SwiftMailer acceptance tests">
            <directory>tests/acceptance</directory>
        </testsuite>
        <testsuite name="SwiftMailer bug">
            <directory>tests/bug</directory>
        </testsuite>
        <testsuite name="SwiftMailer smoke tests">
            <directory>tests/smoke</directory>
        </testsuite>
    </testsuites>

    <listeners>
        <listener class="Symfony\Bridge\PhpUnit\SymfonyTestsListener" />
    </listeners>
</phpunit>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  Message Headers
===============

Sometimes you'll want to add your own headers to a message or modify/remove
headers that are already present. You work with the message's HeaderSet to do
this.

Header Basics
-------------

All MIME entities in Swift Mailer -- including the message itself -- store
their headers in a single object called a HeaderSet. This HeaderSet is
retrieved with the ``getHeaders()`` method.

As mentioned in the previous chapter, everything that forms a part of a message
in Swift Mailer is a MIME entity that is represented by an instance of
``Swift_Mime_SimpleMimeEntity``. This includes -- most notably -- the message
object itself, attachments, MIME parts and embedded images. Each of these MIME
entities consists of a body and a set of headers that describe the body.

For all of the "standard" headers in these MIME entities, such as the
``Content-Type``, there are named methods for working with them, such as
``setContentType()`` and ``getContentType()``. This is because headers are a
moderately complex area of the library. Each header has a slightly different
required structure that it must meet in order to comply with the standards that
govern email (and that are checked by spam blockers etc).

You fetch the HeaderSet from a MIME entity like so::

    $message = new Swift_Message();

    // Fetch the HeaderSet from a Message object
    $headers = $message->getHeaders();

    $attachment = Swift_Attachment::fromPath('document.pdf');

    // Fetch the HeaderSet from an attachment object
    $headers = $attachment->getHeaders();

The job of the HeaderSet is to contain and manage instances of Header objects.
Depending upon the MIME entity the HeaderSet came from, the contents of the
HeaderSet will be different, since an attachment for example has a different
set of headers to those in a message.

You can find out what the HeaderSet contains with a quick loop, dumping out the
names of the headers::

    foreach ($headers->getAll() as $header) {
      printf("%s<br />\n", $header->getFieldName());
    }

    /*
    Content-Transfer-Encoding
    Content-Type
    MIME-Version
    Date
    Message-ID
    From
    Subject
    To
    */

You can also dump out the rendered HeaderSet by calling its ``toString()``
method::

    echo $headers->toString();

    /*
    Message-ID: <1234869991.499a9ee7f1d5e@swift.generated>
    Date: Tue, 17 Feb 2009 22:26:31 +1100
    Subject: Awesome subject!
    From: sender@example.org
    To: recipient@example.org
    MIME-Version: 1.0
    Content-Type: text/plain; charset=utf-8
    Content-Transfer-Encoding: quoted-printable
    */

Where the complexity comes in is when you want to modify an existing header.
This complexity comes from the fact that each header can be of a slightly
different type (such as a Date header, or a header that contains email
addresses, or a header that has key-value parameters on it!). Each header in
the HeaderSet is an instance of ``Swift_Mime_Header``. They all have common
functionality, but knowing exactly what type of header you're working with will
allow you a little more control.

You can determine the type of header by comparing the return value of its
``getFieldType()`` method with the constants ``TYPE_TEXT``,
``TYPE_PARAMETERIZED``, ``TYPE_DATE``, ``TYPE_MAILBOX``, ``TYPE_ID`` and
``TYPE_PATH`` which are defined in ``Swift_Mime_Header``::

    foreach ($headers->getAll() as $header) {
      switch ($header->getFieldType()) {
        case Swift_Mime_Header::TYPE_TEXT: $type = 'text';
          break;
        case Swift_Mime_Header::TYPE_PARAMETERIZED: $type = 'parameterized';
          break;
        case Swift_Mime_Header::TYPE_MAILBOX: $type = 'mailbox';
          break;
        case Swift_Mime_Header::TYPE_DATE: $type = 'date';
          break;
        case Swift_Mime_Header::TYPE_ID: $type = 'ID';
          break;
        case Swift_Mime_Header::TYPE_PATH: $type = 'path';
          break;
      }
      printf("%s: is a %s header<br />\n", $header->getFieldName(), $type);
    }

    /*
    Content-Transfer-Encoding: is a text header
    Content-Type: is a parameterized header
    MIME-Version: is a text header
    Date: is a date header
    Message-ID: is a ID header
    From: is a mailbox header
    Subject: is a text header
    To: is a mailbox header
    */

Headers can be removed from the set, modified within the set, or added to the
set.

The following sections show you how to work with the HeaderSet and explain the
details of each implementation of ``Swift_Mime_Header`` that may exist within
the HeaderSet.

Header Types
------------

Because all headers are modeled on different data (dates, addresses, text!)
there are different types of Header in Swift Mailer. Swift Mailer attempts to
categorize all possible MIME headers into more general groups, defined by a
small number of classes.

Text Headers
~~~~~~~~~~~~

Text headers are the simplest type of Header. They contain textual information
with no special information included within it -- for example the Subject
header in a message.

There's nothing particularly interesting about a text header, though it is
probably the one you'd opt to use if you need to add a custom header to a
message. It represents text just like you'd think it does. If the text contains
characters that are not permitted in a message header (such as new lines, or
non-ascii characters) then the header takes care of encoding the text so that
it can be used.

No header -- including text headers -- in Swift Mailer is vulnerable to
header-injection attacks. Swift Mailer breaks any attempt at header injection
by encoding the dangerous data into a non-dangerous form.

It's easy to add a new text header to a HeaderSet. You do this by calling the
HeaderSet's ``addTextHeader()`` method::

    $message = new Swift_Message();
    $headers = $message->getHeaders();
    $headers->addTextHeader('Your-Header-Name', 'the header value');

Changing the value of an existing text header is done by calling it's
``setValue()`` method::

    $subject = $message->getHeaders()->get('Subject');
    $subject->setValue('new subject');

When output via ``toString()``, a text header produces something like the
following::

    $subject = $message->getHeaders()->get('Subject');
    $subject->setValue('amazing subject line');
    echo $subject->toString();

    /*

    Subject: amazing subject line

    */

If the header contains any characters that are outside of the US-ASCII range
however, they will be encoded. This is nothing to be concerned about since mail
clients will decode them back::

    $subject = $message->getHeaders()->get('Subject');
    $subject->setValue('contains – dash');
    echo $subject->toString();

    /*

    Subject: contains =?utf-8?Q?=E2=80=93?= dash

    */

Parameterized Headers
~~~~~~~~~~~~~~~~~~~~~

Parameterized headers are text headers that contain key-value parameters
following the textual content. The Content-Type header of a message is a
parameterized header since it contains charset information after the content
type.

The parameterized header type is a special type of text header. It extends the
text header by allowing additional information to follow it. All of the methods
from text headers are available in addition to the methods described here.

Adding a parameterized header to a HeaderSet is done by using the
``addParameterizedHeader()`` method which takes a text value like
``addTextHeader()`` but it also accepts an associative array of key-value
parameters::

    $message = new Swift_Message();
    $headers = $message->getHeaders();
    $headers->addParameterizedHeader(
      'Header-Name', 'header value',
      ['foo' => 'bar']
      );

To change the text value of the header, call it's ``setValue()`` method just as
you do with text headers.

To change the parameters in the header, call the header's ``setParameters()``
method or the ``setParameter()`` method (note the pluralization)::

    $type = $message->getHeaders()->get('Content-Type');

    // setParameters() takes an associative array
    $type->setParameters([
      'name' => 'file.txt',
      'charset' => 'iso-8859-1'
    ]);

    // setParameter() takes two args for $key and $value
    $type->setParameter('charset', 'iso-8859-1');

When output via ``toString()``, a parameterized header produces something like
the following::

    $type = $message->getHeaders()->get('Content-Type');
    $type->setValue('text/html');
    $type->setParameter('charset', 'utf-8');

    echo $type->toString();

    /*

    Content-Type: text/html; charset=utf-8

    */

If the header contains any characters that are outside of the US-ASCII range
however, they will be encoded, just like they are for text headers. This is
nothing to be concerned about since mail clients will decode them back.
Likewise, if the parameters contain any non-ascii characters they will be
encoded so that they can be transmitted safely::

    $attachment = new Swift_Attachment();
    $disp = $attachment->getHeaders()->get('Content-Disposition');
    $disp->setValue('attachment');
    $disp->setParameter('filename', 'report–may.pdf');
    echo $disp->toString();

    /*

    Content-Disposition: attachment; filename*=utf-8''report%E2%80%93may.pdf

    */

Date Headers
~~~~~~~~~~~~

Date headers contains an RFC 2822 formatted date (i.e. what PHP's ``date('r')``
returns). They are used anywhere a date or time is needed to be presented as a
message header.

The data on which a date header is modeled as a DateTimeImmutable object. The
object is used to create a correctly structured RFC 2822 formatted date with
timezone such as ``Tue, 17 Feb 2009 22:26:31 +1100``.

The obvious place this header type is used is in the ``Date:`` header of the
message itself.

It's easy to add a new date header to a HeaderSet. You do this by calling the
HeaderSet's ``addDateHeader()`` method::

    $message = new Swift_Message();
    $headers = $message->getHeaders();
    $headers->addDateHeader('Your-Header', new DateTimeImmutable('3 days ago'));

Changing the value of an existing date heade