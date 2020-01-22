<?php


namespace CkcNet\CrudGenerator\Util\FieldGenerator;


class FieldDateGenerator extends FieldGenerator
{
    const TYPE = "date";

    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
    }
}
