<?php

namespace Faker\Provider\ar_SA;

use Faker\Calculator\Luhn;

class Person extends \Faker\Provider\Person
{
    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{firstNameMale}} {{firstNameMale}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}}',
    );

    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{firstNameMale}} {{lastName}}',
        '{{firstNameFemale}} {{firstNameMale}} {{firstNameMale}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}}',
    );

    /**
     * @link http://muslim-names.us/
     */
    protected static $firstNameMale = array(

        'آدم', 'أبراهيم', 'أحمد', 'أدهم', 'أسامة', 'أسعد', 'أشرف', 'أكثم', 'أكرم', 'أمجد', 'أمين', 'أنس', 'أنور', 'أواس', 'أوس', 'أيمن', 'أيهم', 'أيوب', 'إبراهيم', 'إسلام', 'إسماعيل', 'إلياس', 'إياد', 'إيهاب', 'ابان', 'ابراهيم', 'اثير', 'احسان', 'احمد', 'ادريس', 'ادم', 'ادهم', 'اديب', 'اسامة',
        'اسحاق', 'اسحق', 'اسعد', 'اسلام', 'اسماعيل', 'اسيد', 'اشراف', 'اشرف', 'اصلان', 'اكثم', 'اكرم', 'البراء', 'البشر', 'الحارث', 'الحسين', 'الطفيل', 'العزم', 'الليث', 'المثنى', 'المنصور', '�