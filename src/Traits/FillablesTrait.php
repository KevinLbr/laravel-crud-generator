<?php


namespace KevinLbr\CrudGenerator\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Trait which generate form with columns
 *
 * Trait FormGeneration
 * @package App\Traits
 */
trait FillablesTrait
{
    /**
     * @param string $nameCrud
     * @return string
     */
    private static function getTableFromName(string $nameCrud)
    {
        return strtolower(Str::plural($nameCrud));
    }

    /**
     * @param $nameCrud
     * @return array
     */
    static function getFillables(string $nameCrud): array
    {
        $table = self::getTableFromName($nameCrud);

        $columns = DB::connection()->getSchemaBuilder()->getColumnListing($table);

        foreach($columns as $key => $column){
            if(in_array($column, ['id', 'updated_at', 'created_at'])){
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
    static function haveFileColumn(string $nameCrud): bool
    {
        foreach(config('crud-generator.columns_are_files') as $column){
            if($nameCrud == $column){
                return self::haveColumn($nameCrud, $column);
            }
        }

        return false;
    }

    /**
     * @param $nameCrud
     * @return bool
     * @throws \Exception
     */
    static function havePositionColumn(string $nameCrud): bool
    {
        foreach(config('crud-generator.columns_are_position') as $column){
            if($nameCrud == $column){
                return self::haveColumn($nameCrud, $column);
            }
        }

        return false;
    }

    /**
     * @param string $nameColumn
     * @param string $nameCrud
     * @return bool
     */
    static function haveColumn(string $nameCrud, string $nameColumn): bool
    {
        return in_array($nameColumn, self::getFillables($nameCrud));
    }
}
