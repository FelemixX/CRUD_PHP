<?php
require_once('../tables/user.php');
require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();


if (isset($_POST['user_login']) && isset($_POST['user_passwd'])) {
    $user = new User($conn);
    $user->login = preg_replace('/\s+/', '', $_POST['user_login']);
    $user->pass = preg_replace('/\s+/', '', $_POST['user_passwd']);

    if ($user->authorization()) {
        header("Location: ../clients/clients_page.php");
    } else {
        header("Location: /index.php?error");
    }
}