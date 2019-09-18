body {
    display: flex;
    flex-direction: column-reverse;
    justify-content: flex-end;
    max-width: 1140px;
    margin: auto;
    padding: 15px;
    word-wrap: break-word;
    background-color: #F9F9F9;
    color: #222;
    font-family: Helvetica, Arial, sans-serif;
    font-size: 14px;
    line-height: 1.4;
}
p {
    margin: 0;
}
a {
    color: #218BC3;
    text-decoration: none;
}
a:hover {
    text-decoration: underline;
}
.text-small {
    font-size: 12px !important;
}
article {
    margin: 5px;
    margin-bottom: 10px;
}
article > header > .row {
    display: flex;
    flex-direction: row;
    align-items: baseline;
    margin-bottom: 10px;
}
article > header > .row > .col {
    flex: 1;
    display: flex;
    align-items: baseline;
}
article > header > .row > h2 {
    font-size: 14px;
    color: #222;
    font-weight: normal;
    font-family: "Lucida Console", monospace, sans-serif;
    word-break: break-all;
    margin: 20px 5px 0 0;
    user-select: all;
}
article > header > .row > h2 > code {
    white-space: nowrap;
    user-select: none;
    color: #cc2255;
    background-color: #f7f7f9;
    border: 1px solid #e1e1e8;
    border-radius: 3px;
    margin-right: 5px;
    padding: 0 3px;
}
article > header > .row > time.col {
    flex: 0;
    text-align: right;
    white-space: nowrap;
    color: #999;
    font-style: italic;
}
article > header ul.tags {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 12px;
}
article > header ul.tags > li {
    user-select: all;
    margin-bottom: 2px;
}
article > header ul.tags > li > span.badge {
    display: inline-block;
    padding: .25em .4em;
    margin-right: 5px;
    border-radius: 4px;
    background-color: #6c757d3b;
    color: #524d4d;
    font-size: 12px;
    text-align: center;
    font-weight: 700;
    line-height: 1;
    white-space: nowrap;
    vertical-align: baseline;
    user-select: none;
}
article > section.body {
    border: 1px solid #d8d8d8;
    background: #FFF;
    padding: 10px;
    border-radius: 3px;
}
pre.sf-dump {
    border-radius: 3px;
    margin-bottom: 0;
}
.hidden {
    display: none !important;
}
.dumped-tag > .sf-dump {
    display: inline-block;
    margin: 0;
    padding: 1px 5px;
    line-height: 1.4;
    vertical-align: top;
    background-color: transparent;
    user-select: auto;
}
.dumped-tag > pre.sf-dump,
.dumped-tag > .sf-dump-default {
    color: #CC7832;
    background: none;
}
.dumped-tag > .sf-dump .sf-dump-str { color: #629755; }
.dumped-tag > .sf-dump .sf-dump-private,
.dumped-tag > .sf-dump .sf-dump-protected,
.dumped-tag > .sf-dump .sf-dump-public { color: #262626; }
.dumped-tag > .sf-dump .sf-dump-note { color: #6897BB; }
.dumped-tag > .sf-dump .sf-dump-key { color: #789339; }
.dumped-tag > .sf-dump .sf-dump-ref { color: #6E6E6E; }
.dumped-tag > .sf-dump .sf-dump-ellipsis { color: #CC7832; max-width: 100em; }
.dumped-tag > .sf-dump .sf-dump-ellipsis-path { max-width: 5em; }
.dumped-tag > .sf-dump .sf-dump-ns { user-select: none; }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\VarDumper\VarDumper;

if (!function_exists('dump')) {
    /**
     * @author Nicolas Grekas <p@tchwork.com>
     */
    function dump($var, ...$moreVars)
    {
        VarDumper::dump($var);

        foreach ($moreVars as $v) {
            VarDumper::dump($v);
        }

        if (1 < func_num_args()) {
            return func_get_args();
        }

        return $var;
    }
}

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }

        die(1);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   