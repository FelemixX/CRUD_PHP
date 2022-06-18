<?php
require_once "main_class.php";

class Client extends Main_Class
{
    protected $table_name = "client";
    public $first_name, $second_name, $third_name, $birth_date, $tin, $id;

    function create()
    {
        if ($this->checkStatus()) {
            try {
                $tname = $this->table_name;
                $query = "INSERT INTO $tname (`first_name`, `second_name`, `third_name`, `birth_date`, `tin`)
                            VALUES(?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($query);

                if ($stmt->execute([$this->first_name, $this->second_name, $this->third_name, $this->birth_date, $this->tin])) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $error) {
                $caughtError = $error->getMessage();
                echo "Что-то пошло не так, обновите страницу и попробуйте еще раз";
            }
        } else {
            $_SERVER["wrongTIN"] = true;
        }
    }

    function read($sort)
    {

        if ($sort == "") {
            $sort = "id";
        }
        $tname = $this->table_name;
        $query = "SELECT $tname.id, $tname.birth_date, $tname.first_name, $tname.second_name, $tname.third_name, $tname.tin
                    FROM $tname 
                    ORDER BY $sort ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {
        $tname = $this->table_name;
        if ($this->checkStatus() && empty($_POST["tinNotFound"])) {
            try {
                $query = "UPDATE 
                        " . $tname . "  
                   SET 
                        `first_name` = ?, `second_name` = ?, `third_name` = ?, `birth_date` = ?, `tin` = ?
                   WHERE 
                        " . $tname . " .`id` = ?";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(1, $this->first_name);
                $stmt->bindParam(2, $this->second_name);
                $stmt->bindParam(3, $this->third_name);
                $stmt->bindParam(4, $this->birth_date);
                $stmt->bindParam(5, $this->tin);
                $stmt->bindParam(6, $this->id);

                if ($stmt->execute()) {
                    return true;
                }
                return false;
            } catch (Exception $error) {
                $caughtError = $error->getMessage();
                echo "Что-то пошло не так, обновите страницу и попробуйте еще раз";
            }
        } else {
            $_SERVER["wrongTIN"] = true;
            //header("Location: ../source/wrong_TIN.php");
        }
    }

    /*
* Если введен верный ИНН, то возвращается (в данном случае)
* ассоциативный массив.
* Если ИНН неверный, то в ответ ничего не приходит.
* Если ничего не пришло, то возвращаем 0, иначе 1.
* Функция проверяет наличие работы у человека, используя ИНН
* Независимо от трудоустройства человека, при верном ИНН
* В ответ вернет массив.
*/

    function checkStatus()
    {
        $date = null;
        $inn = $this->tin;
        if (!$date) {
            $date = new DateTime("now");;
        }
        $dateStr = $date->format("Y-m-d");
        $url = "https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status";
        $data = [
            "inn" => $inn,
            "requestDate" => $dateStr
        ];
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Content-type: application/json',
                ],
                'content' => json_encode($data)
            ],
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        $result = json_decode($result, true);
        if (isset($result)) {
            return true;
        } else {
            return false;
        }
    }
}