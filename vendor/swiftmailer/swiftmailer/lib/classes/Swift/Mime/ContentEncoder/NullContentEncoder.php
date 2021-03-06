$this->signatureTimestamp = $time;

        return $this;
    }

    /**
     * Set the signature expiration timestamp.
     *
     * @param int $time
     *
     * @return $this
     */
    public function setSignatureExpiration($time)
    {
        $this->signatureExpiration = $time;

        return $this;
    }

    /**
     * Enable / disable the DebugHeaders.
     *
     * @param bool $debug
     *
     * @return $this
     */
    public function setDebugHeaders($debug)
    {
        $this->debugHeaders = (bool) $debug;

        return $this;
    }

    // Protected

    protected function canonicalizeBody($string)
    {
        if (!$this->peclLoaded) {
            return parent::canonicalizeBody($string);
        }
        if (true === $this->dropFirstLF) {
            if ("\r" == $string[0] && "\n" == $string[1]) {
                $string = substr($string, 2);
            }
        }
        $this->dropFirstLF = false;
        if (strlen($string)) {
            $this->dkimHandler->body($string);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            