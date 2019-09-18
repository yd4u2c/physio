<?php

namespace InfyOm\Generator\Generators\Vuejs;

use Illuminate\Support\Str;
use InfyOm\Generator\Common\CommandData;
use InfyOm\Generator\Generators\BaseGenerator;

class RoutesGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $pathApi;

    /** @var string */
    private $routeContents;

    /** @var string */
    private $apiRouteContents;

    /** @var string */
    private $routesTemplate;

    /** @var string */
    private $apiRoutesTemplate;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->pathApi = $commandData->config->pathApiRoutes;
        $this->path = $commandData->config->pathRoutes;

        $this->routeContents = file_get_contents($this->path);

        if (!file_exists($this->pathApi)) {
            file_put_contents($this->pathApi, get_template('vuejs.routes.api_routes', 'laravel-generator'));
        }

        $this->apiRouteContents = file_get_contents($this->pathApi);

        $routesTemplate = get_template('vuejs.routes.routes', 'laravel-generator');
        $apiRoutesTemplate = get_template('vuejs.routes.api_routes_base', 'laravel-generator');
        $this->routesTemplate