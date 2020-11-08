<?php


namespace KevinLbr\CrudGenerator\Traits;

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
     * @param string $nameCrud
     * @return string
     */
    private static function getTableFromName(string $nameCrud)
    {
        return strtolower($nameCrud . 's');
    }

    /**
     * @param $nameCrud
     * @return array
     */
    static function getFillable(string $nameCrud): array
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
        return in_array($nameColumn, self::getFillable($nameCrud));
    }
}
