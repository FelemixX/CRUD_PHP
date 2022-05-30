<?php
require_once "main_class.php";

class Product extends Main_Class
{
    protected $table_name = "product";
    public $p_name, $quantity;

    function create()
    {
        $tname = $this->table_name;
        $query = "INSERT INTO $tname (`p_name`,`quantity`)
                            VALUES(?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$this->p_name, $this->quantity]))
        {
            return true;
        } else
        {
            return false;
        }
    }

    function read()
    {
        $tname = $this->table_name;
        /*$query = "SELECT $tname.id, $tname.p_name, $tname.quantity
                    FROM $tname";*/
        $query =  "SELECT pr.*, d.number FROM product AS pr 
                    JOIN document d on pr.document_ID = d.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {
        $tname = $this->table_name;
        $query = "UPDATE 
                        " . $tname . "  
                   SET 
                        `p_name` = ?, `quantity` = ?
                   WHERE 
                        " . $tname . " .`id` = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->p_name);
        $stmt->bindParam(2, $this->quantity);
        $stmt->bindParam(3, $this->id);

        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }
}
