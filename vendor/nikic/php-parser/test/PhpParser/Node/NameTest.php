   }

    /**
     * Transform the use variables before serialization.
     *
     * @param  array  $data The Closure's use variables
     * @return array
     */
    protected function transformUseVariables($data)
    {
        return $data;
    }

    /**
     * Implementation of Serializable::unserialize()
     *
     * @param   string $data Serialized data
     * @throws SecurityException
     */
    public function unserialize($data)
    {
        ClosureStream::register();

        if (static::$securityProvider !== null) {
            if ($data[0] !== '@') {
                throw new SecurityException("The serialized closure is not signed. ".
                    "Make sure you use a security provider for both serialization and unserialization.");
            }

            $data = json_decode(substr($data, 1), true);

            if (!is_array($data) || !static::$securityProvider->verify($data)) {
                throw new SecurityException("Your serialized closure might have been modified and it's unsafe to be unserialized. " .
                    "Make sure you use the same security provider, with the same settings, " .
                    "both for serialization and unserialization.");
            }

            $data = $data['closure'];
        } elseif ($data[0] === '@') {
            throw new SecurityException("The serialized closure is signed. ".
                "Make sure you use a security provider for both serialization and unserialization.");
        }

        $this->code = \unserialize($data);

        // unset data
        unset($data);

        $this->code['objects'] = array();

        if ($this->code['use']) {
            $this->scope = new ClosureScope();
            $this->code['use'] = $this->resolveUseVariables($this->code['use']);
            $this->mapPointers($this->code['use']);
            extract($this->code['use'], EXTR_OVERWRITE | EXTR_REFS);
            $this->scope = null;
        }

        $this->closure = include(ClosureStream::STREAM_PROTO . '://' . $this->code['function']);

        if($this->code['this'] === $this){
            $this->code['this'] = null;
        }

        if ($this->code['scope'] !== null || $this->code['this'] !== null) {
            $this->closure = $this->closure->bindTo($this->code['this'], $this->code['scope']);
        }

        if(!empty($this->code['objects'])){
            foreach ($this->code['objects'] as $item){
                $item['property']->setValue($item['instance'], $item['object']->getClosure());
            }
        }

        $this->code = $this->code['function'];
    }

    /**
     * Resolve the use variables after unserialization.
     *
     * @param  array  $data The Closure's transformed use variables
     * @return array
     */
    protected function resolveUseVariables($data)
    {
        return $data;
    }

    /**
     * Wraps a closure and sets the serialization context (if any)
     *
     * @param   Closure $closure Closure to be wrapped
     *
     * @return  self    The wrapped closure
     */
    public static function from(Closure $closure)
    {
        if (static::$context === null) {
            $instance = new static($closure);
        } elseif (isset(static::$context->scope[$closure])) {
            $instance = static::$context->scope[$closure];
        } else {
            $instance = new static($closure);
            static::$context->scope[$closure] = $instance;
        }

        return $instance;
    }

    /**
     * Increments the context lock counter or creates a new context if none exist
     */
    public static function enterContext()
    {
        if (static::$context === null) {
            static::$context = new ClosureContext();
        }

        static::$context->locks++;
    }

    /**
     * Decrements the context lock counter and destroy the context when it reaches to 0
     */
    public static function exitContext()
    {
        if (static::$context !== null && !--static::$context->locks) {
            static::$context = null;
        }
    }

    /**
     * @param string $secret
     */
    public static function setSecretKey($secret)
    {
        if(static::$securityProvider === null){
            static::$securityProvider = new SecurityProvider($secret);
        }
    }

    /**
     * @param ISecurityProvider $securityProvider
     */
    public static function addSecurityProvider(ISecurityProvider $securityProvider)
    {
        static::$securityProvider = $securityProvider;
    }

    /**
     * Remove security provider
     */
    public static function removeSecurityProvider()
    {
        static::$securityProvider = null;
    }

    /**
     * @return null|ISecurityProvider
     */
    public static function getSecurityProvider()
    {
        return static::$securityProvider;
    }

    /**
     * Wrap closures
     *
     * @internal
     * @param $data
     * @param ClosureScope|SplObjectStorage|null $storage
     */
    public static function wrapClosures(&$data, SplObjectStorage $storage = null)
    {
        static::enterContext();

        if($storage === null){
            $storage = static::$context->scope;
        }

        if($data instanceof Closure){
            $data = static::from($data);
        } elseif (is_array($data)){
            if(isset($data[self::ARRAY_RECURSIVE_KEY])){
                return;
            }
            $data[self::ARRAY_RECURSIVE_KEY] = true;
            foreach ($data as $key => &$value){
                if($key === self::ARRAY_RECURSIVE_KEY){
                    continue;
                }
                static::wrapClosures($value, $storage);
            }
            unset($value);
            unset($data[self::ARRAY_RECURSIVE_KEY]);
        } elseif($data instanceof \stdClass){
            if(isset($storage[$data])){
                $data = $storage[$data];
                