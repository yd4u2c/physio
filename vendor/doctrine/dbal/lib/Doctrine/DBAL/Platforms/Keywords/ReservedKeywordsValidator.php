& $other->hasOption('where') && $this->getOption('where') === $other->getOption('where')) {
            return true;
        }

        return ! $this->hasOption('where') && ! $other->hasOption('where');
    }

    /**
     * Returns whether the index has the same column lengths as the other
     */
    private function hasSameColumnLengths(self $other) : bool
    {
        $filter = static function (?int $length) : bool {
            return $length !== null;
        };

        return array_filter($this->options['lengths'] ?? [], $filter)
            === array_filter($other->options['lengths'] ?? [], $filter);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               