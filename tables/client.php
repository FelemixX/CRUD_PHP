<?php
require_once "main_class.php";

class Client extends Main_Class
{
    protected $table_name = "client";
    public $name, $birth_date, $id;

    function create()
    {
        try {
            $tname = $this->table_name;
            $query = "INSERT INTO $tname (`name`,`birth_date`)
                            VALUES(?, ?)";
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute([$this->name, $this->birth_date])) {
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
        $query = "SELECT $tname.id, $tname.birth_date, $tname.name
                    FROM $tname 
                    ORDER BY $sort ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {
        try {
            $tname = $this->table_name;
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

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $error) {
            $caughtError = $error->getMessage();
            echo "Что-то пошло не так, обновите страницу и попробуйте еще раз";
        }
    }
}