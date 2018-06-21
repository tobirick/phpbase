<?php

namespace Core;

use PDO;

class Database {
    private $db;
    private $table;
    private $fields;
    private $where;
    private $query;
    private $insert;

    public function __construct($db) {
        $this->db = $db;
    }

    public function buildSelectQuery() {
        $query = '';
        $query .= 'SELECT ' . $this->fields . ' FROM ' . $this->table;

        if($this->where) {
            $query .= ' WHERE ' . $this->where . ';';
        } else {
            $query .= ';';
        }

        $this->query = $query;
    }

    public function buildInsertQuery() {
        $query = '';
        $query .= 'INSERT INTO ' . $this->table . ' ' . $this->insert . ';';

        $this->query = $query;
    }

    public function get() {
        $this->buildSelectQuery();
    
        $statement = $this->db->prepare($this->query);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function table($table) {
        $this->table = $table;

        return $this;
    }

    public function select($fields) {
        $this->fields = $fields;

        return $this;
    }

    public function where($key, $value = '') {
        if(is_array($key)) {
            $whereStr = '';
            $index = 0;
            foreach($key as $whereKey => $whereValue) {
                $whereStr .= $whereKey . ' = \'' . $whereValue . '\'';
                if(sizeof($key) !== $index + 1) {
                    $whereStr .= ' AND ';
                }

                $index++;
            }
            $this->where = $whereStr;
        } else if ($key && $value) {
            $this->where = $key . ' = \'' . $value . '\'';
        } else if ($key) {
            $this->where = $key;
        } else {
            throw new \Exception('Add valid WHERE Condition.');
        }

        return $this;
    }

    public function insert($array) {
        if(!is_array($array)) {
            throw new \Exception('Please provide a valid Array.');
        }

        $keys = '(';
        $values = '(';
        $index = 0;

        foreach($array as $key => $value) {
            $keys .= $key;
            $values .= '\'' . $value . '\'';
            if(sizeof($array) === $index + 1) {
                $keys .= ')';
                $values .= ')';
            } else {
                $keys .= ', ';
                $values .= ', ';
            }

            $index++;
        }

        $this->insert = $keys . ' VALUES ' . $values;

        $this->buildInsertQuery();
        $statement = $this->db->prepare($this->query);

        if($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }
}