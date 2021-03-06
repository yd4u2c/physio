e will be correctly handled in
     * concatenations using concat().
     *
     * Offset and length have the same meaning as in array_slice().
     *
     * @param int      $offset Offset to start the slice at (may be negative)
     * @param int|null $length Length of the slice (may be negative)
     *
     * @return static|null Sliced name
     */
    public function slice(int $offset, int $length = null) {
        $numParts = count($this->parts);

        $realOffset = $offset < 0 ? $offset + $numParts : $offset;
        if ($realOffset < 0 || $realOffset > $numParts) {
            throw new \OutOfBoundsException(sprintf('Offset %d is out of bounds', $offset));
        }

        if (null === $length) {
            $realLength = $numParts - $realOffset;
        } else {
            $realLength = $length < 0 ? $length + $numParts - $realOffset : $length;
            if ($realLength < 0 || $realLength > $numParts) {
                throw new \OutOfBoundsException(sprintf('Length %d is out of bounds', $length));
            }
        }

        if ($realLength === 0) {
            // Empty slice is represented as null
            return null;
        }

        return new static(array_slice($this->parts, $realOffset, $realLength), $this->attributes);
    }

    /**
     * Concatenate two names, yielding a new Name instance.
     *
     * The type of the generated instance depends on which class this method is called on, for
     * example Name\FullyQualified::concat() will yield a Name\FullyQualified instance.
     *
     * If one of the arguments is null, a new instance of the other name will be returned. If both
     * arguments are null, null will be returned. As such, writing
     *     Name::concat($namespace, $shortName)
     * where $namespace is a Name node or null will work as expected.
     *
     * @param string|string[]|self|null $name1      The first name
     * @param string|string[]|self|null $name2      The second name
     * @param array                     $attributes Attributes to assign to concatenated name
     *
     * @return static|null Concatenated name
     */
    public static function concat($name1, $name2, array $attributes = []) {
        if (null === $name1 && null === $name2) {
            return null;
        } elseif (null === $name1) {
            return new static(self::prepareName($name2), $attributes);
        } elseif (null === $name2) {
            return new static(self::prepareName($name1), $attributes);
        } else {
            return new static(
                array_merge(self::prepareName($name1), self::prepareName($name2)), $attributes
            );
        }
    }

    /**
     * Prepares a (string, array or Name node) name for use in name changing methods by converting
     * it to an array.
     *
     * @param string|string[]|self $name Name to prepare
     *
     * @return string[] Prepared name
     */
    private static function prepareName($name) : array {
        if (\is_string($name)) {
            if ('' === $name) {
                throw new \InvalidArgumentException('Name cannot be empty');
            }

            return explode('\\', $name);
        } elseif (\is_array($name)) {
            if (empty($name)) {
                throw new \InvalidArgumentException('Name cannot be empty');
            }

            return $name;
        } elseif ($name instanceof self) {
            return $name->parts;
        }

        throw new \InvalidArgumentException(
            'Expected string, array of parts or Name instance'
        );
    }
    
    public function getType() : string {
        return 'Name';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    INDX( 	 X�             (   h  �       �                   �     ` P     �     �W�Lpk� C�|��%�0��<��W�Lpk�       
               A r g . p h p �     h V     �     ��Lpk� C�|���)3��<���Lpk�       �              
 C o n s t _ . p h p   �     ` J     �     �*Mpk��.�Npk��.�Npk��.�Npk�                        E x p r . p h �     h R     �     ���Lpk� C�|���)3��<����Lpk��       �                E x p r . p h p       �     x b     �     �Mpk� C�|��
�5��< �Mpk��      �               F u n c t i o n L i k e . p h p       �     p ^     �     ��Mpk� C�|��@�7��<���Mpk�       �               I d e n t i f i e r . p h p   �     ` J     �     ���Npk�={�Npk�={�Npk����Npk�                        N a m e . p h �     h R     �     ||Mpk� C�|���O:��<�||Mpk�        <               N a m e . p h p       �     x b     �     d�Mpk� C�|���O:��<�d�Mpk�       �               N u l l a b l e T y p e . p h p       �     h T     �     �h#Mpk� C�|���<��<��h#Mpk�       �              	 P a r a m . p h p     �     ` N     �     ={�Npk�}��Opk�}��Opk�}��Opk�                        S c a l a r . �     h V     �     ��%Mpk� C�|��Q?��<���%Mpk�h       b               
 S c a l a r . p h p        ` J     �     �ZPpk���JQpk���JQpk���JQpk�                        S t m t . p h �     h R     �     -(Mpk� C�|���vA��<�-(Mpk��       �                S t m t . p h p       �     � l    �     �*Mpk� C�|���vA��<��*Mpk��      �               V a r L i k e I d e n t i f i e r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php declare(strict_types=1);

namespace PhpParser\Node;

use PhpParser\NodeAbstract;

class NullableType extends NodeAbstract
{
    /** @var Identifier|Name Type */
    public $type;

    /**
     * Constructs a nullable type (wrapping another type).
     *
     * @param string|Identifier|Name $type       Type
     * @param array                  $attributes Additional attributes
     */
    public function __construct($type, array $attributes = []) {
        parent::__construct($attributes);
        $this->type = \is_string($type) ? new Identifier($type) : $type;
    }

    public function getSubNodeNames() : array {
        return ['type'];
    }
    
    public function getType() : string {
        return 'NullableType';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        