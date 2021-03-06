<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Finder\Tests\Iterator;

use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class RecursiveDirectoryIteratorTest extends IteratorTestCase
{
    /**
     * @group network
     */
    public function testRewindOnFtp()
    {
        try {
            $i = new RecursiveDirectoryIterator('ftp://speedtest.tele2.net/', \RecursiveDirectoryIterator::SKIP_DOTS);
        } catch (\UnexpectedValueException $e) {
            $this->markTestSkipped('Unsupported stream "ftp".');
        }

        $i->rewind();

        $this->assertTrue(true);
    }

    /**
     * @group network
     */
    public function testSeekOnFtp()
    {
        try {
            $i = new RecursiveDirectoryIterator('ftp://speedtest.tele2.net/', \RecursiveDirectoryIterator::SKIP_DOTS);
        } catch (\UnexpectedValueException $e) {
            $this->markTestSkipped('Unsupported stream "ftp".');
        }

        $contains = [
            'ftp://speedtest.tele2.net'.\DIRECTORY_SEPARATOR.'1000GB.zip',
            'ftp://speedtest.tele2.net'.\DIRECTORY_SEPARATOR.'100GB.zip',
        ];
        $actual = [];

        $i->seek(0);
        $actual[] = $i->getPathname();

        $i->seek(1);
        $actual[] = $i->getPathname();

        $this->assertEquals($contains, $actual);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Finder\Tests\Iterator;

use Symfony\Component\Finder\Comparator\NumberComparator;
use Symfony\Component\Finder\Iterator\SizeRangeFilterIterator;

class SizeRangeFilterIteratorTest extends RealIteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($size, $expected)
    {
        $inner = new InnerSizeIterator(self::$files);

        $iterator = new SizeRangeFilterIterator($inner, $size);

        $this->assertIterator($expected, $iterator);
    }

    public function getAcceptData()
    {
        $lessThan1KGreaterThan05K = [
            '.foo',
            '.git',
            'foo',
            'qux',
            'test.php',
            'toto',
            'toto/.git',
        ];

        return [
            [[new NumberComparator('< 1K'), new NumberComparator('> 0.5K')], $this->toAbsolute($lessThan1KGreaterThan05K)],
        ];
    }
}

class InnerSizeIterator extends \ArrayIterator
{
    public function current()
    {
        return new \SplFileInfo(parent::current());
    }

    public function getFilename()
    {
        return parent::current();
    }

    public function isFile()
    {
        return $this->current()->isFile();
    }

    public function getSize()
    {
        return $this->current()->getSize();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Finder\Tests\Iterator;

use Symfony\Component\Finder\Iterator\SortableIterator;

class SortableIteratorTest extends RealIteratorTestCase
{
    public function testConstructor()
    {
        try {
            new SortableIterator(new Iterator([]), 'foobar');
            $this->fail('__construct() throws an \InvalidArgumentException exception if the mode is not valid');
        } catch (\Exception $e) {
            $this->assertInstanceOf('InvalidArgumentException', $e, '__construct() throws an \InvalidArgumentException exception if the mode is not valid');
        }
    }

    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($mode, $expected)
    {
        if (!\is_callable($mode)) {
            switch ($mode) {
                case SortableIterator::SORT_BY_ACCESSED_TIME:
                    if ('\\' === \DIRECTORY_SEPARATOR) {
                        touch(self::toAbsolute('.git'));
                    } else {
                        file_get_contents(self::toAbsolute('.git'));
                    }
                    sleep(1);
                    file_get_contents(self::toAbsolute('.bar'));
                    break;
                case SortableIterator::SORT_BY_CHANGED_TIME:
                    file_put_contents(self::toAbsolute('test.php'), 'foo');
                    sleep(1);
                    file_put_contents(self::toAbsolute('test.py'), 'foo');
                    break;
                case SortableIterator::SORT_BY_MODIFIED_TIME:
                    file_put_contents(self::toAbsolute('test.php'), 'foo');
                    sleep(1);
                    file_put_contents(self::toAbsolute('test.py'), 'foo');
                    break;
            }
        }

        $inner = new Iterator(self::$files);

        $iterator = new SortableIterator($inner, $mode);

        if (SortableIterator::SORT_BY_ACCESSED_TIME === $mode
            || SortableIterator::SORT_BY_CHANGED_TIME === $mode
            || SortableIterator::SORT_BY_MODIFIED_TIME === $mode
        ) {
            if ('\\' === \DIRECTORY_SEPARATOR && SortableIterator::SORT_BY_MODIFIED_TIME !== $mode) {
                $this->markTestSkipped('Sorting by atime or ctime is not supported on Windows');
            }
            $this->assertOrderedIteratorForGroups($expected, $iterator);
        } else {
            $this->assertOrderedIterator($expected, $iterator);
        }
    }

    public function getAcceptData()
    {
        $sortByName = [
            '.bar',
            '.foo',
            '.foo/.bar',
            '.foo/bar',
            '.git',
            'foo',
            'foo bar',
            'foo/bar.tmp',
            'qux',
            'qux/baz_100_1.py',
            'qux/baz_1_2.py',
            'qux_0_1.php',
            'qux_1000_1.php',
            'qux_1002_0.php',
            'qux_10_2.php',
            'qux_12_0.php',
            'qux_2_0.php',
            'test.php',
            'test.py',
            'toto',
            'toto/.git',
        ];

        $sortByType = [
            '.foo',
            '.git',
            'foo',
            'qux',
            'toto',
            'toto/.git',
            '.bar',
            '.foo/.bar',
            '.foo/bar',
            'foo bar',
            'foo/bar.tmp',
            'qux/baz_100_1.py',
            'qux/baz_1_2.py',
            'qux_0_1.php',
            'qux_1000_1.php',
            'qux_1002_0.php',
            'qux_10_2.php',
            'qux_12_0.php',
            'qux_2_0.php',
            'test.php',
            'test.py',
        ];

        $sortByAccessedTime = [
            // For these two files the access time was set to 2005-10-15
            ['foo/bar.tmp', 'test.php'],
            // These files were created more or less at the same time
            [
                '.git',
                '.foo',
                '.foo/.bar',
                '.foo/bar',
                'test.py',
                'foo',
                'toto',
                'toto/.git',
                'foo bar',
                'qux',
                'qux/baz_100_1.py',
                'qux/baz_1_2.py',
                'qux_0_1.php',
                'qux_1000_1.php',
                'qux_1002_0.php',
                'qux_10_2.php',
                'qux_12_0.php',
                'qux_2_0.php',
            ],
            // This file was accessed after sleeping for 1 sec
            ['.bar'],
        ];

        $sortByChangedTime = [
            [
                '.git',
                '.foo',
                '.foo/.bar',
                '.foo/bar',
                '.bar',
                'foo',
                'foo/bar.tmp',
                'toto',
                'toto/.git',
                'foo bar',
                'qux',
                'qux/baz_100_1.py',
                'qux/baz_1_2.py',
                'qux_0_1.php',
                'qux_1000_1.php',
                'qux_1002_0.php',
                'qux_10_2.php',
                'qux_12_0.php',
                'qux_2_0.php',
            ],
            ['test.php'],
            ['test.py'],
        ];

        $sortByModifiedTime = [
            [
                '.git',
                '.foo',
                '.foo/.bar',
                '.foo/bar',
                '.bar',
                'foo',
                'foo/bar.tmp',
                'toto',
                'toto/.git',
                'foo bar',
                'qux',
                'qux/baz_100_1.py',
                'qux/baz_1_2.py',
                'qux_0_1.php',
                'qux_1000_1.php',
                'qux_1002_0.php',
                'qux_10_2.php',
                'qux_12_0.php',
                'qux_2_0.php',
            ],
            ['test.php'],
            ['test.py'],
        ];

        $sortByNameNatural = [
            '.bar',
            '.foo',
            '.foo/.bar',
            '.foo/bar',
            '.git',
            'foo',
            'foo/bar.tmp',
            'foo bar',
            'qux',
            'qux/baz_1_2.py',
            'qux/baz_100_1.py',
            'qux_0_1.php',
            'qux_2_0.php',
            'qux_10_2.php',
            'qux_12_0.php',
            'qux_1000_1.php',
            'qux_1002_0.php',
            'test.php',
            'test.py',
            'toto',
            'toto/.git',
        ];

        $customComparison = [
            '.bar',
            '.foo',
            '.foo/.bar',
            '.foo/bar',
            '.git',
            'foo',
            'foo bar',
            'foo/bar.tmp',
            'qux',
            'qux/baz_100_1.py',
            'qux/baz_1_2.py',
            'qux_0_1.php',
            'qux_1000_1.php',
            'qux_1002_0.php',
            'qux_10_2.php',
            'qux_12_0.php',
            'qux_2_0.php',
            'test.php',
            'test.py',
            'toto',
            'toto/.git',
        ];

        return [
            [SortableIterator::SORT_BY_NAME, $this->toAbsolute($sortByName)],
            [SortableIterator::SORT_BY_TYPE, $this->toAbsolute($sortByType)],
            [SortableIterator::SORT_BY_ACCESSED_TIME, $this->toAbsolute($sortByAccessedTime)],
            [SortableIterator::SORT_BY_CHANGED_TIME, $this->toAbsolute($sortByChangedTime)],
            [SortableIterator::SORT_BY_MODIFIED_TIME, $this->toAbsolute($sortByModifiedTime)],
            [SortableIterator::SORT_BY_NAME_NATURAL, $this->toAbsolute($sortByNameNatural)],
            [function (\SplFileInfo $a, \SplFileInfo $b) { return strcmp($a->getRealPath(), $b->getRealPath()); }, $this->toAbsolute($customComparison)],
        ];
    }
}
                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

/**
 * Represents an Accept-* header.
 *
 * An accept header is compound with a list of items,
 * sorted by descending quality.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class AcceptHeader
{
    /**
     * @var AcceptHeaderItem[]
     */
    private $items = [];

    /**
     * @var bool
     */
    private $sorted = true;

    /**
     * @param AcceptHeaderItem[] $items
     */
    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * Builds an AcceptHeader instance from a string.
     *
     * @param string $headerValue
     *
     * @return self
     */
    public static function fromString($headerValue)
    {
        $index = 0;

        $parts = HeaderUtils::split((string) $headerValue, ',;=');

        return new self(array_map(function ($subParts) use (&$index) {
            $part = array_shift($subParts);
            $attributes = HeaderUtils::combine($subParts);

            $item = new AcceptHeaderItem($part[0], $attributes);
            $item->setIndex($index++);

            return $item;
        }, $parts));
    }

    /**
     * Returns header value's string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return implode(',', $this->items);
    }

    /**
     * Tests if header has given value.
     *
     * @param string $value
     *
     * @return bool
     */
    public function has($value)
    {
        return isset($this->items[$value]);
    }

    /**
     * Returns given value's item, if exists.
     *
     * @param string $value
     *
     * @return AcceptHeaderItem|null
     */
    public function get($value)
    {
        return $this->items[$value] ?? $this->items[explode('/', $value)[0].'/*'] ?? $this->items['*/*'] ?? $this->items['*'] ?? null;
    }

    /**
     * Adds an item.
     *
     * @return $this
     */
    public function add(AcceptHeaderItem $item)
    {
        $this->items[$item->getValue()] = $item;
        $this->sorted = false;

        return $this;
    }

    /**
     * Returns all items.
     *
     * @return AcceptHeaderItem[]
     */
    public function all()
    {
        $this->sort();

        return $this->items;
    }

    /**
     * Filters items on their value using given regex.
     *
     * @param string $pattern
     *
     * @return self
     */
    public function filter($pattern)
    {
        return new self(array_filter($this->items, function (AcceptHeaderItem $item) use ($pattern) {
            return preg_match($pattern, $item->getValue());
        }));
    }

    /**
     * Returns first item.
     *
     * @return AcceptHeaderItem|null
     */
    public function first()
    {
        $this->sort();

        return !empty($this->items) ? reset($this->items) : null;
    }

    /**
     * Sorts items by descending quality.
     */
    private function sort()
    {
        if (!$this->sorted) {
            uasort($this->items, function (AcceptHeaderItem $a, AcceptHeaderItem $b) {
                $qA = $a->getQuality();
                $qB = $b->getQuality();

                if ($qA === $qB) {
                    return $a->getIndex() > $b->getIndex() ? 1 : -1;
                }

                return $qA > $qB ? -1 : 1;
            });

            $this->sorted = true;
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

/**
 * Represents an Accept-* header item.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class AcceptHeaderItem
{
    private $value;
    private $quality = 1.0;
    private $index = 0;
    private $attributes = [];

    public function __construct(string $value, array $attributes = [])
    {
        $this->value = $value;
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }

    /**
     * Builds an AcceptHeaderInstance instance from a string.
     *
     * @param string $itemValue
     *
     * @return self
     */
    public static function fromString($itemValue)
    {
        $parts = HeaderUtils::split($itemValue, ';=');

        $part = array_shift($parts);
        $attributes = HeaderUtils::combine($parts);

        return new self($part[0], $attributes);
    }

    /**
     * Returns header value's string representation.
     *
     * @return string
     */
    public function __toString()
    {
        $string = $this->value.($this->quality < 1 ? ';q='.$this->quality : '');
        if (\count($this->attributes) > 0) {
            $string .= '; '.HeaderUtils::toString($this->attributes, ';');
        }

        return $string;
    }

    /**
     * Set the item value.
     *
     * @param string $value
     *
     * @return $this
     */
    pub