e_callback('/\\\d/', 'static::randomDigit', $regex);
        $regex = preg_replace_callback('/(?<!\\\)\./', 'static::randomAscii', $regex);
        // remove remaining backslashes
        $regex = str_replace('\\', '', $regex);
        // phew
        return $regex;
    }

    /**
     * Converts string to lowercase.
     * Uses mb_string extension if available.
     *
     * @param  string $string String that should be converted to lowercase
     * @return string
     */
    public static function toLower($string = '')
    {
        return extension_loaded('mbstring') ? mb_strtolower($string, 'UTF-8') : strtolower($string);
    }

    /**
     * Converts string to uppercase.
     * Uses mb_string extension if available.
     *
     * @param  string $string String that should be converted to uppercase
     * @return string
     */
    public static function toUpper($string = '')
    {
        return extension_loaded('mbstring') ? mb_strtoupper($string, 'UTF-8') : strtoupper($string);
    }

    /**
     * Chainable method for making any formatter optional.
     *
     * @param float|integer $weight Set the probability of receiving a null value.
     *                              "0" will always return null, "1" will always return the generator.
     *                              If $weight is an integer value, then the same system works
     *                              between 0 (always get false) and 100 (always get true).
     * @return mixed|null
     */
    public function optional($weight = 0.5, $default = null)
    {
        // old system based on 0.1 <= $weight <= 0.9
        // TODO: remove in v2
        if ($weight > 0 && $weight < 1 && mt_rand() / mt_getrandmax() <= $weight) {
            return $this->generator;
        }

        // new system with percentage
        if (is_int($weight) && mt_rand(1, 100) <= $weight) {
            return $this->generator;
        }

        return new DefaultGenerator($default);
    }

    /**
     * Chainable method for making any formatter unique.
     *
     * <code>
     * // will never return twice the same value
     * $faker->unique()->randomElement(array(1, 2, 3));
     * </code>
     *
     * @param boolean $reset      If set to true, resets the list of existing values
     * @param integer $maxRetries Maximum number of retries to find a unique value,
     *                                       After which an OverflowException is thrown.
     * @throws \OverflowException When no unique value can be found by iterating $maxRetries times
     *
     * @return UniqueGenerator A proxy class returning only non-existing values
     */
    public function unique($reset = false, $maxRetries = 10000)
    {
        if ($reset || !$this->unique) {
            $this->unique = new UniqueGenerator($this->generator, $maxRetries);
        }

        return $this->unique;
    }

    /**
     * Chainable method for forcing any formatter to return only valid values.
     *
     * The value validity is determined by a function passed as first argument.
     *
     * <code>
     * $values = array();
     * $evenValidator = function ($digit) {
     * 	 return $digit % 2 === 0;
     * };
     * for ($i=0; $i < 10; $i++) {
     * 	 $values []= $faker->valid($evenValidator)->randomDigit;
     * }
     * print_r($values); // [0, 4, 8, 4, 2, 6, 0, 8, 8, 6]
     * </code>
     *
     * @param Closure $validator  A function returning true for valid values
     * @param integer $maxRetries Maximum number of retries to find a unique value,
     *                            After which an OverflowException is thrown.
     * @throws \OverflowException When no valid value can be found by iterating $maxRetries times
     *
     * @return ValidGenerator A proxy class returning only valid values
     */
    public function valid($validator = null, $maxRetries = 10000)
    {
        return new ValidGenerator($this->generator, $validator, $maxRetries);
    }
}
                                                                                                                                              <?php

namespace Faker\Provider;

class Biased extends Base
{
    /**
     * Returns a biased integer between $min and $max (both inclusive).
     * The distribution depends on $function.
     *
     * The algorithm creates two doubles, x ∈ [0, 1], y ∈ [0, 1) and checks whether the
     * return value of $function for x is greater than or equal to y. If this is
     * the case the number is accepted and x is mapped to the appropriate integer
     * between $min and $max. Otherwise two new doubles are created until the pair
     * is accepted.
     *
     * @param integer $min Minimum value of the generated integers.
     * @param integer $max Maximum value of the generated integers.
     * @param callable $function A function mapping x ∈ [0, 1] onto a double ∈ [0, 1]
     * @return integer An integer between $min and $max.
     */
    public function biasedNumberBetween($min = 0, $max = 100, $function = 'sqrt')
    {
        do {
            $x = mt_rand() / mt_getrandmax();
            $y = mt_rand() / (mt_getrandmax() + 1);
        } while (call_user_func($function, $x) < $y);

        return floor($x * ($max - $min + 1) + $min);
    }

    /**
     * 'unbiased' creates an unbiased distribution by giving
     * each value the same value of one.
     *
     * @return integer
     */
    protected static function unbiased()
    {
        return 1;
    }

    /**
     * 'linearLow' favors lower numbers. The probability decreases
     * in a linear fashion.
     *
     * @return integer
     */
    protected static function linearLow($x)
    {
        return 1 - $x;
    }

    /**
     * 'linearHigh' favors higher numbers. The probability increases
     * in a linear fashion.
     *
     * @return integer
     */
    protected static function linearHigh($x)
    {
        return $x;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace Faker\Provider;

/**
 * @author lsv
 */
class Color extends Base
{
    protected static $safeColorNames = array(
        'black', 'maroon', 'green', 'navy', 'olive',
        'purple', 'teal', 'lime', 'blue', 'silver',
        'gray', 'yellow', 'fuchsia', 'aqua', 'white'
    );

    protected static $allColorNames = array(
        'AliceBlue', 'AntiqueWhite', 'Aqua', 'Aquamarine',
        'Azure', 'Beige', 'Bisque', 'Black', 'BlanchedAlmond',
        'Blue', 'BlueViolet', 'Brown', 'BurlyWood', 'CadetBlue',
        'Chartreuse', 'Chocolate', 'Coral', 'CornflowerBlue',
        'Cornsilk', 'Crimson', 'Cyan', 'DarkBlue', 'DarkCyan',
        'DarkGoldenRod', 'DarkGray', 'DarkGreen', 'DarkKhaki',
        'DarkMagenta', 'DarkOliveGreen', 'Darkorange', 'DarkOrchid',
        'DarkRed', 'DarkSalmon', 'DarkSeaGreen', 'DarkSlateBlue',
        'DarkSlateGray', 'DarkTurquoise', 'DarkViolet', 'DeepPink',
        'DeepSkyBlue', 'DimGray', 'DimGrey', 'DodgerBlue', 'FireBrick',
        'FloralWhite', 'ForestGreen', 'Fuchsia', 'Gainsboro', 'GhostWhite',
        'Gold', 'GoldenRod', 'Gray', 'Green', 'GreenYellow', 'HoneyDew',
        'HotPink', 'IndianRed', 'Indigo', 'Ivory', 'Khaki', 'Lavender',
        'LavenderBlush', 'LawnGreen', 'LemonChiffon', 'LightBlue', 'LightCoral',
        'LightCyan', 'LightGoldenRodYellow', 'LightGray', 'LightGreen', 'LightPink',
        'LightSalmon', 'LightSeaGreen', 'LightSkyBlue', 'LightSlateGray', 'LightSteelBlue',
        'LightYellow', 'Lime', 'LimeGreen', 'Linen', 'Magenta', 'Maroon', 'MediumAquaMarine',
        'MediumBlue', 'MediumOrchid', 'MediumPurple', 'MediumSeaGreen', 'MediumSlateBlue',
        'MediumSpringGreen', 'MediumTurquoise', 'MediumVioletRed', 'MidnightBlue',
        'MintCream', 'MistyRose', 'Moccasin', 'NavajoWhite', 'Navy', 'OldLace', 'Olive',
        'OliveDrab', 'Orange', 'OrangeRed', 'Orchid', 'PaleGoldenRod', 'PaleGreen',
        'PaleTurquoise', 'PaleVioletRed', 'PapayaWhip', 'PeachPuff', 'Peru', 'Pink', 'Plum',
        'PowderBlue', 'Purple', 'Red', 'RosyBrown', 'RoyalBlue', 'SaddleBrown', 'Salmon',
        'SandyBrown', 'SeaGreen', 'SeaShell', 'Sienna', 'Silver', 'SkyBlue', 'SlateBlue',
        'SlateGray', 'Snow', 'SpringGreen', 'SteelBlue', 'Tan', 'Teal', 'Thistle', 'Tomato',
        'Turquoise', 'Violet', 'Wheat', 'White', 'WhiteSmoke', 'Yellow', 'YellowGreen'
    );

    /**
     * @example '#fa3cc2'
     */
    public static function hexColor()
    {
        return '#' . str_pad(dechex(mt_rand(1, 16777215)), 6, '0', STR_PAD_LEFT);
    }

    /**
     * @example '#ff0044'
     */
    public static function safeHexColor()
    {
        $color = str_pad(dechex(mt_rand(0, 255)), 3, '0', STR_PAD_LEFT);

        return '#' . $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
    }

    /**
     * @example 'array(0,255,122)'
     */
    public static function rgbColorAsArray()
    {
        $color = static::hexColor();

        return array(
            hexdec(substr($color, 1, 2)),
            hexdec(substr($color, 3, 2)),
            hexdec(substr($color, 5, 2))
        );
    }

    /**
     * @example '0,255,122'
     */
    public static function rgbColor()
    {
        return implode(',', static::rgbColorAsArray());
    }

    /**
     * @example 'rgb(0,255,122)'
     */
    public static function rgbCssColor()
    {
        return 'rgb(' . static::rgbColor() . ')';
    }

    /**
     * @example 'rgba(0,255,122,0.8)'
     */
    public static function rgbaCssColor()
    {
        return 'rgba(' . static::rgbColor() . ',' . static::randomFloat(1, 0, 1) . ')';
    }

    /**
     * @example 'blue'
     */
    public static function safeColorName()
    {
        return static::randomElement(static::$safeColorNames);
    }

    /**
     * @example 'NavajoWhite'
     */
    public static function colorName()
    {
        return static::randomElement(static::$allColorNames);
    }
}
                                                                                                                                                                 <?php

namespace Faker\Provider;

class Company extends Base
{
    protected static $formats = array(
        '{{lastName}} {{companySuffix}}',
    );

    protected static $companySuffix = array('Ltd');

    protected static $jobTitleFormat = array(
        '{{word}}',
    );

    /**
     * @example 'Acme Ltd'
     */
    public function company()
    {
        $format = static::randomElement(static::$formats);

        return $this->generator->parse($format);
    }

    /**
     * @example 'Ltd'
     */
    public static function companySuffix()
    {
        return static::randomElement(static::$companySuffix);
    }

    /**
     * @example 'Job'
     */
    public function jobTitle()
    {
        $format = static::randomElement(static::$jobTitleFormat);

        return $this->generator->parse($format);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace Faker\Provider;

class DateTime extends Base
{
    protected static $century = array('I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII','XIII','XIV','XV','XVI','XVII','XVIII','XIX','XX','XXI');

    protected static $defaultTimezone = null;

    /**
     * @param string|float|int $max
     * @return int|false
     */
    protected static function getMaxTimestamp($max = 'now')
    {
        if (is_numeric($max)) {
            return (int) $max;
        }

        if ($max instanceof \DateTime) {
            return $max->getTimestamp();
        }

        return strtotime(empty($max) ? 'now' : $max);
    }

    /**
     * Get a timestamp between January 1, 1970 and now
     *
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @return int
     *
     * @example 1061306726
     */
    public static function unixTime($max = 'now')
    {
        return mt_rand(0, static::getMaxTimestamp($max));
    }

    /**
     * Get a datetime object for a date between January 1, 1970 and now
     *
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @param string $timezone time zone in which the date time should be set, default to DateTime::$defaultTimezone, if set, otherwise the result of `date_default_timezone_get`
     * @example DateTime('2005-08-16 20:39:21')
     * @return \DateTime
     * @see http://php.net/manual/en/timezones.php
     * @see http://php.net/manual/en/function.date-default-timezone-get.php
     */
    public static function dateTime($max = 'now', $timezone = null)
    {
        return static::setTimezone(
            new \DateTime('@' . static::unixTime($max)),
            $timezone
        );
    }

    /**
     * Get a datetime object for a date between January 1, 001 and now
     *
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @param string|null $timezone time zone in which the date time should be set, default to DateTime::$defaultTimezone, if set, otherwise the result of `date_default_timezone_get`
     * @example DateTime('1265-03-22 21:15:52')
     * @return \DateTime
     * @see http://php.net/manual/en/timezones.php
     * @see http://php.net/manual/en/function.date-default-timezone-get.php
     */
    public static function dateTimeAD($max = 'now', $timezone = null)
    {
        $min = (PHP_INT_SIZE>4 ? -62135597361 : -PHP_INT_MAX);
        return static::setTimezone(
            new \DateTime('@' . mt_rand($min, static::getMaxTimestamp($max))),
            $timezone
        );
    }

    /**
     * get a date string formatted with ISO8601
     *
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example '2003-10-21T16:05:52+0000'
     */
    public static function iso8601($max = 'now')
    {
        return static::date(\DateTime::ISO8601, $max);
    }

    /**
     * Get a date string between January 1, 1970 and now
     *
     * @param string               $format
     * @param \DateTime|int|string $max    maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example '2008-11-27'
     */
    public static function date($format = 'Y-m-d', $max = 'now')
    {
        return static::dateTime($max)->format($format);
    }

    /**
     * Get a time string (24h format by default)
     *
     * @param string               $format
     * @param \DateTime|int|string $max    maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example '15:02:34'
     */
    public static function time($format = 'H:i:s', $max = 'now')
    {
        return static::dateTime($max)->format($format);
    }

    /**
     * Get a DateTime object based on a random date between two given dates.
     * Accepts date strings that can be recognized by strtotime().
     *
     * @param \DateTime|string $startDate Defaults to 30 years ago
     * @param \DateTime|string $endDate   Defaults to "now"
     * @param string|null $timezone time zone in which the date time should be set, default to DateTime::$defaultTimezone, if set, otherwise the result of `date_default_timezone_get`
     * @example DateTime('1999-02-02 11:42:52')
     * @return \DateTime
     * @see http://php.net/manual/en/timezones.php
     * @see http://php.net/manual/en/function.date-default-timezone-get.php
     */
    public static function dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)
    {
        $startTimestamp = $startDate instanceof \DateTime ? $startDate->getTimestamp() : strtotime($startDate);
        $endTimestamp = static::getMaxTimestamp($endDate);

        if ($startTimestamp > $endTimestamp) {
            throw new \InvalidArgumentException('Start date must be anterior to end date.');
        }

        $timestamp = mt_rand($startTimestamp, $endTimestamp);

        return static::setTimezone(
            new \DateTime('@' . $timestamp),
            $timezone
        );
    }

    /**
     * Get a DateTime object based on a random date between one given date and
     * an interval
     * Accepts date string that can be recognized by strtotime().
     *
     * @param string $date      Defaults to 30 years ago
     * @param string $interval  Defaults to 5 days after
     * @param string|null $timezone time zone in which the date time should be set, default to DateTime::$defaultTimezone, if set, otherwise the result of `date_default_timezone_get`
     * @example dateTimeInInterval('1999-02-02 11:42:52', '+ 5 days')
     * @return \DateTime
     * @see http://php.net/manual/en/timezones.php
     * @see http://php.net/manual/en/function.date-default-timezone-get.php
     */
    public static function dateTimeInInterval($date = '-30 years', $interval = '+5 days', $timezone = null)
    {
        $intervalObject = \DateInterval::createFromDateString($interval);
        $datetime       = $date instanceof \DateTime ? $date : new \DateTime($date);
        $otherDatetime  = clone $datetime;
        $otherDatetime->add($intervalObject);

        $begin = $datetime > $otherDatetime ? $otherDatetime : $datetime;
        $end = $datetime===$begin ? $otherDatetime : $datetime;

        return static::dateTimeBetween(
            $begin,
            $end,
            $timezone
        );
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @param string|null $timezone time zone in which the date time should be set, default to DateTime::$defaultTimezone, if set, otherwise the result of `date_default_timezone_get`
     * @example DateTime('1964-04-04 11:02:02')
     * @return \DateTime
     */
    public static function dateTimeThisCentury($max = 'now', $timezone = null)
    {
        return static::dateTimeBetween('-100 year', $max, $timezone);
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @param string|null $timezone time zone in which the date time should be set, default to DateTime::$defaultTimezone, if set, otherwise the result of `date_default_timezone_get`
     * @example DateTime('2010-03-10 05:18:58')
     * @return \DateTime
     */
    public static function dateTimeThisDecade($max = 'now', $timezone = null)
    {
        return static::dateTimeBetween('-10 year', $max, $timezone);
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @param string|null $timezone time zone in which the date time should be set, default to DateTime::$defaultTimezone, if set, otherwise the result of `date_default_timezone_get`
     * @example DateTime('2011-09-19 09:24:37')
     * @return \DateTime
     */
    public static function dateTimeThisYear($max = 'now', $timezone = null)
    {
        return static::dateTimeBetween('-1 year', $max, $timezone);
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @param string|null $timezone time zone in which the date time should be set, default to DateTime::$defaultTimezone, if set, otherwise the result of `date_default_timezone_get`
     * @example DateTime('2011-10-05 12:51:46')
     * @return \DateTime
     */
    public static function dateTimeThisMonth($max = 'now', $timezone = null)
    {
        return static::dateTimeBetween('-1 month', $max, $timezone);
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example 'am'
     */
    public static function amPm($max = 'now')
    {
        return static::dateTime($max)->format('a');
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example '22'
     */
    public static function dayOfMonth($max = 'now')
    {
        return static::dateTime($max)->format('d');
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example 'Tuesday'
     */
    public static function dayOfWeek($max = 'now')
    {
        return static::dateTime($max)->format('l');
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example '7'
     */
    public static function month($max = 'now')
    {
        return static::dateTime($max)->format('m');
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example 'September'
     */
    public static function monthName($max = 'now')
    {
        return static::dateTime($max)->format('F');
    }

    /**
     * @param \DateTime|int|string $max maximum timestamp used as random end limit, default to "now"
     * @return string
     * @example '1673'
     */
    public static function year($max = 'now')
    {
        return static::dateTime($max)->format('Y');
    }

    /**
     * @return string
     * @example 'XVII'
     */
    public static function century()
    {
        return static::randomElement(static::$century);
    }

    /**
     * @return string
     * @example 'Europe/Paris'
     */
    public static function timezone()
    {
        return static::randomElement(\DateTimeZone::listIdentifiers());
    }

    /**
     * Internal method to set the time zone on a DateTime.
     *
     * @param \DateTime $dt
     * @param string|null $timezone
     *
     * @return \DateTime
     */
    private static function setTimezone(\DateTime $dt, $timezone)
    {
        return $dt->setTimezone(new \DateTimeZone(static::resolveTimezone($timezone)));
    }

    /**
     * Sets default time zone.
     *
     * @param string $timezone
     *
     * @return void
     */
    public static function setDefaultTimezone($timezone = null)
    {
        static::$defaultTimezone = $timezone;
    }

    /**
     * Gets default time zone.
     *
     * @return string|null
     */
    public static function getDefaultTimezone()
    {
        return static::$defaultTimezone;
    }

    /**
     * @param string|null $timezone
     * @return null|string
     */
    private static function resolveTimezone($timezone)
    {
        return ((null === $timezone) ? ((null === static::$defaultTimezone) ? date_default_timezone_get() : static::$defaultTimezone) : $timezone);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        INDX( 	 4�k             (   �  �       �    h ��          	     h X          �/B�ok� Uze���h��<��/B�ok�       �               A d d r e s s . p h p      ` L          �v��ok�c�J�ok�c�J�ok��v��ok�                        a r _ J O d e "     ` L          z8M�ok�Qp��ok�Qp��ok�z8M�ok�                        a r _ S A d e *     ` L          �҈�ok�����ok�����ok��҈�ok�                        a t _ A T d e 
     h X          X�F�ok� Uze��Uk��<�X�F�ok        �
               B a r c o d e . p h p      h R          TN�ok� Uze��Uk��<�TN�ok� P      rO               B a s e . p h p       ,     ` L          �\��ok�i��ok�i��ok��\��ok�                        b g _ B G d .      h V          �R�ok� Uze���m��<��R�ok�       #              
 B i a s e d . p h p   1     ` L          �n��ok�����ok�����ok��n��ok�                        b n _ B D . p      h T          ��W�ok� Uze�6p��<���W�ok�      _              	 C o l o r . p h p          h X          �Z�ok� Uze�6p��<��Z�ok�       =               C o m p a n y . p h p 7     ` L          ����ok�K�(�ok�K�(�ok�����ok�                        c s _ C Z i m      p Z          ?�c�ok� Uze�}r��<�?�c�ok� 0      x-               D a t e T i m e . p h p       @     ` L          �U-�ok�TL�ok�TL�ok��U-�ok�                        d a _ D K p h G     ` L          s�N�ok�_��ok�_��ok�s�N�ok�                       d e _ A T p h O     ` L          vG��ok����ok����ok�vG��ok�                        d e _ C H p h W     ` L          ���ok����ok����ok����ok�                        d e _ D E p h _     ` L          A�ok��QO�ok��QO�ok�A�ok�                        e l _ C Y p h f     ` L          �Q�ok�Rؖ�ok�Rؖ�ok��Q�ok�                        e l _ G R p h m     ` L          ����ok�gu��ok�gu��ok�����ok�                        e n _ A U p                     �׵�ok����]%��׵�ok��׵�ok�                        e n _ C A p h t     ` L          W%��ok�y�]%�W%��ok�W%��ok�                        e n _ G B p h z     ` L          F��ok�_���]%�F��ok�F��ok�                        e n _ H K p h ~     ` L          ����ok�����]%�����ok�����ok�                        e n _ I N p h �     ` L          �p�ok��ì]%��p�ok��p�ok�                        e n _ N G p h �     ` L          ��%�ok 6�Ӭ]%���%�ok���%�ok�                        e n _ N Z p h �     ` L          �o/�ok�2��]%�}�1�ok��o/�ok�                        e n _ P H p h      h R          ��q�ok� Uze���t��<���q�ok� �      ޾               F i l e . p h p            p \          ���ok� Uze���t��<����ok� 0      k%               H t m l L o r e m . p h p          h T          \{��ok� Uze��Aw��<�\{��ok�                     	 I m a g e . p h p          p Z          ���ok  Uze�0�y��<����ok� @      `=               I n t e r n e t . p h p            h T          �R��ok� Uze��|��<��R��ok�        �              	 L o r e m . p h p          x d          ۠��ok� Uze��|��<�۠��ok� @      54               M i s c e l l a n e o u s . p h p          h X          :*��ok� Uze��h~��<�:*��ok� 0      �-               P a y m e n t . p h p      h V          ����ok� Uze��ʀ��<�����ok�       E              
 P e r s o n . p h p       p `          ���ok� Uze��ʀ��<����ok�                      P h o n e N u m b e r . p h p      h R          c���ok� Uze��-���<�c���ok�        �               T e x t . p h p            p \          P��ok� Uze������<�P��ok�        �               U s e r A g e n t . p h p          h R          ���ok� Uze����<����ok�       �               U u i d . p h p                                                                                    <?php
namespace Faker\Provider;

class File extends Base
{

    /**
     * MIME types from the apache.org file. Some types are truncated.
     *
     * @var array Map of MIME types => file extension(s)
     * @link http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
     */
    protected static $mimeTypes = array(
        'application/atom+xml'                                                      => 'atom',
        'application/ecmascript'                                                    => 'ecma',
        'application/emma+xml'                                                      => 'emma',
        'application/epub+zip'                                                      => 'epub',
        'application/java-archive'                                                  => 'jar',
        'application/java-vm'                                                       => 'class',
        'application/javascript'                                                    => 'js',
        'application/json'                                                          => 'json',
        'application/jsonml+json'                                                   => 'jsonml',
        'application/lost+xml'                                                      => 'lostxml',
        'application/mathml+xml'                                                    => 'mathml',
        'application/mets+xml'                                                      => 'mets',
        'application/mods+xml'                                                      => 'mods',
        'application/mp4'                                                           => 'mp4s',
        'application/msword'                                                        => array('doc', 'dot'),
        'application/octet-stream'                                                  => array(
            'bin',
            'dms',
            'lrf',
            'mar',
            'so',
            'dist',
            'distz',
            'pkg',
            'bpk',
            'dump',
            'elc',
            'deploy'
        ),
        'application/ogg'                                                           => 'ogx',
        'application/omdoc+xml'                                                     => 'omdoc',
        'application/pdf'                                                           => 'pdf',
        'application/pgp-encrypted'                                                 => 'pgp',
        'application/pgp-signature'                                                 => array('asc', 'sig'),
        'application/pkix-pkipath'                                                  => 'pkipath',
        'application/pkixcmp'                                                       => 'pki',
        'application/pls+xml'                                                       => 'pls',
        'application/postscript'                                                    => array('ai', 'eps', 'ps'),
        'application/pskc+xml'                                                      => 'pskcxml',
        'application/rdf+xml'                                                       => 'rdf',
        'application/reginfo+xml'                                                   => 'rif',
        'application/rss+xml'                                                       => 'rss',
        'application/rtf'                                                           => 'rtf',
        'application/sbml+xml'                                                      => 'sbml',
        'application/vnd.adobe.air-application-installer-package+zip'               => 'air',
        'application/vnd.adobe.xdp+xml'                                             => 'xdp',
        'application/vnd.adobe.xfdf'                                                => 'xfdf',
        'application/vnd.ahead.space'                                               => 'ahead',
        'application/vnd.dart'                                                      => 'dart',
        'application/vnd.data-vision.rdz'                                           => 'rdz',
        'application/vnd.dece.data'                                                 => array('uvf', 'uvvf', 'uvd', 'uvvd'),
        'application/vnd.dece.ttml+xml'                                             => array('uvt', 'uvvt'),
        'application/vnd.dece.unspecified'                                          => array('uvx', 'uvvx'),
        'application/vnd.dece.zip'                                                  => array('uvz', 'uvvz'),
        'application/vnd.denovo.fcselayout-link'                                    => 'fe_launch',
        'application/vnd.dna'                                                       => 'dna',
        'application/vnd.dolby.mlp'                                                 => 'mlp',
        'application/vnd.dpgraph'                                                   => 'dpg',
        'application/vnd.dreamfactory'                                              => 'dfac',
        'application/vnd.ds-keypoint'                                               => 'kpxx',
        'application/vnd.dvb.ait'                                                   => 'ait',
        'application/vnd.dvb.service'                                               => 'svc',
        'application/vnd.dynageo'                                                   => 'geo',
        'application/vnd.ecowin.chart'                                              => 'mag',
        'application/vnd.enliven'                                                   => 'nml',
        'application/vnd.epson.esf'                                                 => 'esf',
        'application/vnd.epson.msf'                                                 => 'msf',
        'application/vnd.epson.quickanime'                                          => 'qam',
        'application/vnd.epson.salt'                                                => 'slt',
        'application/vnd.epson.ssf'                                                 => 'ssf',
        'application/vnd.ezpix-album'                                               => 'ez2',
        'application/vnd.ezpix-package'                                             => 'ez3',
        'application/vnd.fdf'                                                       => 'fdf',
        'application/vnd.fdsn.mseed'                                                => 'mseed',
        'application/vnd.fdsn.seed'                                                 => array('seed', 'dataless'),
        'application/vnd.flographit'                                                => 'gph',
        'application/vnd.fluxtime.clip'                                             => 'ftc',
        'application/vnd.hal+xml'                                                   => 'hal',
        'application/vnd.hydrostatix.sof-data'                                      => 'sfd-hdstx',
        'application/vnd.ibm.minipay'                                               => 'mpy',
        'application/vnd.ibm.secure-container'                                      => 'sc',
        'application/vnd.iccprofile'                                                => array('icc', 'icm'),
        'application/vnd.igloader'                                                  => 'igl',
        'application/vnd.immervision-ivp'                                           => 'ivp',
        'application/vnd.kde.karbon'                                                => 'karbon',
        'application/vnd.kde.kchart'                                                => 'chrt',
        'application/vnd.kde.kformula'                                              => 'kfo',
        'application/vnd.kde.kivio'                                                 => 'flw',
        'application/vnd.kde.kontour'                                               => 'kon',
        'application/vnd.kde.kpresenter'                                            => array('kpr', 'kpt'),
        'application/vnd.kde.kspread'                                               => 'ksp',
        'application/vnd.kde.kword'                                                 => array('kwd', 'kwt'),
        'application/vnd.kenameaapp'                                                => 'htke',
        'application/vnd.kidspiration'                                              => 'kia',
        'application/vnd.kinar'                                                     => array('kne', 'knp'),
        'application/vnd.koan'                                                      => array('skp', 'skd', 'skt', 'skm'),
        'application/vnd.kodak-descriptor'                                          => 'sse',
        'application/vnd.las.las+xml'                                               => 'lasxml',
        'application/vnd.llamagraphics.life-balance.desktop'                        => 'lbd',
        'application/vnd.llamagraphics.life-balance.exchange+xml'                   => 'lbe',
        'application/vnd.lotus-1-2-3'                                               => '123',
        'application/vnd.lotus-approach'                                            => 'apr',
        'application/vnd.lotus-freelance'                                           => 'pre',
        'application/vnd.lotus-notes'                                               => 'nsf',
        'application/vnd.lotus-organizer'                                           => 'org',
        'application/vnd.lotus-screencam'                                           => 'scm',
        'application/vnd.mozilla.xul+xml'                                           => 'xul',
        'application/vnd.ms-artgalry'                                               => 'cil',
        'application/vnd.ms-cab-compressed'                                         => 'cab',
        'application/vnd.ms-excel'                                                  => array(
            'xls',
            'xlm',
            'xla',
            'xlc',
            'xlt',
            'xlw'
        ),
        'application/vnd.ms-excel.addin.macroenabled.12'                            => 'xlam',
        'application/vnd.ms-excel.sheet.binary.macroenabled.12'                     => 'xlsb',
        'application/vnd.ms-excel.sheet.macroenabled.12'                            => 'xlsm',
        'application/vnd.ms-excel.template.macroenabled.12'                         => 'xltm',
        'application/vnd.ms-fontobject'                                             => 'eot',
        'application/vnd.ms-htmlhelp'                                               => 'chm',
        'application/vnd.ms-ims'                                                    => 'ims',
        'application/vnd.ms-lrm'                                                    => 'lrm',
        'application/vnd.ms-officetheme'                                            => 'thmx',
        'application/vnd.ms-pki.seccat'                                             => 'cat',
        'application/vnd.ms-pki.stl'                                                => 'stl',
        'application/vnd.ms-powerpoint'                                             => array('ppt', 'pps', 'pot'),
        'application/vnd.ms-powerpoint.addin.macroenabled.12'                       => 'ppam',
        'application/vnd.ms-powerpoint.presentation.macroenabled.12'                => 'pptm',
        'application/vnd.ms-powerpoint.slide.macroenabled.12'                       => 'sldm',
        'application/vnd.ms-powerpoint.slideshow.macroenabled.12'                   => 'ppsm',
        'application/vnd.ms-powerpoint.template.macroenabled.12'                    => 'potm',
        'application/vnd.ms-project'                                                => array('mpp', 'mpt'),
        'application/vnd.ms-word.document.macroenabled.12'                          => 'docm',
        'application/vnd.ms-word.template.macroenabled.12'                          => 'dotm',
        'application/vnd.ms-works'                                                  => array('wps', 'wks', 'wcm', 'wdb'),
        'application/vnd.ms-wpl'                                                    => 'wpl',
        'application/vnd.ms-xpsdocument'                                            => 'xps',
        'application/vnd.mseq'                                                      => 'mseq',
        'application/vnd.musician'                                                  => 'mus',
        'application/vnd.oasis.opendocument.chart'                                  => 'odc',
        'application/vnd.oasis.opendocument.chart-template'                         => 'otc',
        'application/vnd.oasis.opendocument.database'                               => 'odb',
        'application/vnd.oasis.opendocument.formula'                                => 'odf',
        'application/vnd.oasis.opendocument.formula-template'                       => 'odft',
        'application/vnd.oasis.opendocument.graphics'                               => 'odg',
        'application/vnd.oasis.opendocument.graphics-template'                      => 'otg',
        'application/vnd.oasis.opendocument.image'                                  => 'odi',
        'application/vnd.oasis.opendocument.image-template'                         => 'oti',
        'application/vnd.oasis.opendocument.presentation'                           => 'odp',
        'application/vnd.oasis.opendocument.presentation-template'                  => 'otp',
        'application/vnd.oasis.opendocument.spreadsheet'                            => 'ods',
        'application/vnd.oasis.opendocument.spreadsheet-template'                   => 'ots',
        'application/vnd.oasis.opendocument.text'                                   => 'odt',
        'application/vnd.oasis.opendocument.text-master'                            => 'odm',
        'application/vnd.oasis.opendocument.text-template'                          => 'ott',
        'application/vnd.oasis.opendocument.text-web'                               => 'oth',
        'application/vnd.olpc-sugar'                                                => 'xo',
        'application/vnd.oma.dd2+xml'                                               => 'dd2',
        'application/vnd.openofficeorg.extension'                                   => 'oxt',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'application/vnd.openxmlformats-officedocument.presentationml.slide'        => 'sldx',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow'    => 'ppsx',
        'application/vnd.openxmlformats-officedocument.presentationml.template'     => 'potx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template'      => 'xltx',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template'   => 'dotx',
        'application/vnd.pvi.ptid1'                                                 => 'ptid',
        'application/vnd.quark.quarkxpress'                                         => array(
            'qxd',
            'qxt',
            'qwd',
            'qwt',
            'qxl',
            'qxb'
        ),
        'application/vnd.realvnc.bed'                                               => 'bed',
        'application/vnd.recordare.musicxml'                                        => 'mxl',
        'application/vnd.recordare.musicxml+xml'                                    => 'musicxml',
        'application/vnd.rig.cryptonote'                                            => 'cryptonote',
        'application/vnd.rim.cod'                                                   => 'cod',
        'application/vnd.rn-realmedia'                                              => 'rm',
        'application/vnd.rn-realmedia-vbr'                                          => 'rmvb',
        'application/vnd.route66.link66+xml'                                        => 'link66',
        'application/vnd.sailingtracker.track'                                      => 'st',
        'application/vnd.seemail'                                                   => 'see',
        'application/vnd.sema'                                                      => 'sema',
        'application/vnd.semd'                                                      => 'semd',
        'application/vnd.semf'                                                      => 'semf',
        'application/vnd.shana.informed.formdata'                                   => 'ifm',
        'application/vnd.shana.informed.formtemplate'                               => 'itp',
        'application/vnd.shana.informed.interchange'                                => 'iif',
        'application/vnd.shana.informed.package'                                    => 'ipk',
        'application/vnd.simtech-mindmapper'                                        => array('twd', 'twds'),
        'application/vnd.smaf'                                                      => 'mmf',
        'application/vnd.stepmania.stepchart'                                       => 'sm',
        'application/vnd.sun.xml.calc'                                              => 'sxc',
        'application/vnd.sun.xml.calc.template'                                     => 'stc',
        'application/vnd.sun.xml.draw'                                              => 'sxd',
        'application/vnd.sun.xml.draw.template'                                     => 'std',
        'application/vnd.sun.xml.impress'                                           => 'sxi',
        'application/vnd.sun.xml.impress.template'                                  => 'sti',
        'application/vnd.sun.xml.math'                                              => 'sxm',
        'application/vnd.sun.xml.writer'                                            => 'sxw',
        'application/vnd.sun.xml.writer.global'                                     => 'sxg',
        'application/vnd.sun.xml.writer.template'                                   => 'stw',
        'application/vnd.sus-calendar'                                              => array('sus', 'susp'),
        'application/vnd.svd'                                                       => 'svd',
        'application/vnd.symbian.install'                                           => array('sis', 'sisx'),
        'application/vnd.syncml+xml'                                                => 'xsm',
        'application/vnd.syncml.dm+wbxml'                                           => 'bdm',
        'application/vnd.syncml.dm+xml'                                             => 'xdm',
        'application/vnd.tao.intent-module-archive'                                 => 'tao',
        'application/vnd.tcpdump.pcap'                                              => array('pcap', 'cap', 'dmp'),
        'application/vnd.tmobile-livetv'                                            => 'tmo',
        'application/vnd.trid.tpt'                                                  => 'tpt',
        'application/vnd.triscape.mxs'                                              => 'mxs',
        'application/vnd.trueapp'                                                   => 'tra',
        'application/vnd.ufdl'                                                      => array('ufd', 'ufdl'),
        'application/vnd.uiq.theme'                                                 => 'utz',
        'application/vnd.umajin'                                                    => 'umj',
        'application/vnd.unity'                                                     => 'unityweb',
        'application/vnd.uoml+xml'                                                  => 'uoml',
        'application/vnd.vcx'                                                       => 'vcx',
        'application/vnd.visio'                                                     => array('vsd', 'vst', 'vss', 'vsw'),
        'application/vnd.visionary'                                                 => 'vis',
        'application/vnd.vsf'                                                       => 'vsf',
        'application/vnd.wap.wbxml'                                                 => 'wbxml',
        'application/vnd.wap.wmlc'                                                  => 'wmlc',
        'application/vnd.wap.wmlscriptc'                                            => 'wmlsc',
        'application/vnd.webturbo'                                                  => 'wtb',
        'application/vnd.wolfram.player'                                            => 'nbp',
        'application/vnd.wordperfect'                                               => 'wpd',
        'application/vnd.wqd'                                                       => 'wqd',
        'application/vnd.wt.stf'                                                    => 'stf',
        'application/vnd.xara'                                                      => 'xar',
        'application/vnd.xfdl'                                                      => 'xfdl',
        'application/voicexml+xml'                                                  => 'vxml',
        'application/widget'                                                        => 'wgt',
        'application/winhlp'                                                        => 'hlp',
        'application/wsdl+xml'                                                      => 'wsdl',
        'application/wspolicy+xml'                                                  => 'wspolicy',
        'application/x-7z-compressed'                                               => '7z',
        'application/x-bittorrent'                                                  => 'torrent',
        'application/x-blorb'                                                       => array('blb', 'blorb'),
        'application/x-bzip'                                                        => 'bz',
        'application/x-cdlink'                                                      => 'vcd',
        'application/x-cfs-compressed'                                              => 'cfs',
        'application/x-chat'                                                        => 'chat',
        'application/x-chess-pgn'                                                   => 'pgn',
        'application/x-conference'                                                  => 'nsc',
        'application/x-cpio'                                                        => 'cpio',
        'application/x-csh'                                                         => 'csh',
        'application/x-debian-package'                                              => array('deb', 'udeb'),
        'application/x-dgc-compressed'                                              => 'dgc',
        'application/x-director'                                                    => array(
            'dir',
            'dcr',
            'dxr',
            'cst',
            'cct',
            'cxt',
            'w3d',
            'fgd',
            'swa'
        ),
        'application/x-font-ttf'                                                    => array('ttf', 'ttc'),
        'application/x-font-type1'                                                  => array('pfa', 'pfb', 'pfm', 'afm'),
        'application/x-font-woff'                                                   => 'woff',
        'application/x-freearc'                                                     => 'arc',
        'application/x-futuresplash'                                                => 'spl',
        'application/x-gca-compressed'                                              => 'gca',
        'application/x-glulx'                                                       => 'ulx',
        'application/x-gnumeric'                                                    => 'gnumeric',
        'application/x-gramps-xml'                                                  => 'gramps',
        'application/x-gtar'                                                        => 'gtar',
        'application/x-hdf'                                                         => 'hdf',
        'application/x-install-instructions'                                        => 'install',
        'application/x-iso9660-image'                                               => 'iso',
        'application/x-java-jnlp-file'                                              => 'jnlp',
        'application/x-latex'                                                       => 'latex',
        'application/x-lzh-compressed'                                              => array('lzh', 'lha'),
        'application/x-mie'                                                         => 'mie',
        'application/x-mobipocket-ebook'                                            => array('prc', 'mobi'),
        'application/x-ms-application'                                              => 'application',
        'application/x-ms-shortcut'                                                 => 'lnk',
        '