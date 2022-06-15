<?php
require_once "main_class.php";

class Client extends Main_Class
{
    protected $table_name = "client";
    public $first_name, $second_name, $third_name, $birth_date, $id;

    function create()
    {
        try {
            $tname = $this->table_name;
            $query = "INSERT INTO $tname (`first_name`, `second_name`, `third_name`, `birth_date`)
                            VALUES(?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute([$this->first_name, $this->second_name, $this->third_name, $this->birth_date])) {
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
        $query = "SELECT $tname.id, $tname.birth_date, $tname.first_name, $tname.second_name, $tname.third_name
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
                        " . $tname . "  
                   SET 
                        `first_name` = ?, `second_name` = ?, `third_name` = ?, `birth_date` = ?
                   WHERE 
                        " . $tname . " .`id` = ?";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->first_name);
            $stmt->bindParam(2, $this->second_name);
            $stmt->bindParam(3, $this->third_name);
            $stmt->bindParam(4, $this->birth_date);
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
}