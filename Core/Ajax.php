<?php

namespace Core;

class Ajax {
    private $dataToSend;

    public function getJSON() {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        return $decoded;
    }
    
    public function send($data) {
        $this->dataToSend = $data;
        return $this;
    }

    public function json() {
        header('Content-type: application/json');

        echo json_encode($this->dataToSend);

        $this->dataToSend = '';
    }
}