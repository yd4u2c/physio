nvocation->toString()
                )
            );
        }

        return true;
    }

    /**
     * @throws ExpectationFailedException
     *
     * @return bool
     */
    private function guardAgainstDuplicateEvaluationOfParameterConstraints()
    {
        if ($this->parameterVerificationResult instanceof \Exception) {
            throw $this->parameterVerificationResult;
        }

        return (bool) $this->parameterVerificationResult;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                            