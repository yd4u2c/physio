ondition = 'null';
        }

        return sprintf(
            "    [%s, %s, %s, %s, %s, %s, %s],\n",
            self::export(['_route' => $name] + $defaults),
            self::export($vars),
            self::export(array_flip($route->getMethods()) ?: null),
            self::export(array_flip($route->getSchemes()) ?: null),
            self::export($hasTrailingSlash),
            self::export($hasTrailingVar),
            $condition
        );
    }

    private function getExpressionLanguage()
    {
        if (null === $this->expressionLanguage) {
            if (!class_exists('Symfony\Component\ExpressionLanguage\ExpressionLanguage')) {
                throw new \LogicException('Unable to use expressions as the Symfony ExpressionLanguage component is not installed.');
            }
            $this->expressionLanguage = new ExpressionLanguage(null, $this->expressionLanguageProviders);
        }

        return $this->expressionLanguage;
    }

    private function indent($code, $level = 1)
    {
        $code = preg_replace('/ => \[\n    (\[.+),\n\],/', ' => [$1],', $code);

        return preg_replace('/^./m', str_repeat('    ', $level).'$0', $code);
    }

    /**
     * @internal
     */
    public static function export($value): string
    {
        if (null === $value) {
            return 'null';
        }
        if (!\is_array($value)) {
            if (\is_object($value)) {
                throw new \InvalidArgumentException('Symfony\Component\Routing\Route cannot contain objects.');
            }

            return str_replace("\n", '\'."\n".\'', var_export($value, true));
        }
        if (!$value) {
            return '[]';
        }

        $i = 0;
        $export = '[';

        foreach ($value as $k => $v) {
            if ($i === $k) {
                ++$i;
            } else {
                $export .= self::export($k).' => ';

                if (\is_int($k) && $i < $k) {
                    $i = 1 + $k;
                }
            }

            $export .= self::export($v).', ';
        }

        return substr_replace($export, ']', -2);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          