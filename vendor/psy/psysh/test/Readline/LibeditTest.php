        return false;
        }

        return true;
    }

    /**
     * Generate a version 1 UUID from a host ID, sequence number, and the current time.
     *
     * @param int|string $node A 48-bit number representing the hardware address
     *     This number may be represented as an integer or a hexadecimal string.
     * @param int $clockSeq A 14-bit number used to help avoid duplicates that
     *     could arise when the clock is set backwards in time or if the node ID
     *     changes.
     * @return UuidInterface
     * @throws \Ramsey\Uuid\Exception\UnsatisfiedDependencyException if called on a 32-bit system and
     *     `Moontoast\Math\BigNumber` is not present
     * @throws \InvalidArgumentException
     * @throws \Exception if it was not possible to gather sufficient entropy
     */
    public static function uuid1($node = null, $clockSeq = null)
    {
        return self::getFactory()->uuid1($node, $clockSeq);
    }

    /**
     * Generate a version 3 UUID based on the MD5 hash of a namespace identifier
     * (which is a UUID) and a name (which is a string).
     *
     * @param string $ns The UUID namespace in which to create the named UUID
     * @param string $name The name to create a UUID for
     * @return UuidInterface
     * @throws \Ramsey\Uuid\Exception\InvalidUuidStringException
     */
    public static function uuid3($ns, $name)
    {
        return self::getFactory()->uuid3($ns, $name);
    }

    /**
     * Generate a version 4 (random) UUID.
     *
     * @return UuidInterface
     * @throws \Ramsey\Uuid\Exception\UnsatisfiedDependencyException if `Moontoast\Math\BigNumber` is not present
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public static function uuid4()
    {
        return self::getFactory()->uuid4();
    }

    /**
     * Generate a version 5 UUID based on the SHA-1 hash of a namespace
     * identifier (which is a UUID) and a name (which is a string).
     *
     * @param string $ns The UUID namespace in which to create the named UUID
     * @param string $name The name to create a UUID for
     * @return UuidInterface
     * @throws \Ramsey\Uuid\Exception\InvalidUuidStringException
     */
    public static function uuid5($ns, $name)
    {
        return self::getFactory()->uuid5($ns, $name);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       