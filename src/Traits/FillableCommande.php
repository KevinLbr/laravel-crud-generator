<?php


namespace KevinLbr\CrudGenerator\Traits;


use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldDateGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldFileGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldNumberGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldRadioGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldSelectGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldTextareaGenerator;
use KevinLbr\CrudGenerator\Util\FieldGenerator\FieldTextGenerator;
use Illuminate\Support\Facades\DB;

/**
 * Trait which generate form with columns
 *
 * Trait FormGeneration
 * @package App\Traits
 */
trait FillableCommande
{
    /**
     * @param $nameCrud
     * @return array
     */
    static function getFillable(string $nameCrud): array
    {
        $table = strtolower($nameCrud . 's');

        $columns = DB::connection()->getSchemaBuilder()->getColumnListing($table);

        foreach($columns as $key => $column){
            if($column == 'id' || $column == 'updated_at' || $column == 'created_at'){
                unset($columns[$key]);
            }
        }

        return $columns;
    }

    /**
     * @param $nameCrud
     * @return bool
     * @throws \Exception
     */
    static function haveMediaColumn(string $nameCrud): bool
    {
        return self::haveColumn($nameCrud, 'media_id');
    }

    /**
     * @param $nameCrud
     * @return bool
     * @throws \Exception
     */
    static function havePositionColumn(string $nameCrud): bool
    {
        return self::haveColumn($nameCrud, 'position_id');
    }

    /**
     * @param string $nameColumn
     * @param string $nameCrud
     * @return bool
     */
    static function haveColumn(string $nameCrud, string $nameColumn): bool
    {
        $columns = self::getFillable($nameCrud);

        foreach($columns as $column){
            if($column == $nameColumn){
                return true;
            }
        }

        return false;
    }
}
