<?php

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $database_name = DB_NAME;

    private $db;

    public function __construct() {
        $this->db = new mysqli($this->host, $this->user, $this->password, $this->database_name) or die("Terjadi ERROR ". mysqli_connect_error());
    }

    public function db() {
        return $this->db;
    }
}