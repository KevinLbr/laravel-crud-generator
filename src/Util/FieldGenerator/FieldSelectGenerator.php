<?php

namespace KevinLbr\CrudGenerator\Util\FieldGenerator;

use Illuminate\Support\Str;

/**
 * Class FieldSelectGenerator
 * @package KevinLbr\CrudGenerator\Util\FieldGenerator
 */
class FieldSelectGenerator extends FieldGenerator
{
    const TYPE = "select";

    /**
     * @var boolean $is_foreign_key
     */
    protected $is_foreign_key;

    /**
     * @var array $items
     */
    protected $items;

    /**
     * FieldSelectGenerator constructor.
     * @param $column
     * @param $entity
     * @param bool $isForiegn
     * @throws \Exception
     */
    public function __construct($column, $entity, bool $isForiegn)
    {
        parent::__construct($column, $entity);

        $this->setType(self::TYPE);
        $this->setForeignKey($isForiegn);

        $this->setItems($this->isForeignKey() ? $this->getItemsOfRelation() : $this->getOptions());
    }

    /**
     * Set foreign key
     *
     * @param string $value
     * @return bool
     */
    public function setForeignKey(string $value): bool
    {
        $this->is_foreign_key = $value;

        return $this->is_foreign_key;
    }

    /**
     * Check if is foreign key with name
     *
     * @return bool
     */
    public function isForeignKey(): bool
    {
        return $this->is_foreign_key;
    }

    /**
     * Get items of relation
     *
     * @return array
     * @throws \Exception
     */
    public function setItems($items): array
    {
        $this->items = $items;

        return $this->items;
    }

    /**
     * Get items
     *
     * @return  array
     * @throws \Exception
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Get relation function
     *
     * @return string
     * @throws \Exception
     */
    public function getRelationFunction(): string
    {
        if(!$this->isForeignKey()){
            $value = $this->isForeignKey() == true ? 'true' : 'false';
            throw new \Exception("Column is not foreign key ({$this->getName()}, {$value})");
        }

        return explode('_id', $this->getName())[0];
    }

    /**
     * Get relation class
     *
     * @return string
     * @throws \Exception
     */
    public function getRelationClass(): string
    {
        if(!$this->isForeignKey()){
            $value = $this->isForeignKey() == true ? 'true' : 'false';
            throw new \Exception("Column is not foreign key ({$this->getName()}, {$value})");
        }

        return ucFirst(explode('_id', $this->getName())[0]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getOptions()
    {
        $methodsOptions = "getOptions" . ucFirst(Str::camel($this->getName())) . "s";

        if(method_exists($this->entity, $methodsOptions)) {
            $items = $this->entity->$methodsOptions();
        } else {
            throw new \Exception("Aucune fonction {$methodsOptions}() existe, donc Crud Generator ne peut pas generer de liste");
        }

        if(!$this->getNotNull()){
            $data[null] = 'Aucun élement selectionné';
        }

        foreach($items as $key => $item){
            $data[$key] = $item;
        }

        return $data;
    }

    /**
     * Get all items of relation
     *
     * @return array
     * @throws \Exception
     */
    public function getItemsOfRelation(): array
    {
        $class = "\App\Models\\" . $this->getRelationClass();
        $methodsList = "get" . ucFirst(Str::camel($this->getRelationFunction())) . "sList";

        if(method_exists($this->entity, $methodsList)) {
            $items = $this->entity->$methodsList();
        } elseif(class_exists($class)){
            $items = $class::all();
        } else {
            throw new \Exception("Le nom de la relation n'est pas identique au nom de la classe qu'elle renvoi,
            et aucune fonction {$methodsList}() existe, donc Crud Generator ne peut pas generer de liste");
        }

        $data = [];
        if(!$this->getNotNull()){
            $data[null] = 'Aucun élement selectionné';
        }

        foreach($items as $item){
            $data[$item->id] = $item->name != null ? $item->name : $item->id;
        }

        return $data;
    }

    /**
     * @return object
     * @throws \Exception
     */
    public function getItemSelect()
    {
        if($this->isForeignKey()){
            $relation = $this->getRelationFunction();

            return $this->entity->$relation != null
                ? $this->entity->$relation->find($this->getValue())
                : (object)['name' => "Aucun élement sélectionné"];
        } else {
            foreach($this->getOptions() as $key => $option){
                if($key == $this->getValue()){
                    return (object)['name' => $option];
                }
            }

            // TODO throw
            return (object)['name' => '--'];
        }
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getValue()
    {
        $options = $this->getItems();

        foreach($options as $key => $option){
            if($key == $this->value){
                return $option;
            }
        }
    }
}
