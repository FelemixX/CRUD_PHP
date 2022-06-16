<?php
require_once "main_class.php";

class Document extends Main_Class
{
    protected $table_name = "document";
    public $number, $tin, $creation_date, $client_ID;

    function create()
    {
        if ($this->checkStatus()) {
            try {
                $tname = $this->table_name;
                $query = "INSERT INTO $tname (`tin`, `number`, `creation_date`, `client_ID`)
                        VALUES(?, ?, ?, ?)";
                $stmt = $this->conn->prepare($query);

                if ($stmt->execute([$this->tin, $this->number, $this->creation_date, $this->client_ID])) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $error) {
                $caughtError = $error->getMessage();
                //echo "Что-то пошло не так, обновите страницу и попробуйте еще раз";
                echo "Ошибка при создании документа";
            }
        } else {
            header("Location ../source/wrong_TIN.php");
            return false;
        }
    }

    function read($sort)
    {
        if ($sort == "") {
            $sort = "id";
        }
        $tname = $this->table_name;
        $query = "SELECT dc.*, cl.first_name, cl.second_name, cl.third_name FROM $tname AS dc
                    JOIN client cl on dc.client_ID = cl.id
                    ORDER BY $sort";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    function update()
    {
        $tname = $this->table_name;
        try {
            $query = "UPDATE 
                        " . $tname . "  
                   SET 
                        `tin = ?`, `number` = ?, `creation_date` = ?, `client_ID` = ?
                   WHERE 
                        " . $tname . " .`id` = ? ";

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
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);
        if (isset($result)) {
            return true;
        } else {
            return false;
        }
    }
}