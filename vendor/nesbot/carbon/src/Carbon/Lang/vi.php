<?php

/**
 * This file is part of the Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Carbon\Traits;

use BadMethodCallException;
use Carbon\CarbonInterface;
use Carbon\CarbonTimeZone;
use Closure;
use DateTime;
use DateTimeInterface;
use InvalidArgumentException;
use ReflectionException;

/**
 * A simple API extension for DateTime.
 *
 * <autodoc generated by `composer phpdoc`>
 *
 * @property      int            $year
 * @property      int            $yearIso
 * @property      int            $month
 * @property      int            $day
 * @property      int            $hour
 * @property      int            $minute
 * @property      int            $second
 * @property      int            $micro
 * @property      int            $microsecond
 * @property      int            $timestamp                                                                          seconds since the Unix Epoch
 * @property      string         $englishDayOfWeek                                                                   the day of week in English
 * @property      string         $shortEnglishDayOfWeek                                                              the abbreviated day of week in English
 * @property      string         $englishMonth                                                                       the day of week in English
 * @property      string         $shortEnglishMonth                                                                  the abbreviated day of week in English
 * @property      string         $localeDayOfWeek                                                                    the day of week in current locale LC_TIME
 * @property      string         $shortLocaleDayOfWeek                                                               the abbreviated day of week in current locale LC_TIME
 * @property      string         $localeMonth                                                                        the month in current locale LC_TIME
 * @property      string         $shortLocaleMonth                                                                   the abbreviated month in current locale LC_TIME
 * @property      int            $milliseconds
 * @property      int            $millisecond
 * @property      int            $milli
 * @property      int            $week  