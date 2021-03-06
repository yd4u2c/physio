count($params[$needle]);

                $params = array_merge(
                    array_slice($params, 0, $needle),
                    $params[$needle],
                    array_slice($params, $needle + 1)
                );

                $types = array_merge(
                    array_slice($types, 0, $needle),
                    $count ?
                        // array needles are at {@link \Doctrine\DBAL\ParameterType} constants
                        // + {@link Doctrine\DBAL\Connection::ARRAY_PARAM_OFFSET}
                        array_fill(0, $count, $types[$needle] - Connection::ARRAY_PARAM_OFFSET) :
                        [],
                    array_slice($types, $needle + 1)
                );

                $expandStr = $count ? implode(', ', array_fill(0, $count, '?')) : 'NULL';
                $query     = substr($query, 0, $needlePos) . $expandStr . substr($query, $needlePos + 1);

                $paramOffset += ($count - 1); // Grows larger by number of parameters minus the replaced needle.
                $queryOffset += (strlen($expandStr) - 1);
            }

            return [$query, $params, $types];
        }

        $queryOffset = 0;
        $typesOrd    = [];
        $paramsOrd   = [];

        foreach ($paramPos as $pos => $paramName) {
            $paramLen = strlen($paramName) + 1;
            $value    = static::extractParam($paramName, $params, true);

            if (! isset($arrayPositions[$paramName]) && ! isset($arrayPositions[':' . $paramName])) {
                $pos         += $queryOffset;
                $queryOffset -= ($paramLen - 1);
                $paramsOrd[]  = $value;
                $typesOrd[]   = static::extractParam($paramName, $types, false, ParameterType::STRING);
                $query        = substr($query, 0, $pos) . '?' . substr($query, ($pos + $paramLen));

                continue;
            }

            $count     = count($value);
            $expandStr = $count > 0 ? implode(', ', array_fill(0, $count, '?')) : 'NULL';

            foreach ($value as $val) {
                $paramsOrd[] = $val;
                $typesOrd[]  = static::extractParam($paramName, $types, false) - Connection::ARRAY_PARAM_OFFSET;
            }

            $pos         += $queryOffset;
            $queryOffset += (strlen($expandStr) - $paramLen);
            $query        = substr($query, 0, $pos) . $expandStr . substr($query, ($pos + $paramLen));
        }

        return [$query, $paramsOrd, $typesOrd];
    }

    /**
     * Slice the SQL statement around pairs of quotes and
     * return string fragments of SQL outside of quoted literals.
     * Each fragment is captured as a 2-element array:
     *
     * 0 => matched fragment string,
     * 1 => offset of fragment in $statement
     *
     * @param string $statement
     *
     * @return mixed[][]
     */
    private static function getUnquotedStatementFragments($statement)
    {
        $literal    = self::ESCAPED_SINGLE_QUOTED_TEXT . '|' .
            self::ESCAPED_DOUBLE_QUOTED_TEXT . '|' .
            self::ESCAPED_BACKTICK_QUOTED_TEXT . '|' .
            self::ESCAPED_BRACKET_QUOTED_TEXT;
        $expression = sprintf('/((.+(?i:ARRAY)\\[.+\\])|([^\'"`\\[]+))(?:%s)?/s', $literal);

        preg_match_all($expression, $statement, $fragments, PREG_OFFSET_CAPTURE);

        return $fragments[1];
    }

    /**
     * @param string $paramName     The name of the parameter (without a colon in front)
     * @param mixed  $paramsOrTypes A hash of parameters or types
     * @param bool   $isParam
     * @param mixed  $defaultValue  An optional default value. If omitted, an exception is thrown
     *
     * @return mixed
     *
     * @throws SQLParserUtilsException
     */
    private static function extractParam($paramName, $paramsOrTypes, $isParam, $defaultValue = null)
    {
        if (array_key_exists($paramName, $paramsOrTypes)) {
            return $paramsOrTypes[$paramName];
        }

        // Hash keys can be prefixed with a colon for compatibility
        if (array_key_exists(':' . $paramName, $paramsOrTypes)) {
            return $paramsOrTypes[':' . $paramName];
        }

        if ($defaultValue !== null) {
            return $defaultValue;
        }

        if ($isParam) {
            throw SQLParserUtilsException::missingParam($paramName);
        }

        throw SQLParserUtilsException::missingType($paramName);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      