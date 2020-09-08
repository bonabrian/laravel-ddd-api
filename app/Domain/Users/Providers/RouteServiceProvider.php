<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Domain\Users\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to users domain route.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Domain\Users\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapApiRoutes($router);
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace,
            'middleware' => 'api'
        ], function (Router $router) {
            // Guest route
            $router->group([
                'middleware' => 'guest'
            ], function () use ($router) {
                $router->get('/', function () {
                    return 'Hello world';
                });
            });
        });
    }
}
