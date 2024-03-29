<?php


namespace KevinLbr\CrudGenerator\Util\FieldGenerator;

/**
 * Class FieldDateGenerator
 * @package KevinLbr\CrudGenerator\Util\FieldGenerator
 */
class FieldDateGenerator extends FieldGenerator
{
    const TYPE = "date";

    /**
     * FieldDateGenerator constructor.
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
