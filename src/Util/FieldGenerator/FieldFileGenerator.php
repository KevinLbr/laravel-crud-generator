<?php


namespace CkcNet\CrudGenerator\Util\FieldGenerator;

/**
 * Class FieldFileGenerator
 * @package CkcNet\CrudGenerator\Util\FieldGenerator
 */
class FieldFileGenerator extends FieldGenerator
{
    const TYPE = "file";

    /**
     * FieldFileGenerator constructor.
     * @param $column
     * @param $entity
     * @throws \Exception
     */
    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
        $this->setName($this->getNameFile());
    }

    /**
     * @return string|string[]
     */
    public function getNameFile()
    {
        return str_replace('_id', '', $this->getName());
    }
}
