<?php declare(strict_types=1);

namespace PhpParser\Builder;

use PhpParser;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Stmt;

class Method extends FunctionLike
{
    protected $name;
    protected $flags = 0;

    /** @var array|null */
    protected $stmts = [];

    /**
     * Creates a method builder.
     *
     * @param string $name Name of the method
     */
    public function __construct(string $name) {
        $this->name = $name;
    }

    /**
     * Makes the method public.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePublic() {
        $this->flags = BuilderHelpers::addModifier($this->flags, Stmt\Class_::MODIFIER_PUBLIC);

        return $this;
    }

    /**
     * Makes the method protected.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeProtected() {
        $this->flags = BuilderHelpers::addModifier($this->flags, Stmt\Class_::MODIFIER_PROTECTED);

        return $this;
    }

    /**
     * Makes the method private.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePrivate() {
        $this->flags = BuilderHelpers::addModifier($this->flags, Stmt\Class_::MODIFIER_PRIVATE);

        return $this;
    }

    /**
     * Makes the method static.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeStatic() {
        $this->flags = BuilderHelpers::addModifier($this->flags, Stmt\Class_::MODIFIER_STATIC);

        return $this;
    }

    /**
     * Makes the method abstract.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeAbstract() {
        if (!empty($this->stmts)) {
            throw new \LogicException('Cannot make method with statements abstract');
        }

        $this->flags = BuilderHelpers::addModifier($this->flags, Stmt\Class_::MODIFIER_ABSTRACT);
        $this->stmts = null; // abstract methods don't have statements

        return $this;
    }

    /**
     * Makes the method final.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeFinal() {
        $this->flags = BuilderHelpers::addModifier($this->flags, Stmt\Class_::MODIFIER_FINAL);

        return $this;
    }

    /**
     * Adds a statement.
     *
     * @param Node|PhpParser\Builder $stmt The statement to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmt($stmt) {
        if (null === $this->stmts) {
            throw new \LogicException('Cannot add statements to an abstract method');
        }

        $this->stmts[] = BuilderHelpers::normalizeStmt($stmt);

        return $this;
    }

    /**
     * Returns the built method node.
     *
     * @return Stmt\ClassMethod The built method node
     */
    public function getNode() : Node {
        return new Stmt\ClassMethod($this->name, [
            'flags'      => $this->flags,
            'byRef'      => $this->returnByRef,
            'params'     => $this->params,
            'returnType' => $this->returnType,
            'stmts'      => $this->stmts,
        ], $this->attributes);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      INDX( 	 X+�             (   �  �                             h     h V     g     ��wLpk� C�|����<���wLpk�       N              
 C l a s s _ . p h p   i     p `     g     � zLpk� C�|�����<�� zLpk�       �               D e c l a r a t i o n . p h p j     x b     g     C�~Lpk� C�|��Re��<�C�~Lpk�       H               F u n c t i o n L i k e . p h p       k     p \     g     �H�Lpk� C�|������<��H�Lpk�       �               F u n c t i o n _ . p h p    l     p ^     g     ᪃Lpk� C�|���)��<�᪃Lpk�       �               I n t e r f a c e _ . p h p   m     h V     g     �o�Lpk� C�|���)��<��o�Lpk�       �              
 M e t h o d . p h p   n     p ^     g     NъLpk� C�|��+���<�NъLpk�       �               N a m e s p a c e _ . p h p   o     h T     g     )��Lpk� C�|������<�)��Lpk�       �	              	 P a r a m . p h p     p     p Z     g     ,��Lpk� C�|������<�,��Lpk�       �              P r o p e r t y . p h p       q     p Z     g     Ž�Lpk� C�|���Q��<�Ž�Lpk�       %               T r a i t U s e . p h p       r     � n     g     ��Lpk� C�|��P���<���Lpk�        X               T r a i t U s e A d a p t a t i o n . p h p   s     h V     g     ��Lpk� C�|��P���<���Lpk�       �              
 T r a i t _ . p h p   t     h R     g     㨢Lpk� C�|��� ��<�㨢Lpk�       �               U s e _ . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php declare(strict_types=1);

namespace PhpParser\Builder;

use PhpParser;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Stmt;

class Namespace_ extends Declaration
{
    private $name;
    private $stmts = [];

    /**
     * Creates a namespace builder.
     *
     * @param Node\Name|string|null $name Name of the namespace
     */
    public function __construct($name) {
        $this->name = null !== $name ? BuilderHelpers::normalizeName($name) : null;
    }

    /**
     * Adds a statement.
     *
     * @param Node|PhpParser\Builder $stmt The statement to add
     *
     * @return $this The builder instance (for fluid interface)
     */
  