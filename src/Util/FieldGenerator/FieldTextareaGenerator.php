<?php


namespace CkcNet\CrudGenerator\Util\FieldGenerator;


class FieldTextareaGenerator extends FieldGenerator
{
    const TYPE = "textarea";

    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
    }
}
