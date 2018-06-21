<?php
namespace Core;

use PDO;

abstract class Model {
    protected static $table;
    protected static $fillable;

    private function connectDB() {
        static $db = null;

        if ($db === null) {
            try {
                $dsn = 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8';
                $db = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWORD'));
            } catch( PDOException $Exception ) {
                echo $Exception->getMessage() . ': ' . $Exception->getCode();
            }
        }

        return $db;
    }

    public function query() {
        $class = get_called_class();

        if($class::$table) {
            $table = $class::$table;
        } else {
            $classArr = explode('\\', $class);
            $table = strtolower($classArr[sizeof($classArr) - 1]) . 's';
        }

        if($class::$fillable) {
            $fillableFields = $class::$fillable;
        }

        $queryBuilder = new Database(self::connectDB(), $fillableFields);
        $queryBuilder->table($table);

        return $queryBuilder;
    }
}