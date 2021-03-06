INDX( 	 ��             (   �  �        p   �  b �             h V          �#Ppk� C�|��In��<��#Ppk��      �              
 B r e a k _ . p h p        h T          �'Ppk� C�|������<��'Ppk�       X              	 C a s e _ . p h p          h V          eG*Ppk� C�|������<�eG*Ppk�       B              
 C a t c h _ . p h p        p ^          n1Ppk� C�|�� 3��<�n1Ppk�                      C l a s s C o n s t . p h p        p \          �Y=Ppk� C�|��,�!��<��Y=Ppk�                      C l a s s L i k e . p h p          p `          �FPpk� C�|��,�!��<��FPpk�        �               C l a s s M e t h o d . p h p 	     h V          ŧKPpk� C�|����#��<�ŧKPpk�       �              
 C l a s s _ . p h p   
     h V          +mPPpk� C�|�� Y&��<�+mPPpk��      �              
 C o n s t _ . p h p        p \          /1UPpk� C�|��j�(��<�/1UPpk��      �               C o n t i n u e _ .  h p          x f          ��WPpk� C�|���+��<���WPpk�       �               D e c l a r e D e c l a r e . p h p        p Z          �X\Ppk� C�|���+��<��X\Ppk�       r               D e c l a r e _ . p h p            ` P          H�^Ppk� C�|��'�-��<�H�^Ppk�       .               D o _ . p h p      h T          [cPpk� C�|����/��<�[cPpk��      �              	 E c h o _ . p h p          h X          ��ePpk� C�|����/��<���ePpk�       5              E l s e I f _ . p h p      h T          |�jPpk� C�|���D2��<�|�jPpk��      �              	 E l s e _ . p h p          p ^          i	mPpk� C�|��C�4��<�i	mPpk�       �               E x p r e s s i o n . p h p        p Z          �/tPpk� C�|���
7��<��/tPpk��      �               F i n a l l y _ . p h p            p Z          W{Ppk� C�|���k9��<�W{Ppk�       Z               F o r e a c h _ . p h p                          ��Ppk� C�|� �k9��<���Ppk�       *               F o r _ . p h p            p \          ���Ppk� C�|��m�;��<����Ppk�       �               F u n c t i o n _ . p h p          h X          ��Ppk� C�|���0>��<���Ppk��      �               G l o b a l _ . p h p      h T          �j�Ppk� C�|���@��<��j�Ppk�       �              	 G o t o _ . p h p          p Z          r/�Ppk� C�|���@��<�r/�Ppk�       �               G r o u p U s e . p h p            x b         ���Ppk� C�|��`�B��<����Ppk�       �               H a l t C o m p i l e r . p h p            ` P          �U�Ppk� C�|���WE��<��U�Ppk�       &               I f _ . p h p      p ^          h�Ppk� C�|���WE��<�h�Ppk��      �               I n l i n e H T M L . p h p        p ^          �|�Ppk� C�|��^�G��<��|�Ppk�       4               I n t e r f a c e _ . p h p        h T          ף�Ppk� C�|��vJ��<�ף�Ppk��      �              	 L a  e l . p h p          p ^          +̯Ppk� C�|���L��<�+̯Ppk�       �               N a m e s p a c e _ . p h p         ` P          �Ppk� C�|���L��<��Ppk�0      -               N o p . p h p !     p Z          '��Ppk� C�|��V�N��<�'��Ppk�       b               P r o p e r t y . p h p       "     � j          ���Ppk� C�|���CQ��<����Ppk�       �               P r o p e r t y P r o p e r t y . p h p       #     h X          ���Ppk� C�|����S��< ���Ppk��      �               R e t u r n _ . p h p $     p \          ES�Ppk� C�|����S��<�ES�Ppk�       �               S t a t i c V a r . p h p     %     h X          <z�Ppk� C�|��C	V��<�<z�Ppk��      �               S t a t i c _ . p h p &     h X          ��Ppk� C�|���kX��<���Ppk�       !               S w i t c h _ . p h p '     h V          /��Ppk� C�|���kX��<�/��Ppk��      �              
 T h r o w _ . p h p                                <?php declare(strict_types=1);

namespace PhpParser\Node\Stmt;

use PhpParser\Error;
use PhpParser\Node;

class Class_ extends ClassLike
{
    const MODIFIER_PUBLIC    =  1;
    const MODIFIER_PROTECTED =  2;
    const MODIFIER_PRIVATE   =  4;
    const MODIFIER_STATIC    =  8;
    const MODIFIER_ABSTRACT  = 16;
    const MODIFIER_FINAL     = 32;

    const VISIBILITY_MODIFIER_MASK = 7; // 1 | 2 | 4

    /** @var int Type */
    public $flags;
    /** @var null|Node\Name Name of extended class */
    public $extends;
    /** @var Node\Name[] Names of implemented interfaces */
    public $implements;

    /**
     * Constructs a class node.
     *
     * @param string|Node\Identifier|null $name Name
     * @param array       $subNodes   Array of the following optional subnodes:
     *                                'flags'      => 0      : Flags
     *                                'extends'    => null   : Name of extended class
     *                                'implements' => array(): Names of implemented interfaces
     *                                'stmts'      => array(): Statements
     * @param array       $attributes Additional attributes
     */
    public function __construct($name, array $subNodes = [], array $attributes = []) {
        parent::__construct($attributes);
        $this->flags = $subNodes['flags'] ?? $subNodes['type'] ?? 0;
        $this->name = \is_string($name) ? new Node\Identifier($name) : $name;
        $this->extends = $subNodes['extends'] ?? null;
        $this->implements = $subNodes['implements'] ?? [];
        $this->stmts = $subNodes['stmts'] ?? [];
    }

    public function getSubNodeNames() : array {
        return ['flags', 'name', 'extends', 'implements', 'stmts'];
    }

    /**
     * Whether the class is explicitly abstract.
     *
     * @return bool
     */
    public function isAbstract() : bool {
        return (bool) ($this->flags & self::MODIFIER_ABSTRACT);
    }

    /**
     * Whether the class is final.
     *
     * @return bool
     */
    public function isFinal() : bool {
        return (bool) ($this->flags & self::MODIFIER_FINAL);
    }

    /**
     * Whether the class is anonymous.
     *
     * @return bool
     */
    public function isAnonymous() : bool {
        return null === $this->name;
    }

    /**
     * @internal
     */
    public static function verifyModifier($a, $b) {
        if ($a & self::VISIBILITY_MODIFIER_MASK && $b & self::VISIBILITY_MODIFIER_MASK) {
            throw new Error('Multiple access type modifiers are not allowed');
        }

        if ($a & self::MODIFIER_ABSTRACT && $b & self::MODIFIER_ABSTRACT) {
            throw new Error('Multiple abstract modifiers are not allowed');
        }

        if ($a & self::MODIFIER_STATIC && $b & self::MODIFIER_STATIC) {
            throw new Error('Multiple static modifiers are not allowed');
        }

        if ($a & self::MODIFIER_FINAL && $b & self::MODIFIER_FINAL) {
            throw new Error('Multiple final modifiers are not allowed');
        }

        if ($a & 48 && $b & 48) {
            throw new Error('Cannot use the final modifier on an abstract class member');
        }
    }
    
    public function getType() : string {
        return 'Stmt_Class';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           