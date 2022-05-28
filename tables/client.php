<?php
require_once "main_class.php";
class Client extends Main_Class
{
    protected $table_name = "client";
    public $name, $birth_date, $id;

    function create()
    {

        $query = "INSERT INTO $this->table_name (`name`,`birth_date`)
                            VALUES(?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$this->name, $this->birth_date]))
        {
            return true;
        } else
        {
            return false;
        }
    }

    function read()
    {
        $query = "SELECT $this->table_name.id, $this->table_name.name, birth_date
                    FROM $this->table_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {
        $query = "UPDATE 
                        " . $this->table_name . "  
                   SET 
                        `name` = ?, `birth_date` = ?
                   WHERE 
                        " . $this->table_name . " .`id` = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->birth_date);
        $stmt->bindParam(3, $this->id);

        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }
}