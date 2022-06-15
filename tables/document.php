<?php
require_once "main_class.php";

class Document extends Main_Class
{
    protected $table_name = "document";
    public $number, $tin, $creation_date, $client_ID;

    function create()
    {
        try {
            $tname = $this->table_name;
            $query = "INSERT INTO document (`tin`, `number`, `creation_date`, `client_ID`)
                        VALUES(?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute([$this->tin, $this->number, $this->creation_date, $this->client_ID])) {
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
        $query = "SELECT dc.*, cl.first_name, cl.second_name, cl.third_name FROM document AS dc
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

    function checkTax()
    {
//        $get = [
//            'fam' => $secondName,
//            'nam' => $firstName,
//            'otch' => $thirdName,
//            'bdate' => $birth_date,
//            'doctype' => '21',
//            'docno' => $passportNum,
//            'key' => 'b2002f5294bcf07fb03109b82771c54875f2f55b'
//        ];
//    $get = [
//        'fam' => 'Мищинков',
//        'nam' => 'Александр',
//        'otch' => 'Григорьевич',
//        'bdate' => '22.11.2001',
//        'doctype' => '21',
//        'docno' => '1821834393',
//        'key' => 'b2002f5294bcf07fb03109b82771c54875f2f55b'
//    ];
//        $str = "";
//        foreach ($get as $index => $data) {
//            $str .= $index . "=" . $data . "&";
//        }
//        $str = substr_replace($str, "", -1);
//        $ch = curl_init('https://api-fns.ru/api/innfl?' . $str);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_HEADER, false);
//        $response = curl_exec($ch);
//        curl_close($ch);
//        echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($response, true) . '</pre>';
//        if(isset($response)){
//
//        } else {
//            echo "sth wrong";
//        }
    }
}
//вывод
//C:\Users\bythe\Desktop\CRUD2_PHP\tin_query.php:33:
//{"items":[],"error":"Информация об ИНН не найдена. Рекомендуем проверить правильность введённых данных и повторить попытку поиска."}
//
//C:\Users\bythe\Desktop\CRUD2_PHP\tin_query.php:33:
//{"items":[{"ИНН":"301302268406"}]}