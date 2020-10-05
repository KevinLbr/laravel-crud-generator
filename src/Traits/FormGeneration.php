<?php


namespace CkcNet\CrudGenerator\Traits;


use CkcNet\CrudGenerator\Util\FieldGenerator\FieldDateGenerator;
use CkcNet\CrudGenerator\Util\FieldGenerator\FieldFileGenerator;
use CkcNet\CrudGenerator\Util\FieldGenerator\FieldGenerator;
use CkcNet\CrudGenerator\Util\FieldGenerator\FieldNumberGenerator;
use CkcNet\CrudGenerator\Util\FieldGenerator\FieldRadioGenerator;
use CkcNet\CrudGenerator\Util\FieldGenerator\FieldSelectGenerator;
use CkcNet\CrudGenerator\Util\FieldGenerator\FieldTextareaGenerator;
use CkcNet\CrudGenerator\Util\FieldGenerator\FieldTextGenerator;
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
     * @param array $fillables
     * @return mixed
     */
    static function getFillablesModel(array $fillables = [])
    {
        $class = __CLASS__;
        $item = new $class();

        return $item->generateFields($fillables);
    }

    /**
     * Generate fields by default, with columns table
     *
     * @param array|null $fillables
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function generateFields(array $fillables = [])
    {
        $fillables = $fillables == []
            ? $this->getFillable()
            : $fillables;

        $data = [];
        foreach ($fillables as $fillable) {
            // fix enum type error
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $column = DB::connection()->getDoctrineColumn($this->getTable(), $fillable);
            $data[] = $this->getFieldGeneratorType($column, $this);
        }

        return collect($data);
    }

    /**
     * Generate field
     *
     * @param string $fillable
     * @return FieldGenerator
     * @throws \Exception
     */
    public function generateField(string $fillable)
    {
        // fix enum type error
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $column = DB::connection()->getDoctrineColumn($this->getTable(), $fillable);
        return $this->getFieldGeneratorType($column, $this);
    }

    /**
     * Convert column type to form type with name correspond to view name of input type
     *
     * ex : integer => number => /fields/number.blade.php exist
     *
     * @param $column
     * @param $entity
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
     * @param $fillable
     * @return FieldGenerator
     * @throws \Exception
     */
    public function getField($fillable)
    {
        $column = DB::connection()->getDoctrineColumn($this->getTable(), $fillable);

        return $this->getFieldGeneratorType($column, $this);
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
        return method_exists($entity, 'getOptions' . ucFirst(Str::camel($name)) . 's');
    }
}
