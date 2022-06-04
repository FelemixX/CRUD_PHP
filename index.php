<?php

$config = require_once('source/config.php');

$conn = null;
try
{
    $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
}
catch (PDOException $exception) {
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}
?>

<?php


?>
<?php require_once ('source/header.php') ?>
    <form>
        <div class="mb-3">
            <label for="user_id" class="form-label">Логин</label>
            <input type="text" class="form-control" id="user_id" aria-describedby="user login">
        </div>
        <div class="mb-3">
            <label for="user_passwd" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="user_passwd">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me">
            <label class="form-check-label" for="remember_me">Запомнить</label>
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
<?php require_once('source/footer.php'); ?>