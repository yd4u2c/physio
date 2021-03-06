f arguments.
             */
            if ($name === '$' || $name === '$...') {
                $name = '$arg' . $i;
            }

            if ($parameter->isVariadic()) {
                if ($forCall) {
                    continue;
                }

                $name = '...' . $name;
            }

            $nullable        = '';
            $default         = '';
            $reference       = '';
            $typeDeclaration = '';

            if (!$forCall) {
                if ($parameter->hasType() && $parameter->allowsNull()) {
                    $nullable = '?';
                }

                if ($parameter->hasType() && (string) $parameter->getType() !== 'self') {
                    $typeDeclaration = $parameter->getType() . ' ';
                } else {
                    try {
                        $class = $parameter->getClass();
                    } catch (ReflectionException $e) {
                        throw new RuntimeException(
                            \sprintf(
                                'Cannot mock %s::%s() because a class or ' .
                                'interface used in the signature is not loaded',
                                $method->getDeclaringClass()->getName(),
                                $method->getName()
                            ),
                            0,
                            $e
                        );
                    }

                    if ($class !== null) {
                        $typeDeclaration = $class->getName() . ' ';
                    }
                }

                if (!$parameter->isVariadic()) {
                    if ($parameter->isDefaultValueAvailable()) {
                        $value = $parameter->getDefaultValueConstantName();

                        if ($value === null) {
                            $value = \var_export($parameter->getDefaultValue(), true);
                        } elseif (!\defined($value)) {
                            $rootValue = \preg_replace('/^.*\\\\/', '', $value);
                            $value     = \defined($rootValue) ? $rootValue : $value;
                        }

                        $default = ' = ' . $value;
                    } elseif ($parameter->isOptional()) {
                        $default = ' = null';
                    }
                }
            }

            if ($parameter->isPassedByReference()) {
                $reference = '&';
            }

            $parameters[] = $nullable . $typeDeclaration . $reference . $name . $default;
        }

        return \implode(', ', $parameters);
    }
}
                                                                                                                                                                                                                                                                                                                          