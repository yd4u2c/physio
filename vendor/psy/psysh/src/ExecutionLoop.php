th to edit, null if the input was null, or the value of the referenced variable
     *
     * @throws \InvalidArgumentException If the variable is not found in the current context
     */
    private function extractFilePath($fileArgument)
    {
        // If the file argument was a variable, get it from the context
        if ($fileArgument !== null &&
            \strlen($fileArgument) > 0 &&
            $fileArgument[0] === '$') {
            $fileArgument = $this->context->get(\preg_replace('/^\$/', '', $fileArgument));
        }

        return $fileArgument;
    }

    /**
     * @param string $filePath
     * @param string $shouldRemoveFile
     *
     * @return string
     *
     * @throws \UnexpectedValueException if file_get_contents on $filePath returns false instead of a string
     */
    private function editFile($filePath, $shouldRemoveFile)
    {
        $escapedFilePath = \escapeshellarg($filePath);

        $pipes = [];
        $proc = \proc_open((\getenv('EDITOR') ?: 'nano') . " {$escapedFilePath}", [STDIN, STDOUT, STDERR], $pipes);
        \proc_close($proc);

        $editedContent = @\file_get_contents($filePath);

        if ($shouldRemoveFile) {
            @\unlink($filePath);
        }

        if ($editedContent === false) {
            throw new \UnexpectedValueException("Reading {$filePath} returned false");
        }

        return $editedContent;
    }

    /**
     * Set the Context reference.
     *
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }
}
                                                                                                                              