<?php
//function CallAPI($document)
//{
//    $get = [
//        'fam' => $secondName,
//        'nam' => $firstName,
//        'otch' => $thirdName,
//        'bdate' => $birth_date,
//        'doctype' => '21',
//        'docno' => $passportNum,
//        'key' => 'b2002f5294bcf07fb03109b82771c54875f2f55b'
//    ];
////    $get = [
////        'fam' => 'Мищинков',
////        'nam' => 'Александр',
////        'otch' => 'Григорьевич',
////        'bdate' => '22.11.2001',
////        'doctype' => '21',
////        'docno' => '1821834393',
////        'key' => 'b2002f5294bcf07fb03109b82771c54875f2f55b'
////    ];
//    $str = "";
//    foreach ($get as $index => $data) {
//        $str .= $index . "=" . $data . "&";
//    }
//    $str = substr_replace($str, "", -1);
//    $ch = curl_init('https://api-fns.ru/api/innfl?' . $str);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_HEADER, false);
//    $response = curl_exec($ch);
//    curl_close($ch);
//    echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($response, true) . '</pre>';
//    if(isset($response)){
//
//    } else {
//        echo "sth wrong";
//    }
//}
//C:\Users\bythe\Desktop\CRUD2_PHP\tin_query.php:33:
//{"items":[],"error":"Информация об ИНН не найдена. Рекомендуем проверить правильность введённых данных и повторить попытку поиска."}
//
//C:\Users\bythe\Desktop\CRUD2_PHP\tin_query.php:33:
//{"items":[{"ИНН":"301302268406"}]}
//CallAPI();