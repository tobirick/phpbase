<?php

namespace Core;

class Ajax {
    private static $dataToSend;

    public static function getJSON() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        return $content;
    }
    
    public static function send($data) {
        self::$dataToSend = $data;
        return new static();
    }

    public static function json() {
        header('Content-type: application/json');

        echo json_encode(self::$dataToSend);

        self::$dataToSend = '';
    }
}