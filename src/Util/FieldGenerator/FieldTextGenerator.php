<?php


namespace KevinLbr\CrudGenerator\Util\FieldGenerator;

/**
 * Class FieldTextGenerator
 * @package KevinLbr\CrudGenerator\Util\FieldGenerator
 */
class FieldTextGenerator extends FieldGenerator
{
    const TYPE = "text";

    /**
     * FieldTextGenerator constructor.
     * @param $column
     * @param $entity
     * @throws \Exception
     */
    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $method = "get{$this->getName()}Column";

        return method_exists($this->entity, $method)
            ? $this->entity->$method()
            : $this->value;
    }
}
