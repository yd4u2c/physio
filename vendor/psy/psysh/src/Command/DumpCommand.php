dent = '  ')
    {
        return $indent . \str_replace("\n", "\n" . $indent, $text);
    }

    /**
     * Convert underscored or whitespace separated words into sentence case.
     *
     * @param string $text
     *
     * @return string
     */
    private static function inflect($text)
    {
        $words = \trim(\preg_replace('/[\s_-]+/', ' ', \preg_replace('/([a-z])([A-Z])/', '$1 $2', $text)));

        return \implode(' ', \array_map('ucfirst', \explode(' ', $words)));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             