<?php


namespace CkcNet\CrudGenerator\Util\FieldGenerator;

/**
 * Class FieldTextareaGenerator
 * @package CkcNet\CrudGenerator\Util\FieldGenerator
 */
class FieldTextareaGenerator extends FieldGenerator
{
    const TYPE = "textarea";

    /**
     * FieldTextareaGenerator constructor.
     * @param $column
     * @param $entity
     * @throws \Exception
     */
    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
    }
}
