turn $this->argumentsWildcard;
    }

    /**
     * @return bool
     */
    public function hasReturnVoid()
    {
        return $this->voidReturnType;
    }

    private function bindToObjectProphecy()
    {
        if ($this->bound) {
            return;
        }

        $this->getObjectProphecy()->addMethodProphecy($this);
        $this->bound = true;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  