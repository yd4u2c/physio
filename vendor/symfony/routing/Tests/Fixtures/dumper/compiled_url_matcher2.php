<?php

use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherTrait;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class ProjectUrlMatcher extends Symfony\Component\Routing\Tests\Fixtures\RedirectableUrlMatcher
{
    use PhpMatcherTrait;

    public function __construct(RequestContext $context)
    {
        $this->context = $context;
        $this->regexpList = [
            0 => '{^(?'
                    .'|/(en|fr)/(?'
                        .'|admin/post(?'
                            .'|(*:32)'
                            .'|/(?'
                                .'|new(*:46)'
                                .'|(\\d+)(*:58)'
                                .'|(\\d+)/edit(*:75)'
                                .'|(\\d+)/delete(*:94)'
                            .')'
                        .')'
                        .'|blog(?'
                            .'|(*:110)'
                            .'|/(?'
                                .'|rss\\.xml(*:130)'
                                .'|p(?'
                                    .'|age/([^/]++)(*:154)'
                                    .'|osts/([^/]++)(*:175)'
                                .')'
                                .'|comments/(\\d+)/new(*:202)'
                                .'|search(*:216)'
                            .')'
                        .')'
                        .'|log(?'
                            .'|in(*:234)'
                            .'|out(*:245)'
                        .')'
                    .')'
                    .'|/(en|fr)?(*:264)'
                .')/?$}sD',
        ];
        $this->dynamicRoutes = [
            32 => [[['_route' => 'a', '_locale' => 'en'], ['_locale'], null, null, true, false, null]],
            46 => [[['_route' => 'b', '_locale' => 'en'], ['_locale'], null, null, false, false, null]],
            58 => [[['_route' => 'c', '_locale' => 'en'], ['_locale', 'id'], null, null, false, true, null]],
            75 => [[['_route' => 'd', '_locale' => 'en'], ['_locale', 'id'], null, null, false, false, null]],
            94 => [[['_route' => 'e', '_locale' => 'en'], ['_locale', 'id'], null, null, false, false, null]],
            110 => [[['_route' => 'f', '_locale' => 'en'], ['_locale'], null, null, true, false, null]],
            130 => [[['_route' => 'g', '_locale' => 'en'], ['_locale'], null, null, false, false, null]],
            154 => [[['_route' => 'h', '_locale' => 'en'], ['_locale', 'page'], null, null, false, true, null]],
            175 => [[['_route' => 'i', '_locale' => 'en'], ['_locale', 'page'], null, null, false, true, null]],
            202 => [[['_route' => 'j', '_locale' => 'en'], ['_locale', 'id'], null, null, false, false, null]],
            216 => [[['_route' => 'k', '_locale' => 'en'], ['_locale'], null, null, false, false, null]],
            234 => [[['_route' => 'l', '_locale' => 'en'], ['_locale'], null, null, false, false, null]],
            245 => [[['_route' => 'm', '_locale' => 'en'], ['_locale'], null, null, false, false, null]],
            264 => [[['_route' => 'n', '_locale' => 'en'], ['_locale'], null, null, false, true, null]],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

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
        $this->regexpList = [
            0 => '{^(?'
                    .'|/abc([^/]++)/(?'
                        .'|1(?'
                            .'|(*:27)'
                            .'|0(?'
                                .'|(*:38)'
                                .'|0(*:46)'
                            .')'
                        .')'
                        .'|2(?'
                            .'|(*:59)'
                            .'|0(?'
                                .'|(*:70)'
                                .'|0(*:78)'
                            .')'
                        .')'
                    .')'
                .')/?$}sD',
        ];
        $this->dynamicRoutes = [
            27 => [[['_route' => 'r1'], ['foo'], null, null, false, false, null]],
            38 => [[['_route' => 'r10'], ['foo'], null, null, false, false, null]],
            46 => [[['_route' => 'r100'], ['foo'], null, null, false, false, null]],
            59 => [[['_route' => 'r2'], ['foo'], null, null, false, false, null]],
            70 => [[['_route' => 'r20'], ['foo'], null, null, false, false, null]],
            78 => [[['_route' => 'r200'], ['foo'], null, null, false, false, null]],
        ];
    }
}
                                                                                                      