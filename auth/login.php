<?php
require_once('../tables/user.php');
$config = require_once('../source/config.php');

$conn = null;
try {
    $conn = new PDO("mysql:host=" . "localhost:3306" . ";dbname=" . "debts_docs_payments", "root", "root");
} catch (PDOException $exception) {
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}

if (isset($_POST['user_login']) && isset($_POST['user_passwd'])) {
    $user = new User($conn);
    $user->login = $_POST['user_login'];
    $user->pass = $_POST['user_passwd'];

    if ($user->authorization()) {
        header("Location: ../clients/clients_page.php");
    } else {
        header("Location: /index.php?error");
    }
}

