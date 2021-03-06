<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Generator;

/**
 * ConfigurableRequirementsInterface must be implemented by URL generators that
 * can be configured whether an exception should be generated when the parameters
 * do not match the requirements. It is also possible to disable the requirements
 * check for URL generation completely.
 *
 * The possible configurations and use-cases:
 * - setStrictRequirements(true): Throw an exception for mismatching requirements. This
 *   is mostly useful in development environment.
 * - setStrictRequirements(false): Don't throw an exception but return null as URL for
 *   mismatching requirements and log the problem. Useful when you cannot control all
 *   params because they come from third party libs but don't want to have a 404 in
 *   production environment. It should log the mismatch so one can review it.
 * - setStrictRequirements(null): Return the URL with the given parameters without
 *   checking the requirements at all. When generating a URL you should either trust
 *   your params or you validated them beforehand because otherwise it would break your
 *   link anyway. So in production environment you should know that params always pass
 *   the requirements. Thus this option allows to disable the check on URL generation for
 *   performance reasons (saving a preg_match for each requirement every time a URL is
 *   generated).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 */
interface ConfigurableRequirementsInterface
{
    /**
     * Enables or disables the exception on incorrect parameters.
     * Passing null will deactivate the requirements check completely.
     *
     * @param bool|null $enabled
     */
    public function setStrictRequirements($enabled);

    /**
     * Returns whether to throw an exception on incorrect parameters.
     * Null means the requirements check is deactivated completely.
     *
     * @return bool|null
     */
    public function isStrictRequirements();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Generator;

use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

/**
 * UrlGenerator can generate a URL or a path for any route in the RouteCollection
 * based on the passed parameters.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 */
class UrlGenerator implements UrlGeneratorInterface, ConfigurableRequirementsInterface
{
    protected $routes;
    protected $context;

    /**
     * @var bool|null
     */
    protected $strictRequirements = true;

    protected $logger;

    private $defaultLocale;

    /**
     * This array defines the characters (besides alphanumeric ones) that will not be percent-encoded in the path segment of the generated URL.
     *
     * PHP's rawurlencode() encodes all chars except "a-zA-Z0-9-._~" according to RFC 3986. But we want to allow some chars
     * to be used in their literal form (reasons below). Other chars inside the path must of course be encoded, e.g.
     * "?" and "#" (would be interpreted wrongly as query and fragment identi