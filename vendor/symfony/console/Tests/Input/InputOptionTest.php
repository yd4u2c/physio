<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Node;

/**
 * Represents a "<selector>.<name>" node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
class ClassNode extends AbstractNode
{
    private $selector;
    private $name;

    public function __construct(NodeInterface $selector, string $name)
    {
        $this->selector = $selector;
        $this->name = $name;
    }

    public function getSelector(): NodeInterface
    {
        return $this->selector;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getSpecificity(): Specificity
    {
        return $this->selector->getSpecificity()->plus(new Specificity(0, 1, 0));
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return sprintf('%s[%s.%s]', $this->getNodeName(), $this->selector, $this->name);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Node;

/**
 * Represents a combined node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
class CombinedSelectorNode extends AbstractNode
{
    private $selector;
    private $combinator;
    private $subSelector;

    public function __construct(NodeInterface $selector, string $combinator, NodeInterface $subSelector)
    {
        $this->selector = $selector;
        $this->combinator = $combinator;
        $this->subSelector = $subSelector;
    }

    public function getSelector(): NodeInterface
    {
        return $this->selector;
    }

    public function getCombinator(): string
    {
        return $this->combinator;
    }

    public function getSubSelector(): NodeInterface
    {
        return $this->subSelector;
    }

    /**
     * {@inheritdoc}
     */
    public function getSpecificity(): Specificity
    {
        return $this->selector->getSpecificity()->plus($this->subSelector->getSpecificity());
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        $combinator = ' ' === $this->combinator ? '<followed>' : $this->combinator;

        return sprintf('%s[%s %s %s]', $this->getNodeName(), $this->selector, $combinator, $this->subSelector);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Node;

/**
 * Represents a "<namespace>|<element>" node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
class ElementNode extends AbstractNode
{
    private $namespace;
    private $element;

    /**
     * @param string|null $namespace
     * @param string|null $element
     */
    public function __construct(string $namespace = null, string $elem