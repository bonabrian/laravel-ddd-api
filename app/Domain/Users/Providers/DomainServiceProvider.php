<?php

namespace App\Domain\Users\Providers;

use App\Domain\Users\Database\Factories\UserFactory;
use App\Infrastructure\Abstracts\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Alias for load translations and views.
     *
     * @var string
     */
    protected $alias = 'users';

    /**
     * Set if will load factories.
     *
     * @var bool
     */
    protected $hasFactories = true;

    /**
     * Set if will load migrations.
     *
     * @var bool
     */
    protected $hasMigrations = true;

    /**
     * Set if will load translations.
     *
     * @var bool
     */
    protected $hasTranslations = true;

    /**
     * List of providers to load.
     *
     * @var array
     */
    protected $providers = [
        RouteServiceProvider::class,
        RepositoryServiceProvider::class,
        EventServiceProvider::class,
        BroadcastServiceProvider::class
    ];

    /**
     * List of model factories load.
     *
     * @var array
     */
    protected $factories = [
        UserFactory::class
    ];
}
