<?php
require_once "main_class.php";

class Product extends Main_Class
{
    protected $table_name = "product";
    public $p_name, $quantity, $document_ID;

    function create()
    {
        try {
            $tname = $this->table_name;
            $query = "INSERT INTO $tname (`p_name`, `quantity`, `document_ID`)
                        VALUES(?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute([$this->p_name, $this->quantity, $this->document_ID])) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $error) {
            $_SERVER["err"] = true;
        }
    }

    function read($sort)
    {
        if ($sort == "") {
            $sort = "id";
        }
        $tname = $this->table_name;
        $query = "SELECT pr.*, d.number FROM $tname AS pr 
                    JOIN document d on pr.document_ID = d.id
                    ORDER BY $sort";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {
        try {
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

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $error) {
            $_SERVER["err"] = true;
        }
    }
}
