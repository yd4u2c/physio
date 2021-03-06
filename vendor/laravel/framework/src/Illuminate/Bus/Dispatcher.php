());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyUserModel'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->userProviderModel()],
            $stub
        );

        return $this;
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('DummyClass', $class, $stub);
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->laravel->getNamespace();
    }

    /**
     * Get the model for the default guard's user provider.
     *
     * @return string|null
     */
    protected function userProviderModel()
    {
        $guard = config('auth.defaults.guard');

        $provider = config("auth.guards.{$guard}.provider");

        return config("auth.providers.{$provider}.model");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               INDX( 	 �r             (     �       h �                  H     p `     G     iP�pk� �H ������<�iP�pk� 0      �                A p p l i c a t i o n . p h p I     h X     G     &�pk� �H ������<�&�pk� @      �>               C o m m a n d . p h p J     p \     G     w�pk� �H ������<�w�pk�       �               c o m p o s e r . j s o n     K     � j     G     A<�pk� �H ��\L��<�A<�pk�                      C o n f i r m a b l e T r a i t . p  p       L     � �     G     n �pk� �H ��\L��<�n �pk�8      2               D e t e c t s A p p l i c a t i o n N a m e s p a c e . p h p Q     ` N     G     +v�pk����pk����pk�+v�pk�                        E v e n t s t M     � j     G     �ůpk� �H ��έ��<��ůpk�        q               G e n e r a t o r C o m m a n d . p h p       N     h V     G     '��pk� �H ��	��<�'��pk�       3              
 L I C E N S E . m d   O     p `     G     ���pk  �H ���r��<����pk�       �               O u t p u t S t y l e . p h p P     h V    