<?php

require_once 'swift_required.php';
require_once __DIR__.'/Mime/SimpleMessageAcceptanceTest.php';

class Swift_MessageAcceptanceTest extends Swift_Mime_SimpleMessageAcceptanceTest
{
    public function testAddPartWrapper()
    {
        $message = $this->createMessage();
        $message->setSubject('just a test subject');
        $message->setFrom([
            'chris.corbyn@swiftmailer.org' => 'Chris Corbyn', ]);

        $id = $message->getId();
        $date = $message->getDate();
        $boundary = $message->getBoundary();

        $message->addPart('foo', 'text/plain', 'iso-8859-1');
        $message->addPart('test <b>foo</b>', 'text/html', 'iso-8859-1');

        $this->assertEquals(
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date->format('r')."\r\n".
            'Subject: just a test subject'."\r\n".
            'From: Chris Corbyn <chris.corbyn@swiftmailer.org>'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: multipart/alternative;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: text/plain; charset=iso-8859-1'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foo'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: text/html; charset=iso-8859-1'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'test <b>foo</b>'.
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n",
            $message->toString()
            );
    }

    protected function createMessage()
    {
        Swift_DependencyContainer::getInstance()
            ->register('properties.charset')->asValue(null);

        return new Swift_Message();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           INDX( 	 *�             (   �  �                             6+     � z     5+     iö�pk� D��f��Hn���<�iö�pk�                     A t t a c h m e n t A c c e p t a n c e T e s t . p h p       ;+     h V     5+     @t��pk����W^%�@t��pk�@t��pk�                       
 B y t e S t r e a m C =+     � n     5+     f���pk�C��W^%�f���pk�f���pk�                        C h a r a c t e r R e a d e r F a c t o r y e 7+     � �     5+     !���pk� D��f��Ъ��<�!���pk�x      v             % D e p e n d e n c y C o n t a i n e r A c c e p t a n c e T e s t . p h p     8+     � ~     5+     `��pk� D��f���2���<�`��pk�(      "               E m b e d d e d F i l e A c c e p t a n c e T e s t . p h p   ?+     ` P     5+     �$��pk�vJ X^%��$��pk��$��pk�                        E n c o d e r C+     h R     5+     ���pk�_�X^%����pk����pk�                        K e y C a c h e c c e 9+     � t     5+     ˯��pk� D��f��d����<�˯��pk�       E              M e s s a g