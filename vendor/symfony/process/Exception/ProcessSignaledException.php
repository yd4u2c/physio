etMatcherDumperInstance()
    {
        return new $this->options['matcher_dumper_class']($this->getRouteCollection());
    }

    /**
     * Provides the ConfigCache factory implementation, falling back to a
     * default implementation if necessary.
     *
     * @return ConfigCacheFactoryInterface
     */
    private function getConfigCacheFactory()
    {
        if (null === $this->configCacheFactory) {
            $this->configCacheFactory = new ConfigCacheFactory($this->options['debug']);
        }

        return $this->configCacheFactory;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                               