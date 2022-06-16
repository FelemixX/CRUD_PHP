<?php
/*
 * Если введен верный ИНН, то возвращается (в данном случае)
 * ассоциативный массив.
 * Если ИНН неверный, то в ответ ничего не приходит.
 * Если ничего не пришло, то возвращаем 0, иначе 1.
 * Функция проверяет наличие работы у человека, используя ИНН
 * Независимо от трудоустройства человека, при верном ИНН
 * Вернет ассоциативный массив
*/
function checkStatus($inn, $date = null)
{
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
        echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($result, true) . '</pre>';
        if (isset($result)) {
            return true;
        } else {
            return false;
        }
}
?>
