<?php

namespace CkcNet\CrudGenerator;

use CkcNet\CrudGenerator\Console\Commands\CrudCommand;
use CkcNet\CrudGenerator\Console\Commands\CrudControllerCommand;
use CkcNet\CrudGenerator\Console\Commands\CrudLangCommand;
use CkcNet\CrudGenerator\Console\Commands\CrudModelCommand;
use CkcNet\CrudGenerator\Console\Commands\CrudRequestCommand;
use CkcNet\CrudGenerator\Console\Commands\CrudViewCreateCommand;
use CkcNet\CrudGenerator\Console\Commands\CrudViewEditCommand;
use CkcNet\CrudGenerator\Console\Commands\CrudViewFormCommand;
use CkcNet\CrudGenerator\Console\Commands\CrudViewIndexCommand;
use CkcNet\CrudGenerator\Console\Commands\CrudViewsCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class CrudGeneratorServiceProvider
 * @package CkcNet\CrudGenerator
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
        ], 'crud-generator');
    }
}
