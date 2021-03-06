rd_w=8Frd?= then =?'.$header->getCharset().'?Q?'.
            'w=8Frd?=', $header->toString(),
            'Adjacent encoded words should appear grouped with WSP encoded'
        );
    }

    public function testLanguageInformationAppearsInEncodedWords()
    {
        /* -- RFC 2231, 5.
        5.  Language specification in Encoded Words

        RFC 2047 provides support for non-US-ASCII character sets in RFC 822
        message header comments, phrases, and any unstructured text field.
        This is done by defining an encoded word construct which can appear
        in any of these places.  Given that these are fields intended for
        display, it is sometimes necessary to associate language information
        with encoded words as well as just the character set.  This
        specification extends the definition of an encoded word to allow the
        inclusion of such information.  This is simply done by suffixing the
        character set specification with an asterisk followed by the language
        tag.  For example:

                    From: =?US-ASCII*EN?Q?Keith_Moore?= <moore@cs.utk.edu>
        */

        $value = 'fo'.pack('C', 0x8F).'bar';
        $header = new UnstructuredHeader('Subject', $value);
        $header->setLanguage('en');
        $header->setCharset('iso-8859-1');
        $this->assertEquals('Subject: =?iso-8859-1*en?Q?fo=8Fbar?=', $header->toString());
    }

    public function testSetBody()
    {
        $header = new UnstructuredHeader('X-Test', '');
        $header->setBody('test');
        $this->assertEquals('test', $header->getValue());
    }

    public function testGetBody()
    {
        $header = new UnstructuredHeader('Subject', 'test');
        $this->assertEquals('test', $header->getBody());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of t