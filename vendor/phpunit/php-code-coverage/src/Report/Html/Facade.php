body {
 padding-top: 10px;
}

.popover {
 max-width: none;
}

.octicon {
 margin-right:.25em;
}

.table-bordered>thead>tr>td {
 border-bottom-width: 1px;
}

.table tbody>tr>td, .table thead>tr>td {
 padding-top: 3px;
 padding-bottom: 3px;
}

.table-condensed tbody>tr>td {
 padding-top: 0;
 padding-bottom: 0;
}

.table .progress {
 margin-bottom: inherit;
}

.table-borderless th, .table-borderless td {
 border: 0 !important;
}

.table tbody tr.covered-by-large-tests, li.covered-by-large-tests, tr.success, td.success, li.success, span.success {
 background-color: #dff0d8;
}

.table tbody tr.covered-by-medium-tests, li.covered-by-medium-tests {
 background-color: #c3e3b5;
}

.table tbody tr.covered-by-small-tests, li.covered-by-small-tests {
 background-color: #99cb84;
}

.table tbody tr.danger, .table tbody td.danger, li.danger, span.danger {
 background-color: #f2dede;
}

.table tbody td.warning, li.warning, span.warning {
 background-color: #fcf8e3;
}

.table tbody td.info {
 background-color: #d9edf7;
}

td.big {
 width: 117px;
}

td.small {
}

td.codeLine {
 font-family: "Source Code Pro", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
 white-space: pre;
}

td span.comment {
 color: #888a85;
}

td span.default {
 color: #2e3436;
}

td span.html {
 color: #888a85;
}

td span.keyword {
 color: #2e3436;
 font-weight: bold;
}

pre span.string {
 color: #2e3436;
}

span.success, span.warning, span.danger {
 margin-right: 2px;
 padding-left: 10px;
 padding-right: 10px;
 text-align: center;
}

#classCoverageDistribution, #classComplexity {
 height: 200px;
 width: 475px;
}

#toplink {
 position: fixed;
 left: 5px;
 bottom: 5px;
 outline: 0;
}

svg text {
 font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
 font-size: 11px;
 color: #666;
 fill: #666;
}

.scrollbox {
 height:245px;
 overflow-x:hidden;
 overflow-y:scroll;
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       /*!
  * Bootstrap v4.1.3 (https://getbootstrap.com/)
  * Copyright 2011-2018 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
  */
!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?e(exports,require("jquery"),require("popper.js")):"function"==typeof define&&define.amd?define(["exports","jquery","popper.js"],e):e(t.bootstrap={},t.jQuery,t.Popper)}(this,function(t,e,h){"use strict";function i(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}function s(t,e,n){return e&&i(t.prototype,e),n&&i(t,n),t}function l(r){for(var t=1;t<arguments.length;t++){var o=null!=arguments[t]?arguments[t]:{},e=Object.keys(o);"function"==typeof Object.getOwnPropertySymbols&&(e=e.concat(Object.getOwnPropertySymbols(o).filter(function(t){return Object.getOwnPropertyDescriptor(o,t).enumerable}))),e.forEach(function(t){var e,n,i;e=r,i=o[n=t],n in e?Object.definePr