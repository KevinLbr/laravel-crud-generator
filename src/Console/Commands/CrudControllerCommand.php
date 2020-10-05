<?php

namespace CkcNet\CrudGenerator\Console\Commands;

use CkcNet\CrudGenerator\Traits\FillableCommande;
use CkcNet\CrudGenerator\Traits\Util;
use Illuminate\Console\GeneratorCommand;

/**
 * Class CrudControllerCommand
 * @package CkcNet\CrudGenerator\Console\Commands
 */
class CrudControllerCommand extends GeneratorCommand
{
    use Util;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ckc:crud-controller';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ckc:crud-controller {name}';

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
        $media = FillableCommande::haveMediaColumn($this->getNameInput())
            ? 'media'
            : '';

        $position = FillableCommande::havePositionColumn($this->getNameInput())
            ? 'position'
            : '';

        return __DIR__."/../../stubs/controllers/crud-{$media}{$position}controller.stub";
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
            ->replaceWord($stub, $this->getPlurialName($name), 'dummy_directory')
            ->replaceWord($stub, strtolower($name) . 's', 'dummy_route')
            ->replaceWord($stub, strtolower($name), 'item')
            ->replaceWord($stub, $this->getPlurialName($name) , 'items')
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
