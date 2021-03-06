t\Doc) {
            return $docComment;
        } elseif (is_string($docComment)) {
            return new Comment\Doc($docComment);
        } else {
            throw new \LogicException('Doc comment must be a string or an instance of PhpParser\Comment\Doc');
        }
    }

    /**
     * Adds a modifier and returns new modifier bitmask.
     *
     * @param int $modifiers Existing modifiers
     * @param int $modifier  Modifier to set
     *
     * @return int New modifiers
     */
    public static function addModifier(int $modifiers, int $modifier) : int {
        Stmt\Class_::verifyModifier($modifiers, $modifier);
        return $modifiers | $modifier;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php declare(strict_types=1);

namespace PhpParser;

class Comment implements \JsonSerializable
{
    protected $text;
    protected $line;
    protected $filePos;
    protected $tokenPos;

    /**
     * Constructs a comment node.
     *
     * @param string $text          Comment text (including comment delimiters like /*)
     * @param int    $startLine     Line number the comment started on
     * @param int    $startFilePos  File offset the comment started on
     * @param int    $startTokenPos Token offset the comment started on
     */
    public function __construct(
        string $text, int $startLine = -1, int $startFilePos = -1, int $startTokenPos = -1
    ) {
        $this->text = $text;
        $this->line = $startLine;
        $this->filePos = $startFilePos;
        $this->tokenPos = $startTokenPos;
    }

    /**
     * Gets the comment text.
     *
     * @return string The comment text (including comment delimiters like /*)
     */
    public function getText() : string {
        return $this->text;
    }

    /**
     * Gets the line number the comment started on.
     *
     * @return int Line number
     */
    public function getLine() : int {
        return $this->line;
    }

    /**
     * Gets the file offset the comment started on.
     *
     * @return int File offset
     */
    public function getFilePos() : int {
        return $this->filePos;
    }

    /**
     * Gets the token offset the comment started on.
     *
     * @return int Token offset
     */
    public function getTokenPos() : int {
        return $this->tokenPos;
    }

    /**
     * Gets the comment text.
     *
     * @return string The comment text (including comment delimiters like /*)
     */
    public function __toString() : string {
        return $this->text;
    }

    /**
     * Gets the reformatted comment text.
     *
     * "Reformatted" here means that we try to clean up the whitespace at the
     * starts of the lines. This is necessary because we receive the comments
     * without trailing whitespace on the first line, but with trailing whitespace
     * on all subsequent lines.
     *
     * @return mixed|string
     */
    public function getReformattedText() {
        $text = trim($this->text);
        $newlinePos = strpos($text, "\n");
        if (false === $newlinePos) {
            // Single line comments don't need further processing
            return $text;
        } elseif (preg_match('((*BSR_ANYCRLF)(*ANYCRLF)^.*(?:\R\s+\*.*)+$)', $text)) {
            // Multi line comment of the type
            //
            //     /*
            //      * Some text.
            //      * Some more text.
            //      */
            //
            // is handled by replacing the whitespace sequences before the * by a single space
            return preg_replace('(^\s+\*)m', ' *', $this->text);
        } elseif (preg_match('(^/\*\*?\s*[\r\n])', $text) && preg_match('(\n(\s*)\*/$)', $text, $matches)) {
            // Multi line comment of the type
            //
            //    /*
            //        Some text.
            //        Some more text.
            //    */
            //
            // is handled by removing the whitespace sequence on the line before the closing
            // */ on all lines. So if the last line is "    */", then "    " is removed at the
            // start of all lines.
            return preg_replace('(^' . preg_quote($matches[1]) . ')m', '', $text);
        } elseif (preg_match('(^/\*\*?\s*(?!\s))', $text, $matches)) {
            // Multi line comment of the type
            //
            //     /* Some text.
            //        Some more text.
            //          Indented text.
            //        Even more text. */
            //
            // is handled by removing the difference between the shortest whitespace prefix on all
            // lines and the length of the "/* " opening sequence.
            $prefixLen = $this->getShortestWhitespacePrefixLen(substr($text, $newlinePos + 1));
            $removeLen = $prefixLen - strlen($matches[0]);
            return preg_replace('(^\s{' . $removeLen . '})m', '', $text);
        }

        // No idea how to format this comment, so simply return as is
        return $text;
    }

    /**
     * Get length of shortest whitespace prefix (at the start of a line).
     *
     * If there is a line with no prefix whitespace, 0 is a valid return value.
     *
     * @param string $str String to check
     * @return int Length in characters. Tabs count as single characters.
     */
    private function getShortestWhitespacePrefixLen(string $str) : int {
        $lines = explode("\n", $str);
        $shortestPrefixLen = \INF;
        foreach ($lines as $line) {
            preg_match('(^\s*)', $line, $matches);
            $prefixLen = strlen($matches[0]);
            if ($prefixLen < $shortestPrefixLen) {
                $shortestPrefixLen = $prefixLen;
            }
        }
        return $shortestPrefixLen;
    }

    /**
     * @return       array
     * @psalm-return array{nodeType:string, text:mixed, line:mixed, filePos:mixed}
     */
    public function jsonSerialize() : array {
        // Technically not a node, but we make it look like one anyway
        $type = $this instanceof Comment\Doc ? 'Comment_Doc' : 'Comment';
        return [
            'nodeType' => $type,
            'text' => $this->text,
            'line' => $this->line,
            'filePos' => $this->filePos,
            'tokenPos' => $this->tokenPos,
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

namespace PhpParser;

use PhpParser\Node\Expr;
use PhpParser\Node\Scalar;

/**
 * Evaluates constant expressions.
 *
 * This evaluator is able to evaluate all constant expressions (as defined by PHP), which can be
 * evaluated without further context. If a subexpression is not of this type, a user-provided
 * fallback evaluator is invoked. To support all constant expressions that are also supported by
 * PHP (and not already handled by this class), the fallback evaluator must be able to handle the
 * following node types:
 *
 *  * All Scalar\MagicConst\* nodes.
 *  * Expr\ConstFetch nodes. Only null/false/true are already handled by this class.
 *  * Expr\ClassConstFetch nodes.
 *
 * The fallback evaluator should throw ConstExprEvaluationException for nodes it cannot evaluate.
 *
 * The evaluation is dependent on runtime configuration in two respects: Firstly, floating
 * point to string conversions are affected by the precision ini setting. Secondly, they are also
 * affected by the LC_NUMERIC locale.
 */
class ConstExprEvaluator
{
    private $fallbackEvaluator;

    /**
     * Create a constant expression evaluator.
     *
     * The provided fallback evaluator is invoked whenever a subexpression cannot be evaluated. See
     * class doc comment for more information.
     *
     * @param callable|null $fallbackEvaluator To call if subexpression cannot be evaluated
     */
    public function __construct(callable $fallbackEvaluator = null) {
        $this->fallbackEvaluator = $fallbackEvaluator ?? function(Expr $expr) {
            throw new ConstExprEvaluationException(
                "Expression of type {$expr->getType()} cannot be evaluated"
            );
        };
    }

    /**
     * Silently evaluates a constant expression into a PHP value.
     *
     * Thrown Errors, warnings or notices will be converted into a ConstExprEvaluationException.
     * The original source of the exception is available through getPrevious().
     *
     * If some part of the expression cannot be evaluated, the fallback evaluator passed to the
     * constructor will be invoked. By default, if no fallback is provided, an exception of type
     * ConstExprEvaluationException is thrown.
     *
     * See class doc comment for caveats and limitations.
     *
     * @param Expr $expr Constant expression to evaluate
     * @return mixed Result of evaluation
     *
     * @throws ConstExprEvaluationException if the expression cannot be evaluated or an error occurred
     */
    public function evaluateSilently(Expr $expr) {
        set_error_handler(function($num, $str, $file, $line) {
            throw new \ErrorException($str, 0, $num, $file, $line);
        });

        try {
            return $this->evaluate($expr);
        } catch (\Throwable $e) {
            if (!$e instanceof ConstExprEvaluationException) {
                $e = new ConstExprEvaluationException(
                    "An error occurred during constant expression evaluation", 0, $e);
            }
            throw $e;
        } finally {
            restore_error_handler();
        }
    }

    /**
     * Directly evaluates a constant expression into a PHP value.
     *
     * May generate Error exceptions, warnings or notices. Use evaluateSilently() to convert these
     * into a ConstExprEvaluationException.
     *
     * If some part of the expression cannot be evaluated, the fallback evaluator passed to the
     * constructor will be invoked. By default, if no fallback is provided, an exception of type
     * ConstExprEvaluationException is thrown.
     *
     * See class doc comment for caveats and limitations.
     *
     * @param Expr $expr Constant expression to evaluate
     * @return mixed Result of evaluation
     *
     * @throws ConstExprEvaluationException if the expression cannot be evaluated
     */
    public function evaluateDirectly(Expr $expr) {
        return $this->evaluate($expr);
    }

    private function evaluate(Expr $expr) {
        if ($expr instanceof Scalar\LNumber
            || $expr instanceof Scalar\DNumber
            || $expr instanceof Scalar\String_
        ) {
            return $expr->value;
        }

        if ($expr instanceof Expr\Array_) {
            return $this->evaluateArray($expr);
        }

        // Unary operators
        if ($expr instanceof Expr\UnaryPlus) {
            return +$this->evaluate($expr->expr);
        }
        if ($expr instanceof Expr\UnaryMinus) {
            return -$this->evaluate($expr->expr);
        }
        if ($expr instanceof Expr\BooleanNot) {
            return !$this->evaluate($expr->expr);
        }
        if ($expr instanceof Expr\BitwiseNot) {
            return ~$this->evaluate($expr->expr);
        }

        if ($expr instanceof Expr\BinaryOp) {
            return $this->evaluateBinaryOp($expr);
        }

        if ($expr instanceof Expr\Ternary) {
            return $this->evaluateTernary($expr);
        }

        if ($expr instanceof Expr\ArrayDimFetch && null !== $expr->dim) {
            return $this->evaluate($expr->var)[$this->evaluate($expr->dim)];
        }

        if ($expr instanceof Expr\ConstFetch) {
            return $this->evaluateConstFetch($expr);
        }

        return ($this->fallbackEvaluator)($expr);
    }

    private function evaluateArray(Expr\Array_ $expr) {
        $array = [];
        foreach ($expr->items as $item) {
            if (null !== $item->key) {
                $array[$this->evaluate($item->key)] = $this->evaluate($item->value);
            } else {
                $array[] = $this->evaluate($item->value);
            }
        }
        return $array;
    }

    private function evaluateTernary(Expr\Ternary $expr) {
        if (null === $expr->if) {
            return $this->evaluate($expr->cond) ?: $this->evaluate($expr->else);
        }

        return $this->evaluate($expr->cond)
            ? $this->evaluate($expr->if)
            : $this->evaluate($expr->else);
    }

    private function evaluateBinaryOp(Expr\BinaryOp $expr) {
        if ($expr instanceof Expr\BinaryOp\Coalesce
            && $expr->left instanceof Expr\ArrayDimFetch
        ) {
            // This needs to be special ca