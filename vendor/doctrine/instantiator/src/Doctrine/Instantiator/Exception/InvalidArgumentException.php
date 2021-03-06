   {
        if ($this->isNullType($value)) {
            return self::C_NUL;
        }

        if ($this->isValid($value)) {
            return $this->charValue[$value];
        }

        if ($this->isUTF8Invalid($value)) {
            $this->hasInvalidTokens = true;
            return self::INVALID;
        }

        return  self::GENERIC;
    }

    protected function isValid($value)
    {
        if (isset($this->charValue[$value])) {
            return true;
        }

        return false;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isNullType($value)
    {
        if ($value === "\0") {
            return true;
        }

        return false;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isUTF8Invalid($value)
    {
        if (preg_match('/\p{Cc}+/u', $value)) {
            return true;
        }

        return false;
    }

    protected function getModifiers()
    {
        return 'iu';
    }
}
                                                                                                                                                                                                                         