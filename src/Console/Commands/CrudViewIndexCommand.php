<?php

namespace KevinLbr\CrudGenerator\Console\Commands;

use Illuminate\Support\Str;
use KevinLbr\CrudGenerator\Traits\Util;
use Illuminate\Console\GeneratorCommand;

/**
 * Class CrudViewIndexCommand
 * @package KevinLbr\CrudGenerator\Console\Commands
 */
class CrudViewIndexCommand extends GeneratorCommand
{
    use Util;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'kevinlbr:crud-view-index';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kevinlbr:crud-view-index {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a templated view';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View index';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/index.stub';
    }

    /**
     * Alias for the fire method.
     *
     * In Laravel 5.5 the fire() method has been renamed to handle().
     * This alias provides support for both Laravel 5.4 and 5.5.
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
     * Determine if the class already exists.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function alreadyExists($name)
    {
        return $this->files->exists($this->getPath($name));
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
        $path_base = '/../resources/views/';
        $path_config = config('crud-generator.paths.views');
        $name = Str::plural(strtolower(str_replace('\\', '/', $name)));

        return $this->laravel['path']. $path_base . $path_config . '/' . $name . '/index.blade.php';
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

        $this->replaceWord($stub, Str::plural(strtolower($name)), "dummy_directory");
        $this->replaceWord($stub, Str::plural(strtolower($name)), "dummy_route");
        $this->replaceWord($stub, strtolower($name), 'item');
        $this->replaceWord($stub, Str::plural(strtolower($name)) , 'items');

        $this->replaceLangWords($name, $stub);

        return $stub;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }
}
