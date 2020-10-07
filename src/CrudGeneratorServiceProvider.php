<?php

namespace KevinLbr\CrudGenerator;

use KevinLbr\CrudGenerator\Console\Commands\CrudCommand;
use KevinLbr\CrudGenerator\Console\Commands\CrudControllerCommand;
use KevinLbr\CrudGenerator\Console\Commands\CrudLangCommand;
use KevinLbr\CrudGenerator\Console\Commands\CrudModelCommand;
use KevinLbr\CrudGenerator\Console\Commands\CrudRequestCommand;
use KevinLbr\CrudGenerator\Console\Commands\CrudViewCreateCommand;
use KevinLbr\CrudGenerator\Console\Commands\CrudViewEditCommand;
use KevinLbr\CrudGenerator\Console\Commands\CrudViewFormCommand;
use KevinLbr\CrudGenerator\Console\Commands\CrudViewIndexCommand;
use KevinLbr\CrudGenerator\Console\Commands\CrudViewsCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class CrudGeneratorServiceProvider
 * @package KevinLbr\CrudGenerator
 */
class CrudGeneratorServiceProvider extends ServiceProvider
{
    /**
     * @var array $commands
     */
    protected $commands = [
        CrudCommand::class,
        CrudControllerCommand::class,
        CrudModelCommand::class,
        CrudRequestCommand::class,
        CrudViewsCommand::class,
        CrudViewFormCommand::class,
        CrudViewEditCommand::class,
        CrudViewCreateCommand::class,
        CrudViewIndexCommand::class,
        CrudLangCommand::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->loadRoutesFrom(__DIR__.'/routes.php');
//        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'crud-generator');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/crud-generator'),
            __DIR__.'/config/laravel-crud-generator.php' => config_path('laravel-crud-generator.php'),
        ], 'crud-generator');
    }
}
