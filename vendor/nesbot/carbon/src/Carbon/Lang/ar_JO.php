<?php

/**
 * This file is part of the Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Authors:
 * - bug-glibc-locales@gnu.org
 */
return array_replace_recursive(require __DIR__.'/en.php', [
    'formats' => [
        'L' => 'YYYY年MM月DD號',
    ],
    'months' => ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
    'months_short' => [' 1月', ' 2月', ' 3月', ' 4月', ' 5月', ' 6月', ' 7月', ' 8月', ' 9月', '10月', '11月', '12月'],
    'weekdays' => ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
    'weekdays_short' => ['日', '一', '二', '三', '四', '五', '六'],
    'weekdays_min' => ['日', '一', '二', '三', '四', '五', '六'],
    'meridiem' => ['上午', '下午'],

    'year' => ':count 年',
    'y' => ':count 年',
    'a_year' => ':count 年',

    'month' => ':count 月',
    'm' => ':count 月',
    'a_month' => ':count 月',

    'week' => ':count 周',
    'w' => ':count 周',
    'a_week' => ':count 周',

    'day' => ':count 白天',