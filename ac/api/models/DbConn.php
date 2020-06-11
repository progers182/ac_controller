<?php
abstract class DbConn {

    protected $table = '';
    protected $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    abstract function read();
    abstract function read_single();
    abstract function create($data);
}