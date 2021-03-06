<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\CodeCleaner;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Include_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified as FullyQualifiedName;
use PhpParser\Node\Scalar\LNumber;
use Psy\Exception\ErrorException;
use Psy\Exception\FatalErrorException;
use Psy\Shell;

/**
 * Add runtime validation for `require` and `require_once` calls.
 */
class RequirePass extends CodeCleanerPass
{
    private static $requireTypes = [Include_::TYPE_REQUIRE, Include_::TYPE_REQUIRE_ONCE];

    /**
     * {@inheritdoc}
     */
    public function enterNode(Node $origNode)
    {
        if (!$this->isRequireNode($origNode)) {
            return;
        }

        $node = clone $origNode;

        /*
         * rewrite
         *
         *   $foo = require $bar
         *
         * to
         *
         *   $foo = require \Psy\CodeCleaner\RequirePass::resolve($bar)
         */
        $node->expr = new StaticCall(
            new FullyQualifiedName('Psy\CodeCleaner\RequirePass'),
            'resolve',
            [new Arg($origNode->expr), new Arg(new LNumber($origNode->getLine()))],
            $origNode->getAttributes()
        );

        return $node;
    }

    /**
     * Runtime validation that $file can be resolved as an include path.
     *
     * If $file can be resolved, return $file. Otherwise throw a fatal error exception.
     *
     * @throws FatalErrorException when unable to resolve include path for $file
     * @throws ErrorException      if $file is empty and E_WARNING is included in error_reporting level
     *
     * @param string $file
     * @param int    $lineNumber Line number of the original require expression
     *
     * @return string Exactly the same as $file
     */
    public static function resolve($file, $lineNumber = null)
    {
        $file = (string) $file;

        if ($file === '') {
            // @todo Shell::handleError would be better here, because we could
            // fake the file and line number, but we can't call it statically.
            // So we're duplicating some of the logics here.
            if (E_WARNING & \error_reporting()) {
                ErrorException::throwException(E_WARNING, 'Filename cannot be empty', null, $lineNumber);
            }
            // @todo trigger an error as fallback? this is pretty ugly…
            // trigger_error('Filename cannot be empty', E_USER_WARNING);
        }

        if ($file === '' || !\stream_resolve_include_path($file)) {
            $msg = \sprintf("Failed opening required '%s'", $file);
            throw new FatalErrorException($msg, 0, E_ERROR, null, $lineNumber);
        }

        return $file;
    }

    private function isRequireNode(Node $node)
    {
        return $node instanceof Include_ && \in_array($node->type, self::$requireTypes);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\CodeCleaner;

use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\DeclareDeclare;
use Psy\Exception\FatalErrorException;

/**
 * Provide implicit strict types declarations for for subsequent execution.
 *
 * The strict types pass remembers the last strict types declaration:
 *
 *     declare(strict_types=1);
 *
 * ... which it then applies implicitly to all future evaluated code, until it
 * is replaced by a new declaration.
 */
class StrictTypesPass extends CodeCleanerPass
{
    const EXCEPTION_MESSAGE = 'strict_types declaration must have 0 or 1 as its value';

    private $strictTypes = false;
    private $atLeastPhp7;

    public function __construct()
    {
        $this->atLeastPhp7 = \version_compare(PHP_VERSION, '7.0', '>=');
    }

    /**
     * If this is a standalone strict types declaration, remember it for later.
     *
     * Otherwise, apply remembered strict types declaration to to the code until
     * a new declaration is encountered.
     *
     * @throws FatalErrorException if an invalid `strict_types` declaration is found
     *
     * @param array $nodes
     */
    public function beforeTraverse(array $nodes)
    {
        if (!$this->atLeastPhp7) {
            return; // @codeCoverageIgnore
        }

        $prependStrictTypes = $this->strictTypes;

        foreach ($nodes as $key => $node) {
            if ($node instanceof Declare_) {
                foreach ($node->declares as $declare) {
                    // For PHP Parser 4.x
                    $declareKey = $declare->key instanceof Identifier ? $declare->key->toString() : $declare->key;
                    if ($declareKey === 'strict_types') {
                        $value = $declare->value;
                        if (!$value instanceof LNumber || ($value->value !== 0 && $value->value !== 1)) {
                            throw new FatalErrorException(self::EXCEPTION_MESSAGE, 0, E_ERROR, null, $node->getLine());
                        }

                        $this->strictTypes = $value->value === 1;
                    }
                }
            }
        }

        if ($prependStrictTypes) {
            $first = \reset($nodes);
            if (!$first instanceof Declare_) {
                $declare = new Declare_([new DeclareDeclare('strict_types', new LNumber(1))]);
                \array_unshift($nodes, $declare);
            }
        }

        return $nodes;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\CodeCleaner;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified as FullyQualifiedName;
use PhpParser\Node\Stmt\GroupUse;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\NodeTraverser;

/**
 * Provide implicit use statements for subsequent execution.
 *
 * The use statement pass remembers the last use statement line encountered:
 *
 *     use Foo\Bar as Baz;
 *
 * ... which it then applies implicitly to all future evaluated code, until the
 * current namespace is replaced by another namespace.
 */
class UseStatementPass extends CodeCleanerPass
{
    private $aliases       = [];
    private $lastAliases   = [];
    private $lastNamespace = null;

    /**
     * Re-load the last set of use statements on re-entering a namespace.
     *
     * This isn't how namespaces normally work, but because PsySH has to spin
     * up a new namespace for every line of code, we do this to make things
     * work like you'd expect.
     *
     * @param Node $node
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof Namespace_) {
            // If this is the same namespace as last namespace, let's do ourselves
            // a favor and reload all the aliases...
            if (\strtolower($node->name) === \strtolower($this->lastNamespace)) {
                $this->aliases = $this->lastAliases;
            }
        }
    }

    /**
     * If this statement is a namespace, forget all the aliases we had.
     *
     * If it's a use statement, remember the alias for later. Otherwise, apply
     * remembered aliases to the code.
     *
     * @param Node $node
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof Use_) {
            // Store a reference to every "use" statement, because we'll need
            // them in a bit.
            foreach ($node->uses as $use) {
                $alias = $use->alias ?: \end($use->name->parts);
                $this->aliases[\strtolower($alias)] = $use->name;
            }

            return NodeTraverser::REMOVE_NODE;
        } elseif ($node instanceof GroupUse) {
            // Expan