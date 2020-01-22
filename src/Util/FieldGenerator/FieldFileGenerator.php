<?php


namespace CkcNet\CrudGenerator\Util\FieldGenerator;


class FieldFileGenerator extends FieldGenerator
{
    const TYPE = "file";

    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
        $this->setName($this->getNameFile());
    }

    public function getNameFile()
    {
        return str_replace('_id', '', $this->getName());
    }
}
