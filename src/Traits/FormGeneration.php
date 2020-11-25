<?php


namespace KevinLbr\CrudGenerator\Traits;


use Illuminate\Database\Eloquent\Model;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldDateGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldFileGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldNumberGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldRadioGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldSelectGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldTextareaGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldTextGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Trait which generate form with columns
 *
 * Trait FormGeneration
 * @package App\Traits
 */
trait FormGeneration
{
    /**
     * @param array $columns
     * @return mixed
     */
    static function getColumnsModel(array $columns = [])
    {
        $class = __CLASS__;
        $item = new $class();

        return $item->generateFields($columns);
    }

    /**
     * Generate fields by default, with columns table
     *
     * @param array $columns
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function generateFields(array $columns = [])
    {
        if ($columns == []) {
            $columns = method_exists($this, "getCrudColumns")
                ? $this->getCrudColumns()
                : $this->getFillable();
        }

        $data = [];
        foreach ($columns as $column) {
            // fix enum type error
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $columnBDD = DB::connection()->getDoctrineColumn($this->getTable(), $column);
            $data[] = $this->getFieldGeneratorType($columnBDD, $this);
        }

        return collect($data);
    }

    /**
     * Generate field
     *
     * @param string $column
     * @return FieldGenerator
     * @throws \Exception
     */
    public function generateField(string $column)
    {
        // fix enum type error
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $columnBDD = DB::connection()->getDoctrineColumn($this->getTable(), $column);
        return $this->getFieldGeneratorType($columnBDD, $this);
    }

    /**
     * Convert column type to form type with name correspond to view name of input type
     *
     * ex : integer => number => /fields/number.blade.php exist
     *
     * @param string $column
     * @param Model $entity
     * @return FieldGenerator
     * @throws \Exception
     */
    public function getFieldGeneratorType($column, $entity): FieldGenerator
    {
        if (strpos($column->getName(), 'media_') !== false) {
            return new FieldFileGenerator($column, $entity);
        }

        if ($this->isForeignKey($column->getName())) {
            return new FieldSelectGenerator($column, $entity, true);
        } elseif (!$this->isForeignKey($column->getName()) && $this->hasOptions($entity, $column->getName())) {
            return new FieldSelectGenerator($column, $entity, false);
        }

        switch ($column->getType()->getName()) {
            case 'float':
            case 'decimal':
            case 'integer':
                return new FieldNumberGenerator($column, $entity);
                break;
            case 'string':
                return new FieldTextGenerator($column, $entity);
                break;
            case 'text':
                return new FieldTextareaGenerator($column, $entity);
                break;
            case 'date':
                return new FieldDateGenerator($column, $entity);
                break;
            case 'boolean':
                return new FieldRadioGenerator($column, $entity);
                break;
            default:
                return new FieldTextGenerator($column, $entity);
        }
    }

    /**
     * @param string $column
     * @return FieldGenerator
     * @throws \Exception
     */
    public function getField(string $column)
    {
        $columnBDD = DB::connection()->getDoctrineColumn($this->getTable(), $column);

        return $this->getFieldGeneratorType($columnBDD, $this);
    }

    /**
     * Check if is foreign key with name
     *
     * @param string $name
     * @return bool
     */
    public function isForeignKey(string $name): bool
    {
        return strpos($name, '_id') !== false;
    }

    /**
     * Check if has options
     *
     * @param string $name
     * @return bool
     */
    public function hasOptions($entity, string $name): bool
    {
        return method_exists($entity, 'getOptions' . ucFirst(Str::plural(Str::camel($name))));
    }
}
