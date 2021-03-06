     * @param \DateTimeZone|string|false|null $tz
     *
     * @throws InvalidArgumentException
     *
     * @return static|CarbonInterface|false
     */
    public static function createFromLocaleIsoFormat($format, $locale, $time, $tz = null)
    {
        $time = static::translateTimeString($time, $locale, 'en', CarbonInterface::TRANSLATE_MONTHS | CarbonInterface::TRANSLATE_DAYS | CarbonInterface::TRANSLATE_MERIDIEM);

        return static::createFromIsoFormat($format, $time, $tz, $locale);
    }

    /**
     * Make a Carbon instance from given variable if possible.
     *
     * Always return a new instance. Parse only strings and only these likely to be dates (skip intervals
     * and recurrences). Throw an exception for invalid format, but otherwise return null.
     *
     * @param mixed $var
     *
     * @return static|CarbonInterface|null
     */
    public static function make($var)
    {
        if ($var instanceof DateTimeInterface) {
            return static::instance($var);
        }

        $date = null;

        if (is_string($var)) {
            $var = trim($var);
            $first = substr($var, 0, 1);

            if (is_string($var) && $first !== 'P' && $first !== 'R' && preg_match('/[a-z0-9]/i', $var)) {
                $date = static::parse($var);
            }
        }

        return $date;
    }

    /**
     * Set last errors.
     *
     * @param array $lastErrors
     *
     * @return void
     */
    private static function setLastErrors(array $lastErrors)
    {
        static::$lastErrors = $lastErrors;
    }

    /**
     * {@inheritdoc}
     */
    public static function getLastErrors()
    {
        return static::$lastErrors;
    }
}
                                             