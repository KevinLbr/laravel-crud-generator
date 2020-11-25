<?php

namespace KevinLbr\CrudGenerator\Console\Commands;

use Illuminate\Support\Str;
use KevinLbr\CrudGenerator\Traits\Util;
use Illuminate\Console\GeneratorCommand;

/**
 * Class CrudControllerCommand
 * @package KevinLbr\CrudGenerator\Console\Commands
 */
class CrudControllerCommand extends GeneratorCommand
{
    use Util;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'kevinlbr:crud-controller';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kevinlbr:crud-controller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a CRUD controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace($this->laravel->getNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'Controller.php';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return __DIR__."/../../stubs/controllers/crud-controller.stub";
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers\Admin';
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceWord($stub, Str::plural(strtolower($name)), 'dummy_directory')
            ->replaceWord($stub, strtolower(Str::plural($name)), 'dummy_route')
            ->replaceWord($stub, strtolower($name), 'item')
            ->replaceWord($stub, Str::plural(strtolower($name)) , 'items')
            ->replaceClass($stub, $name);
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
