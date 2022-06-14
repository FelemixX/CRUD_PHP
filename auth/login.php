<?php
require_once('../tables/user.php');
require_once('../source/Database.php');
$db = new Database();
$conn = $db->getConnection();


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