$parameter->getDeclaration();
        }
        return implode(', ', $params);
    }

    public function getParameterInvocations()
    {
        if ($this->isVarArgs) {
            return '';
        }
        $params = array();
        foreach ($this->parameters as $parameter) {
            $params[] = $parameter->getInvocation();
        }
        return implode(', ', $params);
    }


    public function getClass()
    {
        return $this->class;
    }

    public function getClassName()
    {
        return $this->class->getName();
    }

    public function getName()
    {
        return $this->reflector->name;
    }

    public function isFactory()
    {
        return count($this->calls) > 0;
    }

    public function getCalls()
    {
        return $this->calls;
    }

    public function acceptsVariableArguments()
    {
        return $this->isVarArgs;
    }

    public function hasParameters()
    {
        return !empty($this->parameters);
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getFullName()
    {
        return $this->getClassName() . '::' . $this->getName();
    }

    public function getCommentText()
    {
        return implode(PHP_EOL, $this->comment);
    }

    public function getComment($indent = '')
    {
        $comment = $indent . '/**';
        foreach ($this->comment as $line) {
            $comment .= PHP_EOL . rtrim($indent . ' * ' . $line);
        }
        $comment .= PHP_EOL . $indent . ' */';
        return $comment;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          