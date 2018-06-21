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
    private $update;
    private $statement;
    private $bindValuesArray;

    public function __construct($db) {
        $this->db = $db;
    }

    public function __destruct() {
        $this->table = '';
        $this->fields = '';
        $this->where = '';
        $this->query = '';
        $this->insert = '';
        $this->update = '';
        $this->statement = '';
        $this->bindValuesArray = '';
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

    public function buildDeleteQuery() {
        $query = '';
        $query .= 'DELETE FROM ' . $this->table;

        if($this->where) {
            $query .= ' WHERE ' . $this->where . ';';
        } else {
            $query .= ';';
        }

        $this->query = $query;
    }

    public function buildUpdateQuery() {
        $query = '';
        $query .= 'UPDATE ' . $this->table . ' SET ' . $this->update;

        if($this->where) {
            $query .= ' WHERE ' . $this->where . ';';
        } else {
            $query .= ';';
        }

        $this->query = $query;
    }

    public function bindValues() {
        foreach($this->bindValuesArray as $bindKey => $bindValue) {
            $valueDataType = gettype($bindValue);

            switch ($valueDataType) {
                case 'string':
                    $paramType = \PDO::PARAM_STR;
                    break;
                case 'integer':
                    $paramType = \PDO::PARAM_INT;
                    break;
                case 'boolean':
                    $paramType = \PDO::PARAM_BOOL;
                    break;
                default:
                    $paramType = \PDO::PARAM_STR;
            }
            
            $this->statement->bindValue($bindKey, $bindValue, $paramType);
        }
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
                $bindKey = str_replace(' ', '_', $whereValue);
                $this->bindValuesArray[':' . $bindKey] = $whereValue;
                $whereStr .= $whereKey . ' = :' . $bindKey;

                if(sizeof($key) !== $index + 1) {
                    $whereStr .= ' AND ';
                }

                $index++;
            }
            $this->where = $whereStr;
        } else if ($key && $value) {
            $bindKey = str_replace(' ', '_', $value);
            $this->bindValuesArray[':' . $bindKey] = $value;
            $this->where = $key . ' = :' . $bindKey;
        } else if ($key) {
            $this->where = $key;
        } else {
            throw new \Exception('Add valid WHERE Condition.');
        }

        return $this;
    }

    public function get() {
        $this->buildSelectQuery();
    
        $this->statement = $this->db->prepare($this->query);
        $this->bindValues();
        $this->statement->execute();

        $result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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
            // Bind Key Value Pairs
            $bindKey = str_replace(' ', '_', $value);
            $values .= ':' . $bindKey;
            $this->bindValuesArray[':' . $bindKey] = $value;

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

        $this->statement = $this->db->prepare($this->query);
        $this->bindValues();

        if($this->statement->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $this->buildDeleteQuery();
        $this->statement = $this->db->prepare($this->query);
        $this->bindValues();

        if($this->statement->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($array) {
        if(!is_array($array)) {
            throw new \Exception('Please provide a valid Array.');
        }

        $updateStr = '';
        $index = 0;

        foreach($array as $key => $value) {
            // Bind Key Value Pairs
            $bindKey = str_replace(' ', '_', $value);
            $this->bindValuesArray[':' . $bindKey] = $value;

            $updateStr .= $key . ' = :' . $bindKey;

            if(sizeof($array) !== $index + 1) {
                $updateStr .= ',';
            }
            $index++;
        }

        $this->update = $updateStr;

        $this->buildUpdateQuery();

        $this->statement = $this->db->prepare($this->query);
        $this->bindValues();

        if($this->statement->execute()) {
            return true;
        } else {
            return false;
        }
    }
}