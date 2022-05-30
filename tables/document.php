<?php
require_once "main_class.php";

class Document extends Main_Class
{
    protected $table_name = "document";
    public $number, $creation_date, $client_ID;

    function create()
    {
        $tname = $this->table_name;
        $query = "INSERT INTO $tname (`number`,`creation_date`)
                            VALUES(?, ?)";
//        $query = "INSERT INTO document (`number`, `creation_date`, `client_ID`)
//                        VALUES(?, ?, ?)";
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
       /* $query = "SELECT $tname.id, $tname.number, $tname.creation_date
                    FROM $tname";*/
        $query  = "SELECT dc.*, cl.name FROM document AS dc
                    JOIN client cl on dc.client_ID = cl.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {

        $query = "UPDATE 
                        " . $this->table_name . "  
                   SET 
                        `number` = ?, `creation_date` = ?, `client_ID` = ?
                   WHERE 
                        " . $this->table_name . " .`id` = ? ";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->number);
        $stmt->bindParam(2, $this->creation_date);
        $stmt->bindParam(3, $this->client_ID);
        $stmt->bindParam(4, $this->id);


        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }
}