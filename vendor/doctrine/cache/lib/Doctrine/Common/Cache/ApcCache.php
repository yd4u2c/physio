                 = $types[$name];
                    [$value]               = $this->getBindingInfo($value, $type);
                    $resolvedParams[$name] = $value;
                } else {
                    $resolvedParams[$name] = $value;
                }
            }
        }

        return $resolvedParams;
    }

    /**
     * Creates a new instance of a SQL query builder.
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        return new Query\QueryBuilder($this);
    }

    /**
     * Ping the server
     *
     * When the server is not available the method returns FALSE.
     * It is responsibility of the developer to handle this case
     * and abort the request or reconnect manually:
     *
     * @return bool
     *
     * @example
     *
     *   if ($conn->ping() === false) {
     *      $conn->close();
     *      $conn->connect();
     *   }
     *
     * It is undefined if the underlying driver attempts to reconnect
     * or disconnect when the connection is not available anymore
     * as long it returns TRUE when a reconnect succeeded and
     * FALSE when the connection was dropped.
     */
    public function ping()
    {
        $this->connect();

        if ($this->_conn instanceof PingableConnection) {
            return $this->_conn->ping();
        }

        try {
            $this->query($this->getDatabasePlatform()->getDummySelectSQL());

            return true;
        } catch (DBALException $e) {
            return false;
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                