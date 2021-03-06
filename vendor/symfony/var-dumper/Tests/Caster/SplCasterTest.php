 {
            $doctype = strtolower($doctype);
        }

        return $doctype."\n".$html;
    }

    /**
     * @param \DOMDocument    $document
     * @param Css\Rule\Rule[] $rules
     * @return \DOMDocument
     */
    protected function inline(\DOMDocument $document, array $rules)
    {
        if (empty($rules)) {
            return $document;
        }

        $propertyStorage = new \SplObjectStorage();

        $xPath = new \DOMXPath($document);

        usort($rules, array(RuleProcessor::class, 'sortOnSpecificity'));

        foreach ($rules as $rule) {
            try {
                if (null !== $this->cssConverter) {
                    $expression = $this->cssConverter->toXPath($rule->getSelector());
                } else {
                    // Compatibility layer for Symfony 2.7 and older
                    $expression = CssSelector::toXPath($rule->getSelector());
                }
            } catch (ExceptionInterface $e) {
                continue;
            }

            $elements = $xPath->query($expression);

            if ($elements === false) {
                continue;
            }

            foreach ($elements as $element) {
                $propertyStorage[$element] = $this->calculatePropertiesToBeApplied(
                    $rule->getProperties(),
                    $propertyStorage->contains($element) ? $propertyStorage[$element] : array()
                );
            }
        }

        foreach ($propertyStorage as $element) {
            $this->inlineCssOnElement($element, $propertyStorage[$element]);
        }

        return $document;
    }

    /**
     * Merge the CSS rules to determine the applied properties.
     *
     * @param Css\Property\Property[] $properties
     * @param Css\Property\Property[] $cssProperties existing applied properties indexed by name
     *
     * @return Css\Property\Property[] updated properties, indexed by name
     */
    private function calculatePropertiesToBeApplied(array $properties, array $cssProperties)
    {
        if (empty($properties)) {
            return $cssProperties;
        }

        foreach ($properties as $property) {
            if (isset($cssProperties[$property->getName()])) {
                $existingProperty = $cssProperties[$property->getName()];

                //skip check to overrule if existing property is important and current is not
                if ($existingProperty->isImportant() && !$property->isImportant()) {
                    continue;
                }

                //overrule if current property is important and existing is not, else check specificity
                $overrule = !$existingProperty->isImportant() && $property->isImportant();
                if (!$overrule) {
                    $overrule = $existingProperty->getOriginalSpecificity()->compareTo($property->getOriginalSpecificity()) <= 0;
                }

                if ($overrule) {
                    unset($cssProperties[$property->getName()]);
                    $cssProperties[$property->getName()] = $property;
                }
            } else {
                $cssProperties[$property->getName()] = $property;
            }
        }

        return $cssProperties;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace TijsVerkoyen\CssToInlineStyles\Css;

use TijsVerkoyen\CssToInlineStyles\Css\Rule\Processor as RuleProcessor;
use TijsVerkoyen\CssToInlineStyles\Css\Rule\Rule;

class Processor
{
    /**
     * Get the rules from a given CSS-string
     *
     * @param string $css
     * @param array  $existingRules
     * @return Rule[]
     */
    public function getRules($css, $existingRules = array())
    {
        $css = $this->doCleanup($css);
        $rulesProcessor = new RuleProcessor();
        $rules = $rulesProcessor->splitIntoSeparateRules($css);

        return $rulesProc