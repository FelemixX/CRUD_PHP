<?php

if (isset($_GET['delete_id'])) {

    require_once "../include/db_connection.php";
    $database = new Database(require '../include/config.php');
    $db = $database->getConnection();

    require_once "../src/default_table.php";
    $dt = new Default_Table($db, $_GET['table']);

    $dt->id = $_GET['delete_id'];

    if ($dt->delete()) {
        header('Location: http://vladimirov.ivdev.ru/tables/'.$_GET['table'].'/'.$_GET['table'].'.php');
    }
    else {
        echo "ОШИБКА";
    }
}