s->screamedErrors;
        $this->screamedErrors = (int) $levels;
        if (!$replace) {
            $this->screamedErrors |= $prev;
        }

        return $prev;
    }

    /**
     * Re-registers as a PHP error handler if levels changed.
     */
    private function reRegister($prev)
    {
        if ($prev !== $this->thrownErrors | $this->loggedErrors) {
            $handler = set_error_handler('var_dump');
            $handler = \is_array($handler) ? $handler[0] : null;
            restore_error_handler();
            if ($handler === $this) {
                restore_error_handler();
                if ($this->isRoot) {
                    set_error_handler([$this, 'handleError'], $this->thrownErrors | $this->loggedErrors);
                } else {
           