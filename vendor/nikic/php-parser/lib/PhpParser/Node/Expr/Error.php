<?php declare(strict_types=1);

namespace PhpParser\Node\Stmt\TraitUseAdaptation;

use PhpParser\Node;

class Alias extends Node\Stmt\TraitUseAdaptation
{
    /** @var null|int New modifier */
    public $newModifier;
    /** @var null|Node\Identifier New name */
    public $newName;

    /**
     * Constructs a trait use precedence adaptation node.
     *
     * @param null|Node\Name              $trait       Trait name
     * @param string|Node\Identifier      $method      Method name
     * @param null|int                    $newModifier New modifier
     * @param null|string|Node\Identifier $newName     New name
     * @param array                       $attributes  Additional attributes
     */
    public function __construct($trait, 