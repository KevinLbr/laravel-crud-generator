<?php

namespace KevinLbr\CrudGenerator\Console\Commands;

use KevinLbr\CrudGenerator\Traits\FillableCommande;
use KevinLbr\CrudGenerator\Traits\Util;
use Illuminate\Console\GeneratorCommand;

/**
 * Class CrudLangCommand
 * @package KevinLbr\CrudGenerator\Console\Commands
 */
class CrudLangCommand extends GeneratorCommand
{
    use Util;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'kevinlbr:crud-lang';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kevinlbr:crud-lang {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a lang file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Lang';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/lang.stub';
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
        return $this->laravel['path'].'/../resources/lang/fr/'.strtolower(str_replace('\\', '/', $name)).'s.php';
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

        $this->replaceWord($stub, $this->getFillables(), 'fillables');

        return $stub;
    }

    /**
     * @return string
     */
    public function getFillables()
    {
        $fillables = FillableCommande::getFillable($this->getNameInput());

        $content = '';
        foreach($fillables as $fillable){
            $content .= "'{$fillable}' => '{$fillable}',";
            $content .=  PHP_EOL;
            $content .=  "\t" . "\t";
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
