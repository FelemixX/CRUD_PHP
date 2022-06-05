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
        $aye = $this->login;

        $query= "SELECT * FROM $tname
                    WHERE login = '$aye'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stmt = $stmt->fetch();

        if (!empty($stmt))
        {
            $foundSalt = $stmt["salt"];
            $foundLogin = $stmt["login"];
            $saltedPass = md5($this->pass . $foundSalt);
            $pass = $stmt["pass"];

            if (($saltedPass == $pass))
            {
                self::logout();
                session_start();
                $_SESSION["usedId"] = $stmt["id"];
                if ($foundLogin == "admin")
                {
                    $_SESSION["isAdmin"] = true;
                    return true;
                }
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

    static function logout()
    {
        session_start();
        if (isset($_SESSION["usedId"]))
            unset($_SESSION["usedId"]);

        if (isset($_SESSION["isAdmin"]))
            unset($_SESSION["isAdmin"]);
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
