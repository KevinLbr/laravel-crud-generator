<?php

namespace KevinLbr\CrudGenerator\Util\FieldGenerator;

/**
 * Class FieldRadioGenerator
 * @package KevinLbr\CrudGenerator\Util\FieldGenerator
 */
class FieldRadioGenerator extends FieldGenerator
{
    const TYPE = "radio";

    /**
     * FieldRadioGenerator constructor.
     * @param $column
     * @param $entity
     * @throws \Exception
     */
    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
    }

//    TODO
//    public function getValue()
//    {
//        return ;
//    }
}
