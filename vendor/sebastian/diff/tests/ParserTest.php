ncoding($oldMbInternalEncoding);
            mb_language($oldMbLanguage);
            throw $e;
        }

        mb_internal_encoding($oldMbInternalEncoding);
        mb_language($oldMbLanguage);
    }

    public function provideNonBinaryMultibyteStrings()
    {
        return array(
            array(implode('', array_map('chr', range(0x09, 0x0d))), 9),
            array(implode('', array_map('chr', range(0x20, 0x7f))), 96),
            array(implode('', array_map('chr', range(0x80, 0xff))), 128),
        );
    }


    /**
     * @dataProvider provideNonBinaryMultibyteStrings
     */
    public function testNonBinaryStringExport($value, $expectedLength)
    {
        $this->assertRegExp(
            "~'.{{$expectedLength}}'\$~s",
            $this->exporter->export($value)
        );
    }

    public function testNonObjectCanBeReturnedAsArray()
    {
        $this->assertEquals(array(true), $this->exporter->toArray(true));
    }

    private function trimNewline($string)
    {
        return preg_replace('/[ ]*\n/', "\n", $string);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php
$header = <<<'EOF'
This file is part of sebastian/global-state.

(c) Sebastian Bergmann <sebastian@phpunit.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(
        [
            'array_syntax' => ['syntax' => 'short'],
            'binary_operator_spaces' => [
                'align_double_arrow' => true,
                'align_equals' => true
            ],
            'blank_line_after_namespace' => true,
            'blank_line_before_return' => true,
            'braces' => true,
            'cast_spaces' => true,
            'concat_space' => ['spacing' => 'one'],
            'elseif' => true,
            'encoding' =>