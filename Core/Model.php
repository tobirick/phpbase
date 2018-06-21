<?php
namespace Core;

use PDO;

abstract class Model {
    public static function getDB() {
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

    public static function DB() {
        $db = self::getDB();

        return new Database($db);
    }
}