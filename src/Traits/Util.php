<?php


namespace KevinLbr\CrudGenerator\Traits;

use Illuminate\Support\Str;

/**
 * Trait Util
 * @package KevinLbr\CrudGenerator\Traits
 */
trait Util
{
    /**
     * Replace word for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @param string $search
     * @return string
     */
    protected function replaceWord(&$stub, $name, $search)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        $stub = str_replace($search, $class, $stub);

        return $this;
    }

    /**
     * @param $name
     * @return string
     */
    public function getLangPath($name)
    {
        return config('crud-generator.paths.lang') . '/' . Str::plural(strtolower(str_replace('\\', '/', $name)));
    }

    /**
     * @param string $name
     * @param $stub
     */
    public function replaceLangWords(string $name, &$stub)
    {
        $path_trans = $this->getLangPath($name);
        $this->replaceWord($stub, $path_trans . '.plurial_name', 'trans_path_plurial');
        $this->replaceWord($stub, $path_trans . '.gender', 'trans_path_gender');
        $this->replaceWord($stub, $path_trans . '.name', 'trans_path_name');
    }
}
