<?php
require_once "main_class.php";

class User_Query_Exec extends Main_Class
{
    public $id;
    protected $conn;

    function execQuery($query)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

}
