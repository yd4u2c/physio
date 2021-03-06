dinal), $encoder->encodeString(\chr($ordinal), 'iso-8859-1'));
        }
    }

    public function testFirstLineLengthCanBeDifferent()
    {
        $encoder = new QpEncoder();
        $input = str_repeat('a', 140);
        $output = '';
        for ($i = 0; $i < 140; ++$i) {
            // we read 4 chars at a time (max is 54 for the first line and 75 for the second one)
            if (13 * 4 == $i || 13 * 4 + 18 * 4 == $i) {
                $output .= "=\r\n";
            }
            $output .= 'a';
        }
        $this->assertEquals($output, $encoder->encodeString($input, 'utf-8', 22), 'First line should start at offset 22 so can only have max length 54');
    }

    public function testTextIsPreWrapped()
    {
        $encoder = new QpEncoder();
        $input = str_repeat('a', 70)."\r\n".str_repeat('a', 70)."\r\n".str_repeat('a', 70);
        $this->assertEquals($input, $encoder->encodeString($input));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                          