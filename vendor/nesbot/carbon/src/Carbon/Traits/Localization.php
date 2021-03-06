Lexer component documentation
=============================

The lexer is responsible for providing tokens to the parser. The project comes with two lexers: `PhpParser\Lexer` and
`PhpParser\Lexer\Emulative`. The latter is an extension of the former, which adds the ability to emulate tokens of
newer PHP versions and thus allows parsing of new code on older versions.

This documentation discusses options available for the default lexers and explains how lexers can be extended.

Lexer options
-------------

The two default lexers accept an `$options` array in the constructor. Currently only the `'usedAttributes'` option is
supported, which allows you to specify which attributes will be added to the AST nodes. The attributes can then be
accessed using `$node->getAttribute()`, `$node->setAttribute()`, `$node->hasAttribute()` and `$node->getAttributes()`
methods. A sample options array:

```php
$lexer = new PhpParser\Lexer(array(
    'usedAttributes' => array(
        'comments', 'startLine', 'endLine'
    )
));
```

The attributes used in this example match the default behavior of the lexer. The following attributes are supported:

 * `comments`: Array of `PhpParser\Comment` or `PhpParser\Comment\Doc` instances, representing all comments that occurred
   between the previous non-discarded token and the current one. Use of this attribute is required for the
   `$node->getComments()` and `$node->getDocComment()` methods to work. The attribute is also needed if you wish the pretty
   printer to retain comments present in the original code.
 * `startLine`: Line in which the node starts. This attribute is required for the `$node->getLine()` to work. It is also
   required if syntax errors should contain line number information.
 * `endLine`: Line in which the node ends. Required for `$node->getEndLine()`.
 * `startTokenPos`: Offset into the token array of the first token in the node. Required for `$node->getStartTokenPos()`.
 * `endTokenPos`: Offset into the token array of the last token in the node. Required for `$node->getEndTokenPos()`.
 * `startFilePos`: Offset into the code string of the first character that is part of the node. Required for `$node->getStartFilePos()`.
 * `endFilePos`: Offset into the code string of the last character that is part of the node. Required for `$node->getEndFilePos()`.

### Using token positions

> **Note:** The example in this section is outdated in that this information is directly available in the AST: While
> `$property->isPublic()` does not distinguish between `public` and `var`, directly checking `$property->flags` for
> the `$property->flags & Class_::VISIBILITY_MODIFIER_MASK) === 0` allows making this distinction without resorting to
> tokens. However the general idea behind the example still applies in other cases.

The token offset information is useful if you wish to examine the exact formatting used for a node. For example the AST
does not distinguish whether a property was declared using `public` or using `var`, but you can retrieve this
information based on the token position:

```php
function isDeclaredUsingVar(array $tokens, PhpParser\Node\Stmt\Property $prop) {
    $i = $prop->getAttribute('startTokenPos');
    return $tokens[$i][0] === T_VAR;
}
```

In order to make use of this function, you will have to provide the tokens from the lexer to your node visitor using
code similar to the following:

```php
class MyNodeVisitor extends PhpParser\NodeVisitorAbstract {
    private $tokens;
    public function setTokens(array $tokens) {
        $this->tokens = $tokens;
    }

    public function leaveNode(PhpParser\Node $node) {
        if ($node instanceof PhpParser\Node\Stmt\Property) {
            var_dump(isDeclaredUsingVar($this->tokens, $node));
        }
    }
}

$lexer = new PhpParser\Lexer(array(
    'usedAttributes' => array(
        'comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos'
    )
));
$parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::ONLY_PHP7, $lexer);

$visitor = new MyNodeVisitor();
$traverser = new PhpParser\NodeTraverser();
$traverser->addVisitor($visitor);

try {
    $stmts = $parser->parse($code);
    $visitor->setTokens($lexer->getTokens());
    $stmts = $traverser->traverse($stmts);
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}
```

The same approach can also be used to perform specific modifications in the code, without changing the formatting in
other places (which is the case when using the pretty printer).

Lexer extension
---------------

A lexer has to define the following public interface:

```php
function startLexing(string $code, ErrorHandler $errorHandler = null): void;
function getTokens(): array;
function handleHaltCompiler(): string;
function getNextToken(string &$value = null, array &$startAttributes = null, array &$endAttributes = null): int;
```

The `startLexing()` method is invoked whenever the `parse()` method of the parser is called and is passed the source
code that is to be lexed (including the opening tag). It can be used to reset state or preprocess the source code or tokens. The
passed `ErrorHandler` should be used to report lexing errors.

The `getTokens()` method returns the current token array, in the usual `token_get_all()` format. This method is not
used by the parser (which uses `getNextToken()`), but is useful in combination with the token position attributes.

The `handleHaltCompiler()` method is called whenever a `T_HALT_COMPILER` token is encountered. It has to return the
remaining string after the construct (not including `();`).

The `getNextToken()` method returns the ID of the next token (as defined by the `Parser::T_*` constants). If no more
tokens are available it must return `0`, which is the ID of the `EOF` token. Furthermore the string content of the
token should be written into the by-reference `$value` parameter (which will then be available as `$n` in the parser).

### Attribute handling

The other two by-ref variables `$startAttributes` and `$endAttributes` define which attributes will eventually be
assigned to the generated nodes: The parser will take the `$startAttributes` from the first token which is part of the
node and the `$endAttributes` from the last token that is part of the node.

E.g. if the tokens `T_FUNCTION T_STRING ... '{' ... '}'` constitute a node, then the `$startAttributes` from the
`T_FUNCTION` token will be taken and the `$endAttributes` from the `'}'` token.

An application of custom attributes is storing the exact original formatting of literals: While the parser does retain
some information about the formatting of integers (like decimal vs. hexadecimal) or strings (like used quote type), it
does not preserve the exact original formatting (e.g. leading zeros for integers or escape sequences in strings). This
can be remedied by storing the original value in an attribute:

```php
use PhpParser\Lexer;
use PhpParser\Parser\Tokens;

class KeepOriginalValueLexer extends Lexer // or Lexer\Emulative
{
    public function getNextToken(&$value = null, &$startAttributes = null, &$endAttributes = null) {
        $tokenId = parent::getNextToken($value, $startAttributes, $endAttributes);

        if ($tokenId == Tokens::T_CONSTANT_ENCAPSED_STRING   // non-interpolated string
            || $tokenId == Tokens::T_ENCAPSED_AND_WHITESPACE // interpolated string
            || $tokenId == Tokens::T_LNUMBER                 // integer
            || $tokenId == Tokens::T_DNUMBER                 // floating point number
        ) {
            // could also use $startAttributes, doesn't really matter here
            $endAttributes['originalValue'] = $value;
        }

        return $tokenId;
    }
}
```
                                                                                                                                                                                                                                                                                                                                                                                                                                                                             INDX( 	 O�             (   `  �       ��                  <     � l     ;     \�Jpk� C�|��[}���<�\�Jpk�        �               A S T _ b u i l d e r s . m a r k d o w n     =     � �     ;     �!�Jpk� C�|���ߨ��<��!�Jpk�       <              ' C o n s t a n t _ e x p r e s s i o n _ e v a l u a t i o n . m a r k d o w n >     � p     ;     ���Jpk� C�|��;B���<����Jpk�       �
               E r r o r _ h a n d l i n g . m a r k d o w n ?     p Z     ;     ��Jpk  C�|��|����<���Jpk�       ?               F A Q . m a r k d o w n       @     � z     ;     6��Jpk� C�|��|����<�6��Jpk�       �               J S O N _ r e p r e s e n t a t i o n . m a r k d o w n       A     p ^     ;     ��Jpk� C�|������<���Jpk�        3               L e x e r . m a r k d o w n   B     � r     ;     }��Jpk� C�|��$j���<�}��Jpk�        ,               N a m e _ r e s o l u t i o n . m a r k d o w n       C     � j     ;     *E�Jpk� C�|� �˴��<�*E�Jpk�                       P e r f o r m a n c e . m a r k d o w n       D     � r     ;     ���Jpk� C�|���˴��<����Jpk�        b               P r e t t y _ p r i n t i n g . m a r k d o w n       E     � r     ;     xlKpk� C�|���.���<�xlKpk� 0      �-               W a l k i n g _ t h e _ A S T . m a r k d o w n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       Name resolution
===============

Since the introduction of namespaces in PHP 5.3, literal names in PHP code are subject to a
relatively complex name resolution process, which is based on the current namespace, the current
import table state, as well the type of the referenced symbol. PHP-Parser implements name
resolution and related functionality, both as reusable logic (NameContext), as well as a node
visitor (NameResolver) based on it.

The NameResolver visitor
------------------------

The `NameResolver` visitor can (and for nearly all uses of the AST, is) be applied to resolve names
to their fully-qualified form, to the degree that this is possible.

```php
$nameResolver = new PhpParser\NodeVisitor\NameResolver;
$nodeTraverser = new PhpParser\NodeTraverser;
$nodeTraverser->addVisitor($nameResolver);

// Resolve names
$stmts = $nodeTraverser->traverse($stmts);
```

In the default configuration, the name resolver will perform three actions:

 * Declarations of functions, classes, interfaces, traits and global constants will have a
   `namespacedName` property added, which contains the function/class/etc name including the
   namespace prefix. For historic reasons this is a **property** rather than an attribute.
 * Names will be replaced by fully qualified resolved names, which are instances of
   `Node\Name\FullyQualified`.
 * Unqualified function and constant names inside a namespace cannot be statically resolved. Inside
   a namespace `Foo`, a call to `strlen()` may either refer to the namespaced `\Foo\strlen()`, or
   the global `\strlen()`. Because PHP-Parser does not have the necessary context to decide this,
   such names are left unresolved. Additionally a `namespacedName` **attribute** is added to the
   name node.

The name resolver accepts an option array as the second argument, with the following default values:

```php
$nameResolver = new PhpParser\NodeVisitor\NameResolver(null, [
    'preserveOriginalNames' => false,
    'replaceNodes' => true,
]);
```

If the `preserveOriginalNames` option is enabled, then the resolved (fully qualified) name will have
an `originalName` attribute, which contains the unresolved name.

If the `replaceNodes` option is disabled, then names will no longer be resolved in-place. Instead a
`resolvedName` attribute will be added to each name, which contains the resolved (fully qualified)
name. Once again, if an unqualified function or constant name cannot be resolved, then the
`resolvedName` attribute will not be present, and instead a `namespacedName` attribute is added.

The `replaceNodes` attribute is useful if you wish to perform modifications on the AST, as you
probably do not wish the resoluting code to have fully resolved names as a side-effect.

The NameContext
---------------

The actual name resolution logic is implemented in the `NameContext` class, which has the following
public API:

```php
class NameContext {
    public function __construct(ErrorHandler $errorHandler);
    public function startNamespace(Name $namespace = null);
    public function addAlias(Name $name, string $aliasName, int $type, array $errorAttrs = []);

    public function getNamespace();
    public function getResolvedName(Name $name, int $type);
    public function getResolvedClassName(Name $name) : Name;
    public function getPossibleNames(string $name, int $type) : array;
    public function getShortName(string $name, int $type) : Name;
}
```

The `$type` parameters accept on of the `Stmt\Use_::TYPE_*` constants, which represent the three
basic symbol types in PHP (functions, constants and everything else).

Next to name resolution, the `NameContext` also supports the reverse operation of finding a short
representation of a name given the current name resolution environment.

The name context is intended to be used for name resolution operations outside the AST itself, such
as class names inside doc comments. A visitor running in parallel with the name resolver can access
the name context using `$nameResolver->getNameContext()`. Alternatively a visitor can use an
independent context and explicitly feed `Namespace` and `Use` nodes to it.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Performance
===========

Parsing is computationally expensive task, to which the PHP language is not very well suited.
Nonetheless, there are a few things you can do to improve the performance of this library, which are
described in the following.

Xdebug
------

Running PHP with XDebug adds a lot of overhead, especially for code that performs many method calls.
Just by loading XDebug (without enabling profiling or other more intrusive XDebug features), you
can expect that code using PHP-Parser will be approximately *five times slower*.

As such, you should make sure that XDebug is not loaded when using this library. Note that setting
the `xdebug.default_enable=0` ini option does *not* disable XDebug. The *only* way to disable
XDebug is to not load the extension in the first place.

If you are building a command-line utility for use by developers (who often have XDebug enabled),
you may want to consider automatically restarting PHP with XDebug unloaded. The
[composer/xdebug-handler](https://g