<?php

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db_name = "ta";

    private $conn, $stmt, $query;

    public function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db_name);
        if (!$this->conn) {
            die("Connection failed: " . $this->error());
        }
    }

    public function error()
    {
        return mysqli_error($this->conn) . "<br>" . $this->query;
    }

    public function query($sql)
    {
        $this->stmt = mysqli_query($this->conn, $sql);
        if ($this->stmt) {
            return $this->stmt;
        }else {
            echo $this->error();
        }
    }

    public function insert($table, $data = [], $column = TRUE) 
    {
        $keys = [];
        $values = [];
        foreach ($data as $key => $value) {
            array_push($keys, $key);
            array_push($values, $value);
        }
        $keys = implode(",", $keys);
        $values = implode("', '", $values);
        if ($column == FALSE) {
            $this->query = "INSERT INTO {$table} VALUES ('{$values}')";
        }else {
            $this->query = "INSERT INTO {$table} ({$keys}) VALUES ('{$values}')";
        }
    }

    public function select($table, $column = "*")
    {
        $this->query = "SELECT {$column} FROM {$table}";
    }

    public function update($table, $data = []) 
    {
        $bind = $this->bind($data);
        $this->query = "UPDATE {$table} SET {$bind}";
    }

    public function delete($table, $data = [])
    {
        $bind = (!empty($data)) ? "WHERE " . $this->bind($data) : "";
        $this->query = "DELETE FROM {$table} {$bind}";
    }

    public function where($id, $value)
    {
        $this->query = $this->query . " WHERE {$id}={$value}";
    }

    public function bind($data = [])
    {
        $bind = [];
        foreach ($data as $key => $value) {
            array_push($bind, "{$key}='{$value}'");
        }
        $bind = implode(", ", $bind);
        return $bind;
    }

    public function execute()
    {
        return $this->query($this->query);
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function fetchAll($result)
    {
        return mysqli_fetch_assoc($result);
    }

    public function rowCount($result)
    {
        return mysqli_num_rows($result);
    }
}
