<?php

class Database
{
    protected $db_host;
    protected $db_name;
    protected $db_user;
    protected $db_pass;

    public function __construct()
    {
        $config = require_once "config.php";
        if ($config) {
            $this->db_host = $config['db_host'];
            $this->db_name = $config['db_name'];
            $this->db_user = $config['db_user'];
            $this->db_pass = $config['db_pass'];
        }
    }

    public function getConnection()
    {
        $conn = null;
        try {
            $conn = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_pass);
        } catch (PDOException $exception) {
            echo "Ошибка подключения к БД!: " . $exception->getMessage();
        }
        return $conn;
    }
}
