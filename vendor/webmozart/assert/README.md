ion $annotation
     * @param string                         $property
     * @param mixed                          $value
     *
     * @return mixed
     */
    private function doDeserializeProperty(Annotations\AbstractAnnotation $annotation, $property, $value)
    {
        // property is primitive type
        if (array_key_exists($property, $annotation::$_types)) {
            return $value;
        }
        // property is embedded annotation
        foreach ($annotation::$_nested as $class => $declaration) {
            // property is an annotation
            if (is_string($declaration) && $declaration === $property) {
                return $this->doDeserialize($value, $class);
            }

            // property is an annotation array
            if (is_array($declaration) && count($declaration) === 1 && $declaration[0] === $property) {
                $annotationArr = [];
                foreach ($value as $v) {
                    $annotationArr[] = $this->doDeserialize($v, $class);
                }
                return $annotationArr;
            }

            // property is an annotation hash map
            if (is_array($declaration) && count($declaration) === 2 && $declaration[0] === $property) {
                $key = $declaration[1];
                $annotationHash = [];
                foreach ($value as $k => $v) {
                    $annotation = $this->doDeserialize($v, $class);
                    $annotation->$key = $k;
                    $annotationHash[$k] = $annotation;
                }
                return $annotationHash;
            }
        }
        return $value;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/**
 * @license Apache 2.0
 */

namespace Swagger;

/**
 * Swagger\StaticAnalyser extracts swagger-php annotations from php code using static analysis.
 */
class StaticAnalyser
{
    /**
     * @param string $filename
     */
    public function __construct($filename = null)
    {
        if ($filename !== null) {
            $this->fromFile($filename);
        }
    }

    /**
     * Extract and process all doc-comments from a file.
     *
     * @param string $filename Path to a php file.
     * @return Analysis
     */
    public function fromFile($filename)
    {
        if (function_exists('opcache_get_status') && function_exists('opcache_get_configuration')) {
            if (empty($GLOBALS['swagger_opcache_warning'])) {
                $GLOBALS['swagger_opcache_warning'] = true;
                $status = opcache_get_status();
                $config = opcache_get_configuration();
                if ($status['opcache_enabled'] && $config['directives']['opcache.save_comments'] == false) {
                    Logger::warning("php.ini \"opcache.save_comments = 0\" interferes with extracting annotations.\n[LINK] http://php.net/manual/en/opcache.configuration.php#ini.opcache.save-comments");
                }
            }
        }
        $tokens = token_get_all(file_get_contents($filename));
        return $this->fromTokens($tokens, new Context(['filename' => $filename]));
    }

    /**
     * Extract and process all doc-comments from the contents.
     *
     * @param string $code PHP code. (including <?php tags)
     * @param Context $context The original location of the contents.
     * @return Analysis
     */
    public function fromCode($code, $context)
    {
        $tokens = token_get_all($code);
        return $this->fromTokens($tokens, $context);
    }

    /**
     * Shared implementation for parseFile() & parseContents().
     *
     * @param array $tokens The result of a token_get_all()
     * @param Context $parseContext
     * @return Analysis
     */
    protected function fromTokens($tokens, $parseContext)
    {
        $analyser = new Analyser();
        $analysis = new Analysis();
        reset($tokens);
        $token = '';
        $imports = Analyser::$defaultImports; // Use @SWG\* for swagger annotations (unless overwritten by a use statement)

        $parseContext->uses = [];
        $definitionContext = $parseContext; // Use the parseContext until a definitionContext  (class or trait) is created.
        $classDefinition = false;
        $comment = false;
        $line = 0;
        $lineOffset = $parseContext->line ? : 0;
        while ($token !== false) {
            $previousToken = $token;
            $token = $this->nextToken($tokens, $parseContext);
            if (is_array($token) === false) { // Ignore tokens like "{", "}", etc
                continue;
            }
            if ($token[0] === T_DOC_COMMENT) {
                if ($comment) { // 2 Doc-comments in succession?
                    $this->analyseComment($analysis, $analyser, $comment, new Context(['line' => $line], $definitionContext));
                }
                $comment = $token[1];
                $line = $token[2] + $lineOffset;
                continue;
            }
            if (in_array($token[0], [T_ABSTRACT, T_FINAL])) {
                $token = $this->nextToken($tokens, $parseContext); // Skip "abstract" and "final" keywords
            }
            if ($token[0] === T_CLASS) { // Doc-comment before a class?
                if (is_array($previousToken) && $previousToken[0] === T_DOUBLE_COLON) {
                    //php 5.5 class name resolution (i.e. ClassName::class)
                    continue;
                }
                $token = $this->nextToken($tokens, $parseContext);

                if (is_string($token) && ($token === '(' || $token === '{')) {
                    // php7 anonymous classes (i.e. new class() { public function foo() {} };)
                    continue;
                }

                $definitionContext = new Context(['class' => $token[1], 'line' => $token[2]], $parseContext);
                if ($classDefinition) {
                    $analysis->addClassDefinition($classDefinition);
                }
                $classDefinition = [
                    'class' => $token[1],
                    'extends' => null,
                    'properties' => [],
                    'methods' => [],
                    'context' => $definitionContext
                ];
                // @todo detect end-of-class and reset $definitionContext
                $token = $this->nextToken($tokens, $parseContext);
                if ($token[0] === T_EXTENDS) {
                    $definitionContext->extends = $this->parseNamespace($tokens, $token, $parseContext);
                    $classDefinition['extends'] = $definitionContext->fullyQualifiedName($definitionContext->extends);
                }
                if ($comment) {
                    $definitionContext->line = $line;
                    $this->analyseComment($analysis, $analyser, $comment, $definitionContext);
                    $comment = false;
                    continue;
                }
            }
            if ($token[0] === T_TRAIT) {
                $classDefinition = false;
                $token = $this->nextToken($tokens, $parseContext);
                $definitionContext = new Context(['trait' => $token[1], 'line' => $token[2]], $parseContext);
                if ($comment) {
                    $definitionContext->line = $line;
                    $this->analyseComment($analysis, $analyser, $comment, $definitionContext);
                    $comment = false;
                    continue;
                }
            }
            if ($token[0] === T_STATIC) {
                $token = $this->nextToken($tokens, $parseContext);
                if ($token[0] === T_VARIABLE) { // static property
                    $propertyContext = new Context([
                        'property' => substr($token[1], 1),
                        'static' => true,
                        'line' => $line
                            ], $definitionContext);
                    if ($classDefinition) {
                        $classDefinition['properties'][$propertyContext->property] = $propertyContext;
                    }
                    if ($comment) {
                        $this->analyseComment($analysis, $analyser, $comment, $propertyContext);
                        $comment = false;
                    }
                    continue;
                }
            }

            if (in_array($token[0], [T_PRIVATE, T_PROTECTED, T_PUBLIC, T_VAR])) { // Scope
                $token = $this->nextToken($tokens, $parseContext);
                if ($token[0] == T_STATIC) {
                    $token = $this->nextToken($tokens, $parseContext);
                }
                if ($token[0] === T_VARIABLE) { // instance property
                    $propertyContext = new Context([
                        'property' => substr($token[1], 1),
                        'line' => $line
                            ], $definitionContext);
                    if ($classDefinition) {
                        $classDefinition['properties'][$propertyContext->property] = $propertyContext;
                    }
                    if ($comment) {
                        $this->analyseComment($analysis, $analyser, $comment, $propertyContext);
                        $comment = false;
                    }
                } elseif ($token[0] === T_FUNCTION) {
                    $token = $this->nextToken($tokens, $parseContext);
                    if ($token[0] === T_STRING) {
                        $methodContext = new Context([
                            'method' => $token[1],
                            'line' => $line
                                ], $definitionContext);
                        if ($classDefinition) {
                            $classDefinition['methods'][$token[1]] = $methodContext;
                        }
                        if ($comment) {
                            $this->analyseComment($analysis, $analyser, $comment, $methodContext);
                            $comment = false;
                        }
                    }
                }
                continue;
            } elseif ($token[0] === T_FUNCTION) {
                $token = $this->nextToken($tokens, $parseContext);
                if ($token[0] === T_STRING) {
                    $methodContext = new Context([
                        'method' => $token[1],
                        'line' => $line
                            ], $definitionContext);
                    if ($classDefinition) {
                        $classDefinition['methods'][$token[1]] = $methodContext;
                    }
                    if ($comment) {
                        $this->analyseComment($analysis, $analyser, $comment, $methodContext);
                        $comment = false;
                    }
                }
            }
            if (in_array($token[0], [T_NAMESPACE, T_USE]) === false) { // Skip "use" & "namespace" to prevent "never imported" warnings)
                // Not a doc-comment for a class, property or method?
                if ($comment) {
                    