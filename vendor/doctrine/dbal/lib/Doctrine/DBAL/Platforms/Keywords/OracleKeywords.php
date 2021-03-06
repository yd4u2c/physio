c function hasOption($name)
    {
        return isset($this->_options[$name]);
    }

    /**
     * Returns an option associated with the foreign key constraint.
     *
     * @param string $name Name of the option the foreign key constraint is associated with.
     *
     * @return mixed
     */
    public function getOption($name)
    {
        return $this->_options[$name];
    }

    /**
     * Returns the options associated with the foreign key constraint.
     *
     * @return mixed[]
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Returns the referential action for UPDATE operations
     * on the referenced table the foreign key constraint is associated with.
     *
     * @return string|null
     */
    public function onUpdate()
    {
        return $this->onEvent('onUpdate');
    }

    /**
     * Returns the referential action for DELETE operations
     * on the referenced table the foreign key constraint is associated with.
     *
     * @return string|null
     */
    public function onDelete()
    {
        return $this->onEvent('onDelete');
    }

    /**
     * Returns the referential action for a given database operation
     * on the referenced table the foreign key constraint is associated with.
     *
     * @param string $event Name of the database operation/event to return the referential action for.
     *
     * @return string|null
     */
    private function onEvent($event)
    {
        if (isset($this->_options[$event])) {
            $onEvent = strtoupper($this->_options[$event]);

            if (! in_array($onEvent, ['NO ACTION', 'RESTRICT'])) {
                return $onEvent;
            }
        }

        return false;
    }

    /**
     * Checks whether this foreign key constraint intersects the given index columns.
     *
     * Returns `true` if at least one of this foreign key's local columns
     * matches one of the given index's columns, `false` otherwise.
     *
     * @param Index $index The index to be checked against.
     *
     * @return bool
     */
    public function intersectsIndexColumns(Index $index)
    {
        foreach ($index->getColumns() as $indexColumn) {
            foreach ($this->_localColumnNames as $localColumn) {
                if (strtolower($indexColumn) === strtolower($localColumn->getName())) {
                    return true;
                }
            }
        }

        return false;
    }
}
                                                                                                                                                                                                                                                                                                                          