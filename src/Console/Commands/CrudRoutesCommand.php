<?php

namespace KevinLbr\CrudGenerator\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use KevinLbr\CrudGenerator\Traits\Util;

/**
 * Class CrudRoutesCommand
 * @package KevinLbr\CrudGenerator\Console\Commands
 */
class CrudRoutesCommand extends GeneratorCommand
{
    use Util;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kevinlbr:crud-routes {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CRUD routes';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route edit';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->fire();
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function fire()
    {
        $name = $this->getNameInput();

        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');
    }


    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        return $this->laravel['path'].'/../routes/admin/'. $name . '.php';
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $this->replaceWord($stub, $this->getPlurialName($name), "dummy_name");
        $this->replaceWord($stub, 'Admin\\' . ucFirst(strtolower($name)) . 'sController', "dummy_controller");

        return $stub;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/routes.stub';
    }
}
