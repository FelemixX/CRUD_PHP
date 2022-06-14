<?php
require_once "main_class.php";

class Document extends Main_Class
{
    protected $table_name = "document";
    public $number, $tin, $creation_date, $client_ID;

    function create()
    {
        try {
            $tname = $this->table_name;
            $query = "INSERT INTO document (`tin`, `number`, `creation_date`, `client_ID`)
                        VALUES(?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute([$this->tin, $this->number, $this->creation_date, $this->client_ID])) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $error) {
            $caughtError = $error->getMessage();
            echo "Что-то пошло не так, обновите страницу и попробуйте еще раз";
        }
    }

    function read($sort)
    {
        if ($sort == "") {
            $sort = "id";
        }
        $tname = $this->table_name;
        $query = "SELECT dc.*, cl.name FROM document AS dc
                    JOIN client cl on dc.client_ID = cl.id
                    ORDER BY $sort";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {
        try {
            $query = "UPDATE 
                        " . $this->table_name . "  
                   SET 
                        `tin = ?`, `number` = ?, `creation_date` = ?, `client_ID` = ?
                   WHERE 
                        " . $this->table_name . " .`id` = ? ";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->tin);
            $stmt->bindParam(2, $this->number);
            $stmt->bindParam(3, $this->creation_date);
            $stmt->bindParam(4, $this->client_ID);
            $stmt->bindParam(5, $this->id);


            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $error) {
            $caughtError = $error->getMessage();
            echo "Что-то пошло не так, обновите страницу и попробуйте еще раз";
        }
    }

    function checkTax()
    {

    }
}