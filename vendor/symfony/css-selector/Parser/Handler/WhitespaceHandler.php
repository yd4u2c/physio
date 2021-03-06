token->isString() || $token->isIdentifier())) {
                throw new ExpressionErrorException('Expected a single string or identifier for :contains(), got '.implode(', ', $arguments));
            }
        }

        return $xpath->addCondition(sprintf(
            'contains(string(.), %s)',
            Translator::getXpathLiteral($arguments[0]->getValue())
        ));
    }

    /**
     * @throws ExpressionErrorException
     */
    public function translateLang(XPathExpr $xpath, FunctionNode $function): XPathExpr
    {
        $arguments = $function->getArguments();
        foreach ($arguments as $token) {
            if (!($token->isString() || $token->isIdentifier())) {
                throw new ExpressionErrorException('Expected a single string or identifier for :lang(), got '.implode(', ', $arguments));
            }
        }

        return $xpath->addCondition(sprintf(
            'lang(%s)',
            Translator::getXpathLiteral($arguments[0]->getValue())
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'function';
    }
}
                                                                           