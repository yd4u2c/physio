<?php

namespace DeepCopy\Reflection;

use DeepCopy\Exception\PropertyException;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use ReflectionProperty;

class ReflectionHelper
{
    /**
     * Retrieves all properties (including private ones), from object and all its ancestors.
     *
     * Standard \ReflectionClass->getProperties() does not return private properties from ancestor classes.
     *
     * @author muratyaman@gmail.com
     * @see http://php.net/manual/en/reflectionclass.getproperties.php
     *
     * @param ReflectionClass $ref
     *
     * @return ReflectionProperty[]
     */
    public static function getProperties(ReflectionClass $ref)
    {
        $props = $ref->getProperties();
        $propsArr = array();

        foreach ($props as $prop) {
            $propertyName = $prop->getName();
  