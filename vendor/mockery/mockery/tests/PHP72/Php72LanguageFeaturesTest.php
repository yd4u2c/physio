eof ResettableInterface) {
                $processor->reset();
            }
        }
    }

    /**
     * Gets the default formatter.
     *
     * @return FormatterInterface
     */
    protected function getDefaultFormatter()
    {
        return new LineFormatter();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               