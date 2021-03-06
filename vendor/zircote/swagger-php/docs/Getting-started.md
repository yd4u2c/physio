rg/latest/json-schema-validation.html#anchor26.
     * @var integer
     */
    public $maxLength;

    /**
     * See http://json-schema.org/latest/json-schema-validation.html#anchor29.
     * @var integer
     */
    public $minLength;

    /**
     * See http://json-schema.org/latest/json-schema-validation.html#anchor33.
     * @var string
     */
    public $pattern;

    /**
     * See http://json-schema.org/latest/json-schema-validation.html#anchor42.
     * @var integer
     */
    public $maxItems;

    /**
     * See http://json-schema.org/latest/json-schema-validation.html#anchor45.
     * @var integer
     */
    public $minItems;

    /**
     * See http://json-schema.org/latest/json-schema-validation.html#anchor49.
     * @var boolean
     */
    public $uniqueItems;

    /**
     * See http://json-schema.org/latest/json-schema-validation.html#anchor76.
     * @var array
     */
    public $enum;

    /**
     * See http://json-schema.org/latest/json-schema-validation.html#anchor14.
     * @var number
     */
    public $multipleOf;

    /** @inheritdoc */
    public static $_required = ['name', 'in'];

    /** @inheritdoc */
    public static $_types = [
        'name' => 'string',
        'in' => ['query', 'header', 'path', 'formData', 'body'],
        'description' => 'string',
        'required' => 'boolean',
        'format' => 'string',
        'collectionFormat' => ['csv', 'ssv', 'tsv', 'pipes', 'multi'],
        'maximum' => 'number',
        'exclusiveMaximum' => 'boolean',
        'minimum' => 'number',
        'exclusiveMinimum' => 'boolean',
        'maxLength' => 'integer',
        'minLength' => 'integer',
        'pattern' => 'string',
        'maxItems' => 'integer',
        'minItems' => 'integer',
        'uniqueItems' => 'boolean',
        'multipleOf' => 'integer',
    ];

    /** @inheritdoc */
    public static $_nested = [
        'Swagger\Annotations\Items' => 'items',
        'Swagger\Annotations\Schema' => 'schema'
    ];

    /** @inheritdoc */
    public static $_parents = [
        'Swagger\Annotations\Operation',
        'Swagger\Annotations\Get',
        'Swagger\Annotations\Post',
        'Swagger\Annotations\Put',
        'Swagger\Annotations\Delete',
        'Swagger\Annotations\Patch',
        'Swagger\Annotations\Path',
        'Swagger\Annotations\Head',
        'Swagger\Annotations\Options',
        'Swagger\Annotations\Swagger'
    ];

    /** @inheritdoc */
    public function validate($parents = [], $skip = [], $ref = '')
    {
        if (in_array($this, $skip, true)) {
            return true;
        }
        $valid = parent::validate($parents, $skip, $ref);
        if (empty($this->ref)) {
            if ($this->in === 'body') {
                if ($this->schema === null) {
                    Logger::notice('Field "schema" is required when ' . $this->identity() . ' is in "' . $this->in . '" in ' . $this->_context);
                    $valid = false;
                }
            } else {
                $validTypes = ['string', 'number', 'integer', 'boolean', 'array', 'file'];
                if ($this->type === null) {
                    Logger::notice($this->identity() . '->type is required when ' . $this->_identity([]) . '->in == "' . $this->in . '" in ' . $this->_context);
                    $valid = false;
                } elseif ($this->type === 'array' && $this->items === null) {
                    Logger::notice($this->identity() . '->items required when ' . $this->_identity([]) . '->type == "array" in ' . $this->_context);
                    $valid = false;
                } elseif (in_array($this->type, $validTypes) === false) {
                    $valid = false;
                    Logger::notice($this->identity() . '->type must be "' . implode('", "', $validTypes) . '" when ' . $this->_identity([]) . '->in != "body" in ' . $this->_context);
                } elseif ($this->type === 'file' && $this->in !== 'formData') {
                    Logger::notice($this->identity() . '->in must be "formData" when ' . $this->_identity([]) . '->type == "file" in ' . $this->_context);
                    $valid = false;
                }
            }
        }
        return $valid;
    }

    /** @inheritdoc */
    public function identity()
    {
        return parent::_identity(['name', 'in']);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           