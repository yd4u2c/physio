<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/defaults", locale="g_locale", format="g_format")
 */
class GlobalDefaultsClass
{
    /**
     * @Route("/specific-locale", name="specific_locale", locale="s_locale")
     */
    public function locale()
    {
    }

    /**
     * @Route("/specific-format", name="specific_format", format="s_format")
     */
    public function format()
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         INDX( 	 �Ƭ             (   (  �       ��                  �2     � l     �2     `�qk� @�����\���<�`�qk�p      k               i m p o r t _ c o n t r o l l e r . x m l     �2     � l     �2     ]~qk� @����?����<�]~qk�X       U                i m p o r t _ c o n t r o l l e r . y m l     �2     � z     �2     ]~qk� @�����"���<�]~qk��      �               i m p o r t _ o v e r r i d e _ d e f a u l t s . x m l       �2     � z     �2     '�qk� @��������< '�qk��       �                i m p o r t _ o v e r r i d e _ d e f a u l t s . y m l       �2     � n     �2     qBqk� @��������<�qBqk��      �               i m p o r t _ _ c o n t r o l l e r . x m l   �2     � n     �2     Ԥqk� @����P����<�Ԥqk�h       h                i m p o r t _ _ c o n t r o l l e r . y m l   �2     � l     �2     Ԥqk� @�����I���<�Ԥqk��      �               o v e r r i d e _ d e f a u l t s . x m l     �2     � l     �2     (qk  @����;����<�(qk��       z                o v e r r i d e _ d e f a u l t s . y m l     �2     h X     �2     �iqk� @����;����<��iqk�                     r o u t i n g . x m l �2     h X     �2     ��qk� @����f���<���qk��       �                r o u t i n g . y m l                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    true, // $matchHost
    [ // $staticRoutes
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
        '/c2/route3' => [[['_route' => 'route3'], 'b.example.com', null, null, false, false, null]],
        '/route5' => [[['_route' => 'route5'], 'c.example.com', null, null, false, false, null]],
        '/route6' => [[['_route' => 'route6'], null, null, null, false, false, null]],
        '/route11' => [[['_route' => 'route11'], '#^(?P<var1>[^\\.]++)\\.example\\.com$#sDi', null, null, false, false, null]],
        '/route12' => [[['_route' => 'route12', 'var1' => 'val'], '#^(?P<var1>[^\\.]++)\\.example\\.com$#sDi', null, null, false, false, null]],
        '/route17' => [[['_route' => 'route17'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
            .'|(?:(?:[^./]*+\\.)++)(?'
                .'|/foo/(baz|symfony)(*:47)'
                .'|/bar(?'
                    .'|/([^/]++)(*:70)'
                    .'|head/([^/]++)(*:90)'
                .')'
                .'|/test/([^/]++)(?'
                    .'|(*:115)'
                .')'
                .'|/([\']+)(*:131)'
                .'|/a/(?'
                    .'|b\'b/([^/]++)(?'
                        .'|(*:160)'
                        .'|(*:168)'
                    .')'
                    .'|(.*)(*:181)'
                    .'|b\'b/([^/]++)(?'
                        .'|(*:204)'
                        .'|(*:212)'
                    .')'
                .')'
                .'|/multi/hello(?:/([^/]++))?(*:248)'
                .'|/([^/]++)/b/([^/]++)(?'
                    .'|(*:279)'
                    .'|(*:287)'
                .')'
                .'|/aba/([^/]++)(*:309)'
            .')|(?i:([^\\.]++)\\.example\\.com)\\.(?'
                .'|/route1(?'
                    .'|3/([^/]++)(*:371)'
                    .'|4/([^/]++)(*:389)'
                .')'
            .')|(?i:c\\.example\\.com)\\.(?'
                .'|/route15/([^/]++)(*:441)'
            .')|(?:(?:[^./]*+\\.)++)(?'
                .'|/route16/([^/]++)(*:489)'
                .'|/a/(?'
                    .'|a\\.\\.\\.(*:510)'
                    .'|b/(?'
                        .'|([^/]++)(*:531)'
                        .'|c/([^/]++)(*:549)'
                    .')'
                .')'
            .')'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        47 => [[['_route' => 'foo', 'def' => 'test'], ['bar'], null, null, false, true, null]],
        70 => [[['_route' => 'bar'], ['foo'], ['GET' => 0, 'HEAD' => 1], null, false, true, null]],
        90 => [[['_route' => 'barhead'], ['foo'], ['GET' => 0], null, false, true, null]],
        115 => [
            [['_route' => 'baz4'], ['foo'], null, null, true, true, null],
            [['_route' => 'baz5'], ['foo'], ['POST' => 0], null, true, true, null],
            [['_route' => 'baz.baz6'], ['foo'], ['PUT' => 0], null, true, true, null],
        ],
        131 => [[['_route' => 'quoter'], ['quoter'], null, null, false, true, null]],
        160 => [[['_route' => 'foo1'], ['foo'], ['PUT' => 0], null, false, true, null]],
        168 => [[['_route' => 'bar1'], ['bar'], null, null, false, true, null]],
        181 => [[['_route' => 'overridden'], ['var'], null, null, false, true, null]],
        204 => [[['_route' => 'foo2'], ['foo1'], null, null, false, true, null]],
        212 => [[['_route' => 'bar2'], ['bar1'], null, null, false, true, null]],
        248 => [[['_route' => 'helloWorld', 'who' => 'World!'], ['who'], null, null, false, true, null]],
        279 => [[['_route' => 'foo3'], ['_locale', 'foo'], null, null, false, true, null]],
        287 => [[['_route' => 'bar3'], ['_locale', 'bar'], null, null, false, true, null]],
        309 => [[['_route' => 'foo4'], ['foo'], null, null, false, true, null]],
        371 => [[['_route' => 'route13'], ['var1', 'name'], null, null, false, true, null]],
        389 => [[['_route' => 'route14', 'var1' => 'val'], ['var1', 'name'], null, null, false, true, null]],
        441 => [[['_route' => 'route15'], ['name'], null, null, false, true, null]],
        489 => [[['_route' => 'route16', 'var1' => 'val'], ['name'], null, null, false, true, null]],
        510 => [[['_route' => 'a'], [], null, null, false, false, null]],
        531 => [[['_route' => 'b'], ['var'], null, null, false, true, null]],
        549 => [
            [['_route' => 'c'], ['var'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

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
                .'|/c(?'
                    .'|f(?'
                        .'|cd20/([^/]++)/([^/]++)/([^/]++)/cfcd20(*:54)'
                        .'|e(?'
                            .'|cdb/([^/]++)/([^/]++)/([^/]++)/cfecdb(*:102)'
                            .'|e39/([^/]++)/([^/]++)/([^/]++)/cfee39(*:147)'
                        .')'
                        .'|a086/([^/]++)/([^/]++)/([^/]++)/cfa086(*:194)'
                        .'|004f/([^/]++)/([^/]++)/([^/]++)/cf004f(*:240)'
                    .')'
                    .'|4(?'
                        .'|ca42/([^/]++)/([^/]++)/([^/]++)/c4ca42(*:291)'
                        .'|5147/([^/]++)/([^/]++)/([^/]++)/c45147(*:337)'
                        .'|1000/([^/]++)/([^/]++)/([^/]++)/c41000(*:383)'
                    .')'
                    .'|8(?'
                        .'|1e72/([^/]++)/([^/]++)/([^/]++)/c81e72(*:434)'
                        .'|ffe9/([^/]++)/([^/]++)/([^/]++)/c8ffe9(*:480)'
                        .'|6a7e/([^/]++)/([^/]++)/([^/]++)/c86a7e(*:526)'
                    .')'
                    .'|9(?'
                        .'|f0f8/([^/]++)/([^/]++)/([^/]++)/c9f0f8(*:577)'
                        .'|e107/([^/]++)/([^/]++)/([^/]++)/c9e107(*:623)'
                    .')'
                    .'|2(?'
                        .'|0(?'
                            .'|ad4/([^/]++)/([^/]++)/([^/]++)/c20ad4(*:677)'
                            .'|3d8/([^/]++)/([^/]++)/([^/]++)/c203d8(*:722)'
                        .')'
                        .'|4cd7/([^/]++)/([^/]++)/([^/]++)/c24cd7(*:769)'
                    .')'
                    .'|5(?'
                        .'|1ce4/([^/]++)/([^/]++)/([^/]++)/c51ce4(*:820)'
                        .'|2f1b/([^/]++)/([^/]++)/([^/]++)/c52f1b(*:866)'
                        .'|ff25/([^/]++)/([^/]++)/([^/]++)/c5ff25(*:912)'
                    .')'
                    .'|7(?'
                        .'|4d97/([^/]++)/([^/]++)/([^/]++)/c74d97(*:963)'
                        .'|e124/([^/]++)/([^/]++)/([^/]++)/c7e124(*:1009)'
                    .')'
                    .'|16a53/([^/]++)/([^/]++)/([^/]++)/c16a53(*:1058)'
                    .'|0(?'
                        .'|c7c7/([^/]++)/([^/]++)/([^/]++)/c0c7c7(*:1109)'
                        .'|e190/([^/]++)/([^/]++)/([^/]++)/c0e190(*:1156)'
                        .'|42f4/([^/]++)/([^/]++)/([^/]++)/c042f4(*:1203)'
                        .'|58f5/([^/]++)/