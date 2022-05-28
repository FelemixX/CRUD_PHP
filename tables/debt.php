<?php
require_once "main_class.php";

class Debt extends Main_Class
{
    protected $table_name = "debt";
    public $paidDebt, $unpaidDebt, $totalDebt;
    public $creditorBank, $loanRate;

    function create()
    {
        $tname = $this->table_name;
        $query = "INSERT INTO $tname (`name`,`group_id`)
                            VALUES(?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$this->name, $this->group_id]))
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
        $query = "SELECT $tname.id, $tname.name, st_groups.g_name
                    FROM $this->table_name
                    JOIN st_groups ON $tname.group_id = st_groups.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {

        $query = "UPDATE 
                        " . $this->table_name . "  
                   SET 
                        `name` = ?, `group_id` = ?
                   WHERE 
                        " . $this->table_name . " .`id` = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->group_id);
        $stmt->bindParam(3, $this->id);

        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }
}
