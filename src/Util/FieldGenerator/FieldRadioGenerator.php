<?php


namespace CkcNet\CrudGenerator\Util\FieldGenerator;


class FieldRadioGenerator extends FieldGenerator
{
    const TYPE = "radio";

    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
    }
}
