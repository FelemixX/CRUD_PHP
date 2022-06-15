<?php
function getClientData()
{
    require_once('../source/Database.php');
    $db = new Database();
    $conn = $db->getConnection();

    require_once('../tables/document.php');
    $documents = new Document($conn);
    $readDocuments = $documents->read("");
    echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($readDocuments[0]["first_name"], true) . '</pre>';
    //callApi($firstName, $secondName, $thirdName, $birth_date, $number);
}
function CallAPI($firstName, $secondName, $thirdName, $birth_date, $passportNum)
{
    $get = [ //массив с данными, которые нужны API
        'fam' => $firstName,
        'nam' => $secondName,
        'otch' => $thirdName,
        'bdate' => $birth_date,
        'doctype' => '21',
        'docno' => $passportNum,
        'key' => 'b2002f5294bcf07fb03109b82771c54875f2f55b'
    ];
//    $get = [
//        'fam' => 'Мищинков',
//        'nam' => 'Александр',
//        'otch' => 'Григорьевич',
//        'bdate' => '22.11.2001',
//        'doctype' => '21',
//        'docno' => '1821834393',
//        'key' => 'b2002f5294bcf07fb03109b82771c54875f2f55b'
//    ];

    $str = "";
    foreach ($get as $index => $data) {
        $str .= $index . "=" . $data . "&";
    }
    $str = substr_replace($str, "", -1); //убрать лишнее из запроса

    try {
        $ch = curl_init('https://api-fns.ru/api/innfl?' . $str); //Подставить значения в url для отправки на сервер
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = json_decode(curl_exec($ch), true); //распарсить ответ как ассоциативный массив
        curl_close($ch);
    } catch (Exception $error) {
        echo "Что-то пошло не так...";
    }
    if (isset($response)) {
        if (empty($response["items"])) { //если в данные введены неверно, то в items ничего не будет лежать
            return false;
        } else if (isset($response["items"][0]["ИНН"])) { //если данные введены верно, то в items появится еще один массив с ИНН
            return true;
        }
    }
}
getClientData();