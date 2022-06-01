<?php
require_once "main_class.php";

class Documents_Clients_Products extends Main_Class
{
    protected $table_name = "documents_clients_products";
    public $document_FK, $product_FK, $client_FK;

//    function create()
//    {
//
//        $query = "INSERT INTO $this->table_name (`document_FK`,`product_FK`)
//                            VALUES(?, ?)";
//        $stmt = $this->conn->prepare($query);
//
//        if ($stmt->execute([$this->document_FK, $this->product_FK, $this->client_FK]))
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }

    function read()
    {
        $query = "SELECT $this->table_name.id, $this->table_name., st_groups.g_name
                    FROM $this->table_name
                    JOIN st_groups ON $this->table_name.group_id = st_groups.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

//    function update()
//    {
//
//        $query = "UPDATE
//                        " . $this->table_name . "
//                   SET
//                        `name` = ?, `group_id` = ?
//                   WHERE
//                        " . $this->table_name . " .`id` = ?";
//
//        $stmt = $this->conn->prepare($query);
//
//        $stmt->bindParam(1, $this->name);
//        $stmt->bindParam(2, $this->group_id);
//        $stmt->bindParam(3, $this->id);
//
//        if ($stmt->execute())
//        {
//            return true;
//        }
//        return false;
//    }
}
