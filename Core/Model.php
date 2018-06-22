<?php
namespace Core;

use PDO;

abstract class Model {
    protected static $table;
    protected static $fillable = [];

    public function __construct($data = []) {
        $class = get_called_class();
        $fillableFields = $class::$fillable;

        $model = [];

        foreach($data as $key => $value) {
            if(array_search($key, $fillableFields) === false) {
                throw new \Exception($key . ' is not fillable!');
            } else {
                $model[$key] = $value;
            }
        }

        $this->model = $data;
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

        if(isset($this)) {
            $model = $this->model ? $this->model : '';
        } else {
            $model = '';
        }

        $queryBuilder = new Database(self::connectDB(), $fillableFields, $model);
        $queryBuilder->table($table);

        return $queryBuilder;
    }
}