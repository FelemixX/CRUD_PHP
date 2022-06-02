<?php
require_once "main_class.php";

class Documents_Clients_Products extends Main_Class
{
    protected $table_name = "documents_clients_products";
    public $document_FK, $product_FK, $client_FK;

    function create()
    {

        $query = "INSERT INTO $this->table_name (`document_FK`,`product_FK`, `client_fk`)
                            VALUES(?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$this->document_FK, $this->product_FK, $this->client_FK]))
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
        $query = "SELECT dcp.*,d.number, d.creation_date, c.*, p.p_name FROM documents_clients_products as dcp
                        JOIN document d on dcp.document_FK = d.id
                        JOIN client c on dcp.client_FK = c.id
                        JOIN product p on dcp.product_FK = p.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {

        $query = "UPDATE
                        " . $this->table_name . "
                   SET
                        `document_FK` = ?, `product_FK` = ?, `client_FK` = ?
                   WHERE
                        " . $this->table_name . " .`id` = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->document_FK);
        $stmt->bindParam(2, $this->product_FK);
        $stmt->bindParam(3, $this->client_FK);
        $stmt->bindParam(4, $this->id);

        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }
}
