<?php
require_once "main_class.php";

class Debt extends Main_Class
{
    protected $table_name = "debt";
    public $debt, $document_ID, $client_ID;

    function create()
    {
        $tname = $this->table_name;
        $query = "INSERT INTO debt (`debt`, `document_ID`, `client_ID`)
                        VALUES(?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$this->debt, $this->document_ID, $this->client_ID]))
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
        $query = "SELECT db.*, d.number FROM debt as db
                    JOIN document d on db.document_ID = d.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {

        $query = "UPDATE 
                        " . $this->table_name . "  
                   SET 
                        `debt` = ?
                   WHERE 
                        " . $this->table_name . " .`id` = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->debt);
        $stmt->bindParam(2, $this->id);

        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }

    function getClientByDocID()
    {
        $query = "SELECT client_ID FROM document
                        WHERE id = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->document_ID);
        $stmt->execute();
        return $stmt->fetch();
    }

    function callProc()
    {
        $query = "call update_debt()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
}
