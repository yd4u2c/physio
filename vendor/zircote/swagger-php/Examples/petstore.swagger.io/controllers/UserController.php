<?php

/**
 * @license Apache 2.0
 */

namespace Swagger\Annotations;

/**
 * @Annotation
 *
 * A Swagger "XML Object": https://github.com/swagger-api/swagger-spec/blob/master/versions/2.0.md#xmlObject
 */
class Xml extends AbstractAnnotation
{
    /**
     * Replaces the name of the element/attribute used for the described schema property. When defined within the Items Object (items), it will affect the name of the individual XML elements within the list. When defined alongside type being array (outside the items), it will affect the wrapping element and only if wrapped is true. If wrapped is false, it will be ignored.
     * @var string
     */
    public $name;

    /**
     * The URL of the namespace definition. Value SHOULD be in the form of a URL.
     * @var string
     */
    public $namespace;

    /**
     * The prefix to be used for the name.
     * @var string
     */
    public $prefix;

    /**
     * Declares whether the property definition translates to an attribute instead of an element. Default value is false.
     * @var boolean
     */
    public $attribute;

    /**
     * MAY be used only for an array definition. Signifies whether the array is wrapped (for example, <books><book/><book/></books>) or unwrapped (<book/><book/>). Default value is false. The definition takes effect only when defined alongside type being array (outside the items).
     * @var boolean
     */
    public $wrapped;

    /** @inheritdoc */
    public static $_types = [
        'name' => 'string',
        'namespace' => 'string',
        'prefix' => 'string',
        'attribute' => 'boolean',
        'wrapped' => 'boolean'
    ];

    /** @inheritdoc */
    public static $_parents = [
        'Swagger\Annotations\Schema',
        'Swagger\Annotations\Property',
        'Swagger\Annotations\Definition',
        'Swagger\Annotations\Items',
    ];
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/**
 * @license Apache 2.0
 */

namespace Swagger\Processors;

use Swagger\Analysis;
use Swagger\Annotations\Definition;

/**
 * Use the definition context to extract useful information and inject that into the annotation.
 * Merges properties into
 */
class AugmentDefinitions
{
    public function __invoke(Analysis $analysis)
    {
        $definitions = $analysis->getAnnotationsOfType('\Swagger\Annotations\Definition');
        // Use the class names for @SWG\Definition()
        foreach ($definitions as $definition) {
            if ($definition->definition === null) {
                if ($definition->_context->is('class')) {
                    $definition->definition = $definition->_context->class;
                } elseif ($definition->_context->is('trait')) {
                    $definition->definition = $definition->_context->trait;
                }
                // if ($definition->type === null) {
                //     $definition->type = 'object';
                // }
            }
        }
        // Merge unmerged @SWG\Property annotations into the @SWG\Definition of the class
        $unmergedProperties = $analysis->unmerged()->getAnnotationsOfType('\Swagger\Annotations\Property');
        foreach ($unmergedProperties as $property) {
            if ($property->_context->nested) {
                continue;
            }
            $definitonContext = $property->_context->with('class') ?: $property->_context->with('trait');
            if ($definitonContext->annotations) {
                $definition = false;
                foreach ($definitonContext->annotations as $annotation) {
                    if ($annotation instanceof Definition) {
                        $definition = $annotation;
                    }
                }
                if ($definition) {
                    $definition->merge([$property], true);
                }
            }
        }
    }
}
                                            