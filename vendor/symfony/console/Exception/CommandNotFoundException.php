When option given doesn't exist
     */
    public function getOption($name);

    /**
     * Sets an option value by name.
     *
     * @param string                    $name  The option name
     * @param string|string[]|bool|null $value The option value
     *
     * @throws InvalidArgumentException When option given doesn't exist
     */
    public function setOption($name, $value);

    /**
     * Returns true if an InputOption object exists by name.
     *
     * @param string $name The InputOption name
     *
     * @return bool true if the InputOption object exists, false otherwise
     */
    public function hasOption($name);

    /**
     * Is this input means interactive?
     *
     * @return bool
     */
    public function isInteractive();

    /**
     * Sets the input interactivity.
     *
     * @param bool $interactive If the input should be interactive
     */
    public function setInteractive($interactive);
}
                                                                                                                                                                                                                                                                                       