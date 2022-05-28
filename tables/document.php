<?php
require_once "main_class.php";

class Document extends Main_Class
{
    protected $table_name = "document";
    public $number, $creation_date;

    function create()
    {
        $tname = $this->table_name;
        $query = "INSERT INTO $tname (`number`,`creation_date`)
                            VALUES(?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$this->number, $this->creation_date]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function read()
    {
        $tname = $this->table_name;
        $query = "SELECT $tname.id, $tname.number, $tname.creation_date
                    FROM $tname";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {

        $query = "UPDATE 
                        " . $this->table_name . "  
                   SET 
                        `number` = ?, `creation_date` = ?
                   WHERE 
                        " . $this->table_name . " .`id` = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->number);
        $stmt->bindParam(2, $this->creation_date);
        $stmt->bindParam(3, $this->id);

        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }
}