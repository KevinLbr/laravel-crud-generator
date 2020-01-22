<?php


namespace CkcNet\CrudGenerator\Util\FieldGenerator;


class FieldTextGenerator extends FieldGenerator
{
    const TYPE = "text";

    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
    }
}
