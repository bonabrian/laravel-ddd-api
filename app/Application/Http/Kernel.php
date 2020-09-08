<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Application\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Application\Http\Middleware\ForceAcceptJson::class,
        // \App\Application\Http\Middleware\TrustHosts::class,
        \App\Application\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Application\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Application\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Application\Http\Middleware\SetLocale::class,
        \Illuminate\Http\Middleware\SetCacheHeaders::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Application\Http\Middleware\RedirectIfAuthenticated::class,
        // 'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        // 'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];

    /**
     * The priority-sorted list of middleware.
     * This forces the listed middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \App\Application\Http\Middleware\ForceAcceptJson::class,
        \App\Application\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Auth\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Application\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Application\Http\Middleware\TrustProxies::class,
        \App\Application\Http\Middleware\SetLocale::class,
        \Illuminate\Http\Middleware\SetCacheHeaders::class,
    ];
}
