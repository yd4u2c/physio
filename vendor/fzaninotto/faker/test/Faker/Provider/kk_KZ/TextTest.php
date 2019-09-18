<?php
namespace Hamcrest;

/*
 Copyright (c) 2009 hamcrest.org
 */
use Hamcrest\Internal\SelfDescribingValue;

/**
 * A {@link Hamcrest\Description} that is stored as a string.
 */
abstract class BaseDescription implements Description
{

    public function appendText($text)
    {
        $this->append($text);

        return $this;
    }

    public function appendDescriptionOf(SelfDescribing $value)
    {
        $value->describeTo($this);

        return $this;
    }

    public function appendValue($value)
    {
        if (is_null($value)) {
            $this->append('null');
        } elseif (is_string($value)) {
            $this->_toPhpSyntax($value);
        } elseif (is_float($value)) {
            $this->append('<');
            $this->append($value);
            $this->append('F>');
        } elseif (is_bool($value)) {
            $this->append('<');
            $this->append($value ? 'true' : 'false');
            $this->append('>');
        } elseif (is_array($value) || $value instanceof \Iterator || $value instanceof \IteratorAggregate) {
            $this->appendValueList('[', ', ', ']', $value);
        } elseif (is_object($value) && !method_exists($value, '__toString')) {
            $this->append('<');
            $this->append(get_class($value));
            $this->append('>');
        } else {
            $this->append('<');
            $this->append($value);
            $this->append('>');
        }

        return $this;
    }

    public function appendValueList($start, $separator, $end, $values)
    {
        $list = array();
        foreach ($values as $v) {
            $list[] = new SelfDescribingValue($v);
        }

        $this->appendList($start, $separator, $end, $list);

        return $this;
    }

    public function appendList($start, $separator, $end, $values)
    {
        $this->append($start);

        $separate = false;

        foreach ($values as $value) {
            /*if (!($value instanceof Hamcrest\SelfDescribing)) {
                $value = new Hamc