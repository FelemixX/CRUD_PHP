<?php
require_once "main_class.php";

class Document extends Main_Class
{
    protected $table_name = "document";
    public $number, $creation_date, $client_ID;

    function create()
    {
        $tname = $this->table_name;
            try {
                $query = "INSERT INTO $tname ( `number`, `creation_date`, `client_ID`)
                        VALUES(?, ?, ?)";
                $stmt = $this->conn->prepare($query);

                if ($stmt->execute([$this->number, $this->creation_date, $this->client_ID])) {
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
        $query = "SELECT dc.*, cl.first_name, cl.second_name, cl.third_name, cl.tin FROM $tname AS dc
                    JOIN client cl on dc.client_ID = cl.id
                    ORDER BY $sort";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {
        $tname = $this->table_name;
        try {
            $query = "UPDATE 
                        " . $tname . "  
                   SET 
                        `number` = ?, `creation_date` = ?, `client_ID` = ?
                   WHERE 
                        " . $tname . " .`id` = ? ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->number);
            $stmt->bindParam(2, $this->creation_date);
            $stmt->bindParam(3, $this->client_ID);
            $stmt->bindParam(4, $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $error) {
            $_SERVER["err"] = true;
        }
    }


}