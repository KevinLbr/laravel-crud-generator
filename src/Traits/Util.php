<?php


namespace KevinLbr\CrudGenerator\Traits;

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
     * Get the default directory view name for the class.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPlurialName($name)
    {
        return strtolower($name) . 's';
    }
}
