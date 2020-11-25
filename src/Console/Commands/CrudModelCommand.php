<?php

namespace KevinLbr\CrudGenerator\Console\Commands;

use KevinLbr\CrudGenerator\Traits\FillablesTrait;
use KevinLbr\CrudGenerator\Traits\Util;
use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

/**
 * Class CrudModelCommand
 * @package KevinLbr\CrudGenerator\Console\Commands
 */
class CrudModelCommand extends GeneratorCommand
{
    use Util;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'kevinlbr:crud-model';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kevinlbr:crud-model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a CRUD model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     * @throws \Exception
     */
    protected function getStub()
    {
        return __DIR__."/../../stubs/models/crud-model.stub";
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
        return $rootNamespace.'\Models';
    }

    /**
     * Replace the table name for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return string
     */
    protected function replaceTable(&$stub, $name)
    {
        $name = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', str_replace($this->getNamespace($name).'\\', '', $name))), '_');

        $table = Str::snake(Str::plural($name));

        $stub = str_replace('DummyTable', $table, $stub);

        return $this;
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

        return $this->replaceNamespace($stub, $name)
            ->replaceWord($stub, $this->getFillables(), 'fillables')
            ->replaceTable($stub, $name)
            ->replaceClass($stub, $name);
    }

    /**
     * @return string
     */
    public function getFillables()
    {
        $fillables = FillablesTrait::getFillables($this->getNameInput());

        $content = '';
        foreach($fillables as $fillable){
            $content .= "'{$fillable}',";
        }

        return $content;
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
