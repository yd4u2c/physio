 "%s" at line "%d"',
                $reflectionClass->getName(),
                $file,
                $line
            );

            $error = new UnexpectedValueException($msg, 0, new \Exception($message, $code));
        });

        try {
            unserialize($serializedString);
        } catch (\Exception $exception) {
            restore_error_handler();

            throw new UnexpectedValueException("An exception was raised while trying to instantiate an instance of \"{$reflectionClass->getName()}\" via un-serialization", 0, $exception);
        }

        restore_error_handler();

        if ($error) {
            throw $error;
        }
    }

    /**
     * @param ReflectionClass $reflectionClass
     *
     * @return bool
     */
    private function isInstantiableViaReflection(ReflectionClass $reflectionClass)
    {
        return ! ($reflectionClass->isInternal() && $reflectionClass->isFinal());
    }

    /**
     * Verifies whether the given class is to be considered internal
     *
     * @param ReflectionClass $reflectionClass
     *
     * @return bool
     */
    private function hasInternalAncestors(ReflectionClass $reflectionClass)
    {
        do {
            if ($reflectionClass->isInternal()) {
                return true;
            }
        } while ($reflectionClass = $reflectionClass->getParentClass());

        return false;
    }

    /**
     * Verifies if the given PHP version implements the `Serializable` interface serialization
     * with an incompatible serialization format. If that's the case, use serialization marker
     * "C" instead of "O".
     *
     * @link http://news.php.net/php.internals/74654
     *
     * @param ReflectionClass $reflectionClass
     *
     * @return string the serialization format marker, either self::SERIALIZATION_FORMAT_USE_UNSERIALIZER
     *                or self::SERIALIZATION_FORMAT_AVOID_UNSERIALIZER
     */
    private function getSerializationFormat(ReflectionClass $reflectionClass)
    {
        if ($this->isPhpVersionWithBrokenSerializationFormat()
            && $reflectionClass->implementsInterface('Serializable')
        ) {
            return self::SERIALIZATION_FORMAT_USE_UNSERIALIZER;
        }

        return self::SERIALIZATION_FORMAT_AVOID_UNSERIALIZER;
    }

    /**
     * Checks whether the current PHP runtime uses an incompatible serialization format
     *
     * @return bool
     */
    private function isPhpVersionWithBrokenSerializationFormat()
    {
        return PHP_VERSION_ID === 50429 || PHP_VERSION_ID === 50513;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                