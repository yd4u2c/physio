<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/(a)(*:11)'
            .')/?$}sD',
        11 => '{^(?'
                .'|/(.)(*:22)'
            .')/?$}sDu',
        22 => '{^(?'
                .'|/(.)(*:33)'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        11 => [[['_route' => 'a'], ['a'], null, null, false, true, null]],
        22 => [[['_route' => 'b'], ['a'], null, null, false, true, null]],
        33 => [
            [['_route' => 'c'], ['a'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherTrait;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class ProjectUrlMatcher extends Symfony\Component\Routing\Matcher\UrlMatcher
{
    use PhpMatcherTrait;

    public function __construct(RequestContext $context)
    {
        $this->context = $context;
        $this->matchHost = true;
        $this->staticRoutes = [
            '/test/baz' => [[['_route' => 'baz'], null, null, null, false, false, null]],
            '/test/baz.html' => [[['_route' => 'baz2'], null, null, null, false, false, null]],
            '/test/baz3' => [[['_route' => 'baz3'], null, null, null, true, false, null]],
            '/foofoo' => [[['_route' => 'foofoo', 'def' => 'test'], null, null, null, false, false, null]],
            '/spa ce' => [[['_route' => 'space'], null, null, null, false, false, null]],
            '/multi/new' => [[['_route' => 'overridden2'], null, null, null, false, false, null]],
            '/multi/hey' => [[['_route' => 'hey'], null, null, null, true, false, null]],
            '/ababa' => [[['_route' => 'ababa'], null, null, null, false, false, null]],
            '/route1' => [[['_route' => 'route1'], 'a.example.com', null, null, false, false, null]],
            '/c2/route2' => [[['_route' => 'route2'], 'a.example.com', null, null, false, false, null]],
            '/route4' => [[['_route' => 'route4'], 'a.example.com', null, null, false, false, null]],
  