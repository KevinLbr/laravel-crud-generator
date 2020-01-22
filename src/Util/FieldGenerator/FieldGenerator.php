<?php


namespace CkcNet\CrudGenerator\Util\FieldGenerator;


class FieldGenerator
{
    protected $column;
    protected $name;
    protected $type;
    protected $label;
    protected $entity;
    protected $value;
    protected $notNull;

    const DEFAULT_TYPE = 'text';

    /**
     * FieldGenerator constructor.
     *
     * @param $column
     * @param $entity
     * @throws \Exception
     */
    public function __construct($column, $entity)
    {
        $this->setEntity($entity);
        $this->setName($column->getName());
        $this->setColumn($column);
        $this->setLabel($this->getName());
        $this->setNotNull($column->getNotNull());

        $name = $this->getName();
        $this->setValue($entity->$name);
        $this->setType(self::DEFAULT_TYPE);
    }

    /**
     * Set value
     *
     * @param $value
     * @return mixed
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this->value;
    }

    /**
     * Get value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set not null
     *
     * @param $value
     * @return mixed
     */
    public function setNotNull($value)
    {
        $this->notNull = $value;

        return $this->notNull;
    }

    /**
     * Get not null
     *
     * @return mixed
     */
    public function getNotNull()
    {
        return $this->notNull;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return string
     */
    public function setName(string $name): string
    {
        $this->name = $name;

        return $this->name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set entity
     *
     * @param $entity
     * @return string
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this->entity;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return string
     */
    public function setLabel(string $label): string
    {
        $this->label = trans($this->entity->getTable() . '.' .strtolower($label));

        return $this->label;
    }

    /**
     * Get label
     *
     * @return string
     * @throws \Exception
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Get label
     *
     * @return string
     * @throws \Exception
     */
    public function getLabelWithRequired(): string
    {
        return $this->getNotNull() == true ? $this->label . ' *' : $this->label;
    }

    /**
     * Set column
     *
     * @param $column
     * @return mixed
     */
    public function setColumn($column)
    {
        $this->column = $column;

        return $this->column;
    }

    /**
     * Get column
     *
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return string
     */
    public function setType(string $type): string
    {
        $this->type = $type;

        return $this->type;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
