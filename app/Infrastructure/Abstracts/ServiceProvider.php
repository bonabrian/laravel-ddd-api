<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Infrastructure\Abstracts;

use Gate;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use ReflectionClass;

abstract class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var string $alias for load translations and views.
     */
    protected $alias;

    /**
     * @var bool set if load commands
     */
    protected $hasCommands = false;

    /**
     * @var bool set if will load factories
     */
    protected $hasFactories = false;

    /**
     * @var bool set if will load migrations
     */
    protected $hasMigrations = false;

    /**
     * @var bool set if will load translations
     */
    protected $hasTranslations = false;

    /**
     * @var bool set if will load policies
     */
    protected $hasPolicies = false;

    /**
     * @var array list of costom artisan commands
     */
    protected $commands = [];

    /**
     * @var array list of model factories to load
     */
    protected $factories = [];

    /**
     * @var array lost of providers to load
     */
    protected $providers = [];

    /**
     * @var array list of policies to load
     */
    protected $policies = [];

    /**
     * Boot required registering of views and translations.
     *
     * @throws \ReflectionException
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerCommands();
        $this->registerFactories();
        $this->registerMigrations();
        $this->registerTranslations();
    }

    /**
     * Register the application's policies
     *
     * @return void
     */
    public function registerPolicies()
    {
        if ($this->hasPolicies) {
            foreach ($this->policies as $key => $value) {
                Gate::policy($key, $value);
            }
        }
    }

    /**
     * Register domain custom artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->hasCommands) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register Model Factories.
     */
    protected function registerFactories()
    {
        if ($this->hasFactories) {
            collect($this->factories)->each(function ($factoryName) {
                (new $factoryName())->define();
            });
        }
    }

    /**
     * Register domain migrations.
     *
     * @throws \ReflectionException
     */
    protected function registerMigrations()
    {
        if ($this->hasMigrations) {
            $this->loadMigrationsFrom($this->domainPath('Database/Migrations'));
        }
    }

    /**
     * Detects the domain base path so resources can be proper loaded on child classes.
     *
     * @param string $append
     * @return string
     * @throws \ReflectionException
     */
    protected function domainPath($append = null)
    {
        $reflection = new ReflectionClass($this);
        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        if (!$append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }

    /**
     * Register domain translations.
     *
     * @throws \ReflectionException
     */
    protected function registerTranslations()
    {
        if ($this->hasTranslations) {
            $this->loadJsonTranslationsFrom($this->domainPath('Resources/Lang'));
        }
    }

    /**
     * Register Domain ServiceProviders.
     */
    public function register()
    {
        collect($this->providers)->each(function ($providerClass) {
            $this->app->register($providerClass);
        });
    }
}
