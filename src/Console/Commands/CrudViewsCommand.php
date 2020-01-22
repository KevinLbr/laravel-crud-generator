<?php

namespace CkcNet\CrudGenerator\Console\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;

class CrudViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ckc:crud-views {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CRUD views';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = ucfirst($this->argument('name'));

        // Create the CRUD View and show output
        Artisan::call('ckc:crud-view-form', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD View and show output
        Artisan::call('ckc:crud-view-create', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD View and show output
        Artisan::call('ckc:crud-view-edit', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD View and show output
        Artisan::call('ckc:crud-view-index', ['name' => $name]);
        echo Artisan::output();
    }
}
