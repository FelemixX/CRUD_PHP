<?php

require_once "main_class.php";

Class User extends Main_Class
{
    protected $table_name = "user";

    public $userName, $login, $pass;

    function genSalt()
    {
        return  md5($this->userName . $this->login . $this->pass);
    }

    function registration()
    {
        $tname = $this->table_name;

        $salt = $this->genSalt();
        $saltedPass = md5($this->pass . $salt);

        $query = "INSERT INTO $tname (`name`, `login`, `pass`, `salt`)
                            VALUES(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$this->userName, $this->login, $saltedPass, $salt]))
        { //saltedPass == pass
            return true;
        }
        else
        {
            return false;
        }
    }

    function authorization()
    {
        $tname = $this->table_name;

        $query= "SELECT * FROM $tname
                    WHERE login = $this->login";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stmt = $stmt->fetchAll();
        if (isset($stmt))
        {
            $foundSalt = $stmt[0]["salt"];
            $saltedPass = md5($this->pass . $foundSalt);

            if ($saltedPass == $foundSalt)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function userExists()
    {
        $tname = $this->table_name;
        $login = $this->login;
        $query = "SELECT login FROM $tname 
                    WHERE login LIKE '$login'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stmt = $stmt->rowCount();
        if ($stmt > 0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
}
