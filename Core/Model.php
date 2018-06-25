<?php
namespace Core;

use PDO;

abstract class Model {
    protected static $table;
    protected static $fillable = [];
    protected static $newModel;

    public function __construct($data = []) {
        $class = get_called_class();
        $fillableFields = $class::$fillable;

        $newModel = [];

        foreach($data as $key => $value) {
            if(array_search($key, $fillableFields) === false) {
                throw new \Exception($key . ' is not fillable!');
            } else {
                $newModel[$key] = $value;
                $this->$key = $value;
            }
        }

        self::$newModel = $data;
    }

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
        } else {
            $fillableFields = [];
        }

        $queryBuilder = new Database(self::connectDB(), $fillableFields, self::$newModel, $class);
        $queryBuilder->table($table);

        return $queryBuilder;
    }
}