<?php
require_once ('tables/main_class.php');
require_once ('tables/user.php');
$config = require_once('source/config.php');

$conn = null;
try
{
    $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
}
catch (PDOException $exception)
{
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}

if(isset($_POST['user_login']) && isset($_POST['user_passwd']))
{
    $user = new User($conn);
    $user->login = $_POST['user_login'];
    $user->pass = $_POST['user_passwd'];

    if($user->authorization())
    {
        $_SESSION["idUser"] = true;
        header("Location: clients/clients_page.php");
    }
    else
    {
        $_SESSION['error_log'] = "Такого пользователя не существует";
        header("Location: " . $_SERVER['PHP_SELF']);
    }
}
?>

<?php require_once ('source/header.php') ?>

    <form method="post" action="index.php">
        <div class="mb-3">
            <label for="user_login" class="form-label">Логин</label>
            <input required type="text" class="form-control" id="user_login" aria-describedby="user login">
        </div>
        <div class="mb-3">
            <label for="user_passwd" class="form-label">Пароль</label>
            <input required type="password" class="form-control" id="user_passwd">
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
    <button class="btn"><a href="/auth/register_page.php">Регистрация</a></button>

<?php require_once('source/footer.php'); ?>