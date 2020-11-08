<?php

namespace KevinLbr\CrudGenerator\Util\FieldGenerator;

use Illuminate\Support\Str;

/**
 * Class FieldNumberGenerator
 * @package KevinLbr\CrudGenerator\Util\FieldGenerator
 */
class FieldNumberGenerator extends FieldGenerator
{
    const TYPE = "number";

    /**
     * @var boolean $hasOptions
     */
    protected $hasOptions;

    /**
     * @var array $options
     */
    protected $options;

    /**
     * FieldNumberGenerator constructor.
     * @param $column
     * @param $entity
     * @throws \Exception
     */
    public function __construct($column, $entity)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
        $this->setHasOptions($this->checkIfHasOptions());
        $this->setOptions($this->getOptionsEntity());
    }

    /**
     * @return boolean
     */
    public function hasOptions(): bool
    {
        return $this->hasOptions;
    }

    /**
     * @param bool $hasOptions
     * @return boolean
     */
    public function setHasOptions(bool $hasOptions): bool
    {
        $this->hasOptions = $hasOptions;

        return $this->hasOptions;
    }

    /**
     * @return bool
     */
    public function checkIfHasOptions(): bool
    {
        return method_exists($this->entity, 'getOptions' . ucFirst(Str::camel($this->getName())))
            ? true
            : false;
    }

    /**
     * @return array
     */
    public function getOptionsEntity(): array
    {
        if (!$this->hasOptions()) {
            return [];
        }

        $methodGetOptions = "getOptions" . ucFirst(Str::camel($this->getName()));

        return $this->entity->$methodGetOptions();
    }

    /**
     * @param $options
     * @return array
     */
    public function setOptions(array $options): array
    {
        $this->options = $options;

        return $options;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return mixed|null
     */
    public function getOptionSelected()
    {
        return array_key_exists($this->getValue(), $this->getOptions())
            ? $this->getOptions()[$this->getValue()]
            : $this->getValue();
    }
}
