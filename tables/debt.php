<?php
require_once "main_class.php";

class Debt extends Main_Class
{
    protected $table_name = "debt";
    public $paidDebt, $unpaidDebt, $debt;

    function create()
    {
        $tname = $this->table_name;
        $query = "INSERT INTO $tname (`debt`,`paid_debt`, `unpaid_debt`)
                            VALUES(?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$this->debt, $this->paidDebt, $this->unpaidDebt]))
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
        $query = "SELECT $tname.id, $tname.debt, $tname.paid_debt, $tname.unpaid_debt
                    FROM $this->table_name
                    /*JOIN st_groups ON $tname.group_id = st_groups.id*/";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {

        $query = "UPDATE 
                        " . $this->table_name . "  
                   SET 
                        `debt` = ?, `paid_debt` = ?, `unpaid_debt` = ?
                   WHERE 
                        " . $this->table_name . " .`id` = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->debt);
        $stmt->bindParam(2, $this->paidDebt);
        $stmt->bindParam(3, $this->unpaidDebt);
        $stmt->bindParam(4, $this->id);

        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }
}
