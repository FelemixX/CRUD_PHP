<?php

abstract class Main_Class
{
    public $id;
    protected $table_name;
    protected $conn;

    function __construct($db)
    {
        $this->conn = $db;
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    function readAll()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function delete()
    {

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($result = $stmt->execute())
        {
            return true;
        } else
        {
            return false;
        }
    }

    function sqlQuery($query)
    {
        $stmt = $this->conn->prepare($query);

    }
}

?>