 */
    public function getMock()
    {
        return $this->_mock;
    }

    /**
     * Flag this expectation as calling the original class method with the
     * any provided arguments instead of using a return value queue.
     *
     * @return self
     */
    public function passthru()
    {
        if ($this->_mock instanceof Mock) {
            throw new Exception(
                'Mock Objects not created from a loaded/existing class are '
                . 'incapable of passing method calls through to a parent class'
            );
        }
        $this->_passthru = true;
        return $this;
    }

    /**
     * Cloning logic
     *
     */
    public function __clone()
    {
        $newValidators = array();
        $countValidators = $this->_countValidators;
        foreach ($countValidators as $validator) {
            $newValidators[] = clone $validator;
        }
        $this->_countValidators = $newValidators;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getExceptionMessage()
    {
        return $this->_because;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              