<?php
namespace Hamcrest\Number;

/*
 Copyright (c) 2009 hamcrest.org
 */
use Hamcrest\Description;
use Hamcrest\TypeSafeMatcher;

/**
 * Is the value a number equal to a value within some range of
 * acceptable error?
 */
class IsCloseTo extends TypeSafeMatcher
{

    private $_value;
    private $_delta;

    public function __construct($value, $delta)
    {
        parent::__construct(self::TYPE_NUMERIC);

        $this->_value = $value;
        $this->_delta = $delta;
    }

    protected function matchesSafely($item)
    {
        return $this->_actualDelta($item) <= 0.0;
    }

    protected function describeMismatchSafely($item, Description $mismatchDescription)
    {
        $mismatchDescription->appendValue($item)
                                                ->appendText(' differed by ')
                                                ->appendValue($this->_actualDelta($item))
                                                ;
    }

    public function describeTo(Description $description)
    {
        $description->appendText('a numeric value within ')
                                ->appendValue($this->_delta)
                                ->appendText(' of ')
                                ->appendValue($this->_value)
                                ;
    }

    /**
     * Matches if value is a number equal to $value within some range of
     * acceptable error $delta.
     *
     * @factory
     */
    public static function closeTo($value, $delta)
    {
        return new self($value, $delta);
    }

    // -- Private Methods

    private function _actualDelta($item)
    {
        return (abs(($item - $this->_value)) - $this->_delta);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php
namespace Hamcrest\Number;

/*
 Copyright (c) 2009 hamcrest.org
 */

use Hamcrest\Description;
use Hamcrest\TypeSafeMatcher;

class OrderingComparison extends TypeSafeMatcher
{

    private $_value;
    private $_minCompare;
    private $_maxCompare;

    public function __construct($value, $minCompare, $maxCompare)
    {
        parent::__construct(self::TYPE_NUMERIC);

        $this->_value = $value;
        $this->_minCompare = $minCompare;
        $this->_maxCompare = $maxCompare;
    }

    protected function matchesSafely($other)
    {
        $compare = $this->_compare($this->_value, $other);

        return ($this->_minCompare <= $compare) && ($compare <= $this->_maxCompare);
    }

    protected function describeMismatchSafely($item, Description $mismatchDescription)
    {
        $mismatchDescription
            ->appendValue($item)->appendText(' was ')
            ->appendText($this->_comparison($this->_compare($this->_value, $item)))
            ->appendText(' ')->appendValue($this->_value)
            ;
    }

    public function describeTo(Description $description)
    {
        $description->appendText('a value ')
            ->appendText($this->_comparison($this->_minCompare))
            ;
        if ($this->_minCompare != $this->_maxCompare) {
            $description->appendText(' or ')
                ->appendText($this->_comparison($this->_maxCompare))
                ;
        }
        $description->appendText(' ')->appendValue($this->_value);
    }

    /**
     * The value is not > $value, nor < $valu