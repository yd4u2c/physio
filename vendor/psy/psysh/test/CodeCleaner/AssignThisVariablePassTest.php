            '->tokenize() parses long options with a value',
            ],
            [
                "--long-option='foo bar'\"another\"",
                [['--long-option=foo baranother', "--long-option='foo bar'\"another\""]],
                '->tokenize() parses long options with a value',
            ],
            [
                'foo -a -ffoo --long bar',
                [
                    ['foo', 'foo -a -ffoo --long bar'],
                    ['-a', '-a -ffoo --long bar'],
                    ['-ffoo', '-ffoo --long bar'],
                    ['--long', '--long bar'],
                    ['bar', 'bar'],
                ],
                '->tokenize() parses when several arguments and options',
            ],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                             