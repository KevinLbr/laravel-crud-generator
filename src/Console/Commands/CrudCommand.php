<?php

namespace KevinLbr\CrudGenerator\Console\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Class CrudCommand
 * @package KevinLbr\CrudGenerator\Console\Commands
 */
class CrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kevinlbr:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CRUD interface: Controller, Model, Request, Views';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = ucfirst($this->argument('name'));

        // test if name parameter is correct to generate
        $generate = 'Yes';
        if(!Schema::hasTable(Str::plural($name))){
            $this->info(Str::plural($name) . 'table not found ! We can\'t generate fillables, and add media function if need it');
            $generate = $this->choice('Continue ?', [true => 'Yes', false => 'No']);
        }

        if($generate == 'No'){
            $this->error('Command is canceled');
            die;
        }

        // Create the CRUD Controller and show output
        Artisan::call('kevinlbr:crud-controller', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Model and show output
        Artisan::call('kevinlbr:crud-model', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Request and show output
        Artisan::call('kevinlbr:crud-request', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD View and show output
        Artisan::call('kevinlbr:crud-views', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Lang and show output
        Artisan::call('kevinlbr:crud-lang', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Routes and show output
        Artisan::call('kevinlbr:crud-routes', ['name' => $name]);
        echo Artisan::output();
    }
}
