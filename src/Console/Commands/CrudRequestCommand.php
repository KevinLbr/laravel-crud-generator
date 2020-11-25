<?php

namespace KevinLbr\CrudGenerator\Console\Commands;

use KevinLbr\CrudGenerator\Traits\FillablesTrait;
use KevinLbr\CrudGenerator\Traits\Util;
use Illuminate\Console\GeneratorCommand;

/**
 * Class CrudRequestCommand
 * @package KevinLbr\CrudGenerator\Console\Commands
 */
class CrudRequestCommand extends GeneratorCommand
{
    use Util;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'kevinlbr:crud-request';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kevinlbr:crud-request {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a CRUD request';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

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
        $format_name = str_replace('\\', '/', $name);

        return $this->laravel['path'].'/'.$format_name.'Request.php';
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
            $content .= "'{$fillable}' => 'required',";
            $content .=  PHP_EOL;
            $content .=  "\t" . "\t" . "\t";
        }

        return $content;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/crud-request.stub';
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
        return $rootNamespace.'\Http\Requests';
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
