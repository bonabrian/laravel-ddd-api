<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Domain\Users\Providers;

use App\Infrastructure\Abstracts\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    protected $alias = 'users';

    protected $hasMigrations = true;

    protected $hasTranslations = true;

    protected $hasFactories = true;

    protected $providers = [
        RouteServiceProvider::class,
        RepositoryServiceProvider::class,
        EventServiceProvider::class,
        BroadcastServiceProvider::class
    ];
}
