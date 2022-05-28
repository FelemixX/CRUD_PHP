<?php

require_once "config.php";


class Database
{
    protected $db_host;
    protected $db_name;
    protected $db_user;
    protected $db_pass;
    protected $config;

    public function __construct()
    {
        //$this->config = $config;
        if ($this->config)
        {
//            $this->db_host = $config['db_host'];
//            $this->db_name = $config['db_name'];
//            $this->db_user = $config['db_user'];
//            $this->db_pass = $config['db_pass'];
            $this->db_host = 'localhost:3366';
            $this->db_name = 'debts_docs_payments';
            $this->db_user = 'root';
            $this->db_pass = '';
        }
    }

    //Коннекшн
    public function getConnection()
    {
        $conn = null;
        try
        {
            $conn = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_pass);
        } catch (PDOException $exception)
        {
            echo "Ошибка подключпения к БД!: " . $exception->getMessage();
        }
        return $conn;
    }
}
