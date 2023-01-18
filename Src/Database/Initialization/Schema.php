<?php

namespace MvcCore\Rental\Database\Initialization;

use MvcCore\Rental\Database\Initialization\Connection;
use Illuminate\Support\Facades\DB;



class Schema 
{
    public static function create($table, $engine = 'ENGINE=InnoDB COLLATE utf8_general_ci')
    {
        $tableName = $table->getTableName();
        $columns = $table->columnsToString();
        $query = <<<QUERY
            CREATE TABLE IF NOT EXISTS $tableName 
                ($columns) $engine
        QUERY;
        // $query = DB::statement("CREATE TABLE IF NOT EXISTS $tableName ($columns) $engine;");
        $connection = new Connection;
        try {
            $connection->getDb()->executeExQuery($query);
        } catch (\Exception $e) {
            Debugger::die_and_dump($query);
            return $e->getMessage();
        }
    }

    public static function dropIfExistsdrop(String $tableName)
    {
        $connection = new Connection;
        $connection->getDb()->executeExQuery("DROP TABLE IF EXISTS $tableName");
    }
}
