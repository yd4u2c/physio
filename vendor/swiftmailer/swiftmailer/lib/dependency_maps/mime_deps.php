 new Swift_ByteStream_ArrayByteStream();

        $message->toByteStream($streamA);
        $message->toByteStream($streamB);

        $this->assertPatternInStream($pattern, $streamA);
        $this->assertPatternInStream($pattern, $streamB);
    }

    public function testWritingMessageToByteStreamTwiceUsingAFileAttachment()
    {
        $message = new Swift_Message();
        $message->setSubject('test subject');
        $message->setTo('user@domain.tld');
        $message->setCc('other@domain.tld');
        $message->setFrom('user@domain.tld');

        $attachment = Swift_Attachment::fromPath($this->attFile);

        $message->attach($attachment);

        $message->setBody('HTML part', 'text/html');

        $id = $message->getId();
        $date = preg_quote($message->getDate()->format('r'), '~');
        $boundary = $message->getBoundary();

        $streamA = new Swift_ByteStream_ArrayByteStream();
        $streamB = new Swift_ByteStream_ArrayByteStream();

        $pattern = '~^'.
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: test subject'."\r\n".
            'From: user@domain.tld'."\r\n".
            'To: user@domain.tld'."\r\n".
            'Cc: other@domain.tld'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: multipart/mixed;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: text/html; charset=utf-8'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'HTML part'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: '.$this->attFileType.'; name='.$this->attFileName."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-Disposition: attachment; filename='.$this->attFileName."\r\n".
            "\r\n".
            preg_quote(base64_encode(file_get_contents($this->attFile)), '~').
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n".
            '$~D'
            ;

        $message->toByteStream($streamA);
        $message->toByteStream($streamB);

        $this->assertPatternInStream($pattern, $streamA);
        $this->assertPatternInStream($pattern, $streamB);
    }

    public function assertPatternInStream($pattern, $stream, $message = '%s')
    {
        $string = '';
        while (false !== $bytes = $stream->read(8192)) {
            $string .= $bytes;
        }
        $this->assertRegExp($pattern, $string, $message);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   INDX( 	 �J�             (   �  �                             \+     p ^     [+     �I�pk� D��f���ھ�<��I�pk�                      B u g 1 1 1 T e s t . p h p   ]+     p ^     [+     �vN�pk� D��f���ھ�<��vN�pk��      �               B u g 1 1 8 T e s t . p h p   ^+     p ^     [+     1X�pk� D��f��#�ܾ�<�1X�pk�       b               B u g 2 0 6 T e s t . p h p   _+     p ^     [+     McZ�pk� D��f���D߾�<�McZ�pk��      �               B u g 2 7 4 T e s t . p h p  `+   