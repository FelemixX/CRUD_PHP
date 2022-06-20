<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}
$deleteID = $_GET["deleteID"];
if (isset($deleteID)) {
    require_once('../config/Database.php');
    require_once('../tables/client.php');

    $db = new Database();
    $conn = $db->getConnection();

    $client = new Client($conn);
    $client->id = $deleteID;
    if ($client->delete()) {
        $response = [
            'id' => $deleteID,
            'status' => 200,
            'message' => "Успешно удалено",
        ];
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}