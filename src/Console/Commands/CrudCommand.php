<?php

namespace CkcNet\CrudGenerator\Console\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ckc:crud {name}';

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

        $generate = 'Yes';
        if(!Schema::hasTable($name . 's')){
            $this->info($name . 's table not found ! We can\'t generate fillable, and add media function if need it');
            $generate = $this->choice('Continue ?', [true => 'Yes', false => 'No']);
        }

        if($generate == 'No'){
            $this->error('Command is canceled');
            die;
        }

        // Create the CRUD Controller and show output
        Artisan::call('ckc:crud-controller', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Model and show output
        Artisan::call('ckc:crud-model', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Request and show output
        Artisan::call('ckc:crud-request', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD View and show output
        Artisan::call('ckc:crud-views', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Lang and show output
        Artisan::call('ckc:crud-lang', ['name' => $name]);
        echo Artisan::output();
    }
}
