node.
     *  * 'startFilePos'  => Offset into the code string of the first character that is part of the node.
     *  * 'endFilePos'    => Offset into the code string of the last character that is part of the node.
     *
     * @param mixed $value           Variable to store token content in
     * @param mixed $startAttributes Variable to store start attributes in
     * @param mixed $endAttributes   Variable to store end attributes in
     *
     * @return int Token id
     */
    public function getNextToken(&$value = null, &$startAttributes = null, &$endAttributes = null) : int {
        $startAttributes = [];
        $endAttributes   = [];

        while (1) {
            if (isset($this->tokens[++$this->pos])) {
                $token = $this->tokens[$this->pos];
            } else {
                // EOF token with ID 0
                $token = "\0";
            }

            if (isset($this->usedAttributes['startLine'])) {
                $startAttributes['startLine'] = $this->line;
            }
            if (isset($this->usedAttributes['startTokenPos'])) {
                $startAttributes['startTokenPos'] = $this->pos;
            }
            if (isset($this->usedAttributes['startFilePos'])) {
                $startAttributes['startFilePos'] = $this->filePos;
            }

            if (\is_string($token)) {
                $value = $token;
                if (isset($token[1])) {
                    // bug in token_get_all
                    $this->filePos += 2;
                    $id = ord('"');
                } else {
                    $this->filePos += 1;
                    $id = ord($token);
                }
            } elseif (!isset($this->dropTokens[$token[0]])) {
                $value = $token[1];
                $id = $this->tokenMap[$token[0]];
                if (\T_CLOSE_TAG === $token[0]) {
                    $this->prevCloseTagHasNewline = false !== strpos($token[1], "\n");
                } elseif (\T_INLINE_HTML === $token[0]) {
                    $startAttributes['hasLeadingNewline'] = $this->prevCloseTagHasNewline;
                }

                $this->line += substr_count($value, "\n");
                $this->filePos += \strlen($value);
            } else {
                if (\T_COMMENT === $token[0] || \T_DOC_COMMENT === $token[0]) {
                    if (isset($this->usedAttributes['comments'])) {
                        $comment = \T_DOC_COMMENT === $token[0]
                            ? new Comment\Doc($token[1], $this->line, $this->filePos, $this->pos)
                            : new Comment($token[1], $this->line, $this->filePos, $this->pos);
                        $startAttributes['comments'][] = $comment;
                    }
                }

                $this->line += substr_count($token[1], "\n");
                $this->filePos += \strlen($token[1]);
                continue;
            }

            if (isset($this->usedAttributes['endLine'])) {
                $endAttributes['endLine'] = $this->line;
            }
            if (isset($this->usedAttributes['endTokenPos'])) {
                $endAttributes['endTokenPos'] = $this->pos;
            }
            if (isset($this->usedAttributes['endFilePos'])) {
                $endAttributes['endFilePos'] = $this->filePos - 1;
            }

            return $id;
        }

        throw new \RuntimeException('Reached end of lexer loop');
    }

    /**
     * Returns the token array for current code.
     *
     * The token array is in the same format as provided by the
     * token_get_all() function and does not discard tokens (i.e.
     * whitespace and comments are included). The token position
     * attributes are against this token array.
     *
     * @return array Array of tokens in token_get_all() format
     */
    public function getTokens() : array {
        return $this->tokens;
    }

    /**
     * Handles __halt_compiler() by returning the text after it.
     *
     * @return string Remaining text
     */
    public function handleHaltCompiler() : string {
        // text after T_HALT_COMPILER, still including ();
        $textAfter = substr($this->code, $this->filePos);

        // ensure that it is followed by ();
        // this simplifies the situation, by not allowing any comments
        // in between of the tokens.
        if (!preg_match('~^\s*\(\s*\)\s*(?:;|\?>\r?\n?)~', $textAfter, $matches)) {
            throw new Error('__HALT_COMPILER must be followed by "();"');
        }

        // prevent the lexer from returning any further tokens
        $this->pos = count($this->tokens);

        // return with (); removed
        return substr($textAfter, strlen($matches[0]));
    }

    /**
     * Creates the token map.
     *
     * The token map maps the PHP internal token identifiers
     * to the identifiers used by the Parser. Additionally it
     * maps T_OPEN_TAG_WITH_ECHO to T_ECHO and T_CLOSE_TAG to ';'.
     *
     * @return array The token map
     */
    protected function createTokenMap() : array {
        $tokenMap = [];

        // 256 is the minimum possible token number, as everything below
        // it is an ASCII value
        for ($i = 256; $i < 1000; ++$i) {
            if (\T_DOUBLE_COLON === $i) {
                // T_DOUBLE_COLON is equivalent to T_PAAMAYIM_NEKUDOTAYIM
                $tokenMap[$i] = Tokens::T_PAAMAYIM_NEKUDOTAYIM;
            } elseif(\T_OPEN_TAG_WITH_ECHO === $i) {
                // T_OPEN_TAG_WITH_ECHO with dropped T_OPEN_TAG results in T_ECHO
                $tokenMap[$i] = Tokens::T_ECHO;
            } elseif(\T_CLOSE_TAG === $i) {
                // T_CLOSE_TAG is equivalent to ';'
                $tokenMap[$i] = ord(';');
            } elseif ('UNKNOWN' !== $name = token_name($i)) {
                if ('T_HASHBANG' === $name) {
                    // HHVM uses a special token for #! hashbang lines
                    $tokenMap[$i] = Tokens::T_INLINE_HTML;
                } elseif (defined($name = Tokens::class . '::' . $name)) {
                    // Other tokens can be mapped directly
                    $tokenMap[$i] = constant($name);
                }
            }
        }

        // HHVM uses a special token for numbers that overflow to double
        if (defined('T_ONUMBER')) {
            $tokenMap[\T_ONUMBER] = Tokens::T_DNUMBER;
        }
        // HHVM also has a separate token for the __COMPILER_HALT_OFFSET__ constant
        if (defined('T_COMPILER_HALT_OFFSET')) {
            $tokenMap[\T_COMPILER_HALT_OFFSET] = Tokens::T_STRING;
        }

        return $tokenMap;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    