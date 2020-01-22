<?php

namespace CkcNet\CrudGenerator\Console\Commands;

use CkcNet\CrudGenerator\Traits\FillableCommande;
use CkcNet\CrudGenerator\Traits\Util;
use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class CrudModelCommand extends GeneratorCommand
{
    use Util;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ckc:crud-model';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ckc:crud-model {name}';

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
     */
    protected function getStub()
    {
        $media = FillableCommande::haveMediaColumn($this->getNameInput()) ? 'media' : '';

        return __DIR__."/../../stubs/models/crud-{$media}model.stub";
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
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceWord($stub, $this->getFillables(), 'fillables')
            ->replaceTable($stub, $name)
            ->replaceClass($stub, $name);
    }

    public function getFillables()
    {
        $fillables = FillableCommande::getFillable($this->getNameInput());

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
