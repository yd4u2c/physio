<?php declare(strict_types=1);

namespace PhpParser\Node\Expr;

use PhpParser\Node\Expr;

class ArrayDimFetch extends Expr
{
    /** @var Expr Variable */
    public $var;
    /** @var null|Expr Array index / dim */
    public $dim;

    /**
     * Constructs an array index fetch node.
     *
     * @param Expr      $var        Variable
     * @param null|Expr $dim        Array index / dim
     * @param array     $attributes Additional attributes
     */
    public function __construct(Expr $var, Expr $dim = null, array $attributes = []) {
        parent::__construct($attributes);
        $this->var = $var;
        $this->dim = $dim;
    }

    public function getSubNodeNames() : array {
        return ['var', 'dim'];
    }
    
    public function getType() : string {
        return 'Expr_ArrayDimFetch';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php declare(strict_types=1);

namespace PhpParser\Node\Expr;

use PhpParser\Node\Expr;

class ArrayItem extends Expr
{
    /** @var null|Expr Key */
    public $key;
    /** @var Expr Value */
    public $value;
    /** @var bool Whether to assign by reference */
    public $byRef;

    /**
     * Constructs an array item node.
     *
     * @param Expr      $value      Value
     * @param null|Expr $key        Key
     * @param bool      $byRef      Whether to assign by reference
     * @param array     $attributes Additional attributes
     */
    public function __construct(Expr $value, Expr $key = null, bool $byRef = false, array $attributes = []) {
        parent::__construct($attributes);
        $this->key = $key;
        $this->value = $value;
        $this->byRef = $byRef;
    }

    public function getSubNodeNames() : array {
        return ['key', 'value', 'byRef'];
    }
    
    public function getType() : string {
        return 'Expr_ArrayItem';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php declare(strict_types=1);

namespace PhpParser\Node\Expr;

use PhpParser\Node\Expr;

class Array_ extends Expr
{
    // For use in "kind" attribute
    const KIND_LONG = 1;  // array() syntax
    const KIND_SHORT = 2; // [] syntax

    /** @var ArrayItem[] Items */
    public $items;

    /**
     * Constructs an array node.
     *
     * @param ArrayItem[] $items      Items of the array
     * @param array       $attributes Additional attributes
     */
    public function __construct(array $items = [], array $attributes = []) {
        parent::__construct($attributes);
        $this->items = $items;
    }

    public function getSubNodeNames() : array {
        return ['items'];
    }
    
    public function getType() : string {
        return 'Expr_Array';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php declare(strict_types=1);

namespace PhpParser\Node\Expr;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\FunctionLike;

class ArrowFunction extends Expr implements FunctionLike
{
    /** @var bool */
    public $static;

    /** @var bool */
    public $byRef;

    /** @var Node\Param[] */
    public $params = [];

    /** @var null|Node\Identifier|Node\Name|Node\NullableType */
    public $returnType;

    /** @var Expr */
    public $expr;

    /**
     * @param array $subNodes   Array of the following optional subnodes:
     *                          'static'     => false   : Whether the closure is static
     *                          'byRef'      => false   : Whether to return by reference
     *                          'params'     => array() : Parameters
     *                          'returnType' => null    : Return type
     *                          'expr'       => Expr    : Expression body
     * @param array $attributes Additional attributes
     */
    public function __construct(array $subNodes = [], array $attributes = []) {
        $this->attributes = $attributes;
        $this->static = $subNodes['static'] ?? false;
        $this->byRef = $subNodes['byRef'] ?? false;
        $this->params = $subNodes['params'] ?? [];
        $returnType = $subNodes['returnType'] ?? null;
        $this->returnType = \is_string($returnType) ? new Node\Identifier($returnType) : $returnType;
        $this->expr = $subNodes['expr'] ?? null;
    }

    public function getSubNodeNames() : array {
        return ['static', 'byRef', 'params', 'returnType', 'expr'];
    }

    public function returnsByRef() : bool {
        return $this->byRef;
    }

    public function getParams() : array {
        return $this->params;
    }

    public function getReturnType() {
        return $this->returnType;
    }

    /**
     * @return Node\Stmt\Return_[]
     */
    public function getStmts() : array {
        return [new Node\Stmt\Return_($this->expr)];
    }

    public function getType() : string {
        return 'Expr_ArrowFunction';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php declare(strict_types=1);

namespace PhpParser\Node\Expr;

use PhpParser\Node\Expr;

class Assign extends Expr
{
    /** @var Expr Variable */
    public $var;
    /** @var Expr Expression */
    public $expr;

    /**
     * Constructs an assignment node.
     *
     * @param Expr  $var        Variable
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(Expr $var, Expr $expr, array $attributes = []) {
        parent::__construct($attributes);
        $this->var = $var;
        $this->expr = $expr;
    }

    public function getSubNodeNames() : array {
        return ['var', 'expr'];
    }
    
    public function getType() : string {
        return 'Expr_Assign';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php declare(strict_types=1);

namespace PhpParser\Node\Expr;

use PhpParser\Node\Expr;

abstract class AssignOp extends Expr
{
    /** @var Expr Variable */
    public $var;
    /** @var Expr Expression */
    public $expr;

    /**
     * Constructs a compound assignment operation node.
     *
     * @param Expr  $var        Variable
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(Expr $var, Expr $expr, array $attributes = []) {
        parent::__construct($attributes);
        $this->var = $var;
        $this->expr = $expr;
    }

    public function getSubNodeNames() : array {
        return ['var', 'expr'];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  INDX( 	 Գ�             (   (	  �       p   �    ��        �     x d     �     �T/Mpk� C�|���C��<��T/Mpk�       9               A r r a y D i m F e t c h . p h p     �     p \     �     c4Mpk� C�|���;F��<�c4Mpk�       �               A r r a y I t e m . p h p     �     h V     �     {�8Mpk� C�|��ƞH��<�{�8Mpk�                     
 A r r a y _ . p h p   �     x d     �     �=Mpk�z�j�!%�z�j�!%��=Mpk�       .               A r r o w F u n c t i o n .  h p     �     h V     �     �gBMpk� C�|��ƞH��<��gBMpk�                     
 A s s i g n . p h p   �     h R     �     ޘNpk�[YNpk�[YNpk�ޘNpk�                        A s s i g n O p . p h �     p Z     �     �+GMpk� C�|��H K��<��+GMpk�       �               A s s i g n O p . p h p       �     p \     �     i�KMpk� C�|��xcM��<�i�KMpk�       4               A s s i g n R e f . p h p     �     h R     �     [YNpk��.�Npk��.�Npk�[YNpk�                       B i n a r y O p . p h �     p Z     �     5�PMpk� C�|��xcM��<�5�PMpk�       [               B i n a r y O p . p h p       �     p ^     �     SMpk� C�|����O��<�SMpk��      �               B i t w i s e N o t . p h p   �     p ^     �     mzUMpk� C�|��c'R��<�mzUMpk��      �               B o o l e a n N o t . p h p   �     ` J     �     �.�Npk����Npk����Npk��.�Npk�                        C a s t . p h �     h R     �     !�WMpk� C�|����T��< !�WMpk�0      ,               C a s t . p h p       �     x h     �     }�\Mpk� C�|����T��<�}�\Mpk�       �               C l a s s C o n s t F e t c h . p h p �     h V     �     �eaMpk� C�|����V��<��eaMpk�x      w              
 C l o n e _ . p h p   �     h X     �     ˍhMpk� C�|��FOY��<�ˍhMpk�       .	               C l o s u r e . p h p �     p ^     �     �RmMpk� C�|��Ȱ[��<��RmMpk�       r               C l o s u r e U s e . p h p   �     p ^    �     �vMpk� C�|��Ȱ[��<��vMpk��      �               C o n s t F e t c h . p h p   �     h V     �     i=yMpk� C�|��+^��<�i=yMpk��      z              
 E m p t y _ . p h p   �     h T     �     Vd�Mpk� C�|��Rv`��<�Vd�Mpk�       �              	 E r r o r . p h p                   h p     �     p Z     �     ���Mpk� C�|��m�g��<����Mpk�       V               F u n c C a l l . p h p       �     p Z     �     ~šMpk� C�|��m�g��<�~šMpk�       �              I n c l u d e _ . p h p       �     p `     �     �N�Mpk� C�|����i��<��N�Mpk�       E               I n s t a n c e o f _ . p h p �     h V     �     �u�Mpk� C�|��al��<��u�Mpk��      {              
 I s s e t _ . p h p   �     h T     �     �;�Mpk� C�|����n��<��;�Mpk�       �              	 L i s t _ . p h p     �     p ^     �     ��Mpk� C�|����n��<���Mpk�       m               M e t h o d C a l l . p h p   �     h R     �     !��Mpk� C�|�  &q��<�!��Mpk�       �               N e w _ . p h p       �     h X     �     <�Mpk� C�|��5�s��<�<�Mpk��      z               P o s t D e c . p h p �     h X     �     ���Mpk� C�|��5�s��<����Mpk��      z               P o s t I n c . p h p �     h V     �     ��Mpk� C�|����u��<���Mpk�x      s              
 P r e D e c . p h p   �     h V     �     ���Mpk� C�|��Mx��<����Mpk�x      w              
 P r e I n c . p h p   �     h V     �     O��Mpk  C�|��Q�z��<�O��Mpk��      z              
 P r i n t _ . p h p   �     x d     �      L�Mpk� C�|��Q�z��<� L�Mpk�       �               P r o p e r t y F e t c h . p h p     �     p \     �     ��Mpk� C�|���}��<���Mpk��      �               S h e l l E x e c . p h p     �     p ^     �     ~8�Mpk� C�|��6t��<�~8�Mpk�       h               S t a t i c C a l l . p h p                                                                                                <?php declare(strict_types=1);

namespace PhpParser\Node\Expr;

use PhpParser\Node\Expr;

class AssignRef extends Expr
{
    /** @var Expr Variable reference is assigned to */
    public $var;
    /** @var Expr Variable which is referenced */
    public $expr;

    /**
     * Constructs an assignment node.
     *
     * @param Expr  $var        Variable
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(Expr $var, Expr $expr, array $attributes = []) {
        parent::__construct($attributes);
        $this->var = $var;
        $this->expr = $expr;
    }

    public function getSubNodeNames() : array {
        return ['var', 'expr'];
    }
    
    public function getType() : string {
        return 'Expr_AssignRef';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php declare(strict_types=1);

namespace PhpParser\Node\Expr;

use PhpParser\Node\Expr;

abstract class BinaryOp extends Expr
{
    /** @var Expr The left hand side expression */
    public $left;
    /** @var Expr The right hand side expression */
    public $right;

    /**
     * Constructs a binary operator node.
     *
     * @param Expr  $left       The left hand side expression
     * @param Expr  $right      The right hand side expression
     * @param array $attributes Additional attributes
     */
    public function __construct(Expr $left, Expr $right, array $attributes = []) {
        parent::__construct($attributes);
        $this->left = $left;
        $this->right = $right;
    }

    public function getSubNodeNames() : array {
        return ['left', 'right'];
    }

    /**
     * Get the operator sigil for this binary operation.
     *
     * In the case there are multiple possible sigils for an operator, this method does not
     * necessarily return the one used in the parsed code.
     *
     * @return string
     */
    abstract public function getOperatorSigil() : string;
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php declare(strict_types=1);

namespace PhpParser\Node\Expr;

use PhpParser\Node\Expr;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;

class ClassConstFetch extends Expr
{
    /** @var Name|Expr Class name */
    public $class;
    /** @var Identifier|Error Constant name */
    public $name;

    /**
     * Constructs a class const fetch node.
     *
     * @param Name|Expr               $class      Class name
     * @param string|Identifier|Error $name       Constant name
     * @param array                   $attributes Additional attributes
     */
    public function __construct($class, $name, array $attributes = []) {
        parent::__construct($attributes);
        $this->class = $class;
        $this->name = \is_string($name) ? new Identifier($name) : $name;
    }

    public function getSubNodeNames() : array {
        return ['class', 'name'];
    }
    
    public function getType() : string {
        return 'Expr_ClassConstFetch';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              