<?php require_once('../tables/user.php'); ?>

<?php

$config = require_once('../source/config.php');

$conn = null;
try {
    $conn = new PDO("mysql:host=" . "localhost:3306" . ";dbname=" . "debts_docs_payments", "root", "root");
} catch (PDOException $exception) {
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}

if (isset($_POST['user_name']) && isset($_POST['user_login']) && isset($_POST['user_passwd'])) {
    $user = new User($conn);
    $user->userName = $_POST['user_name'];
    $user->login = $_POST['user_login'];
    $user->pass = $_POST['user_passwd'];

    if ($user->userExists()) {
        header("Location: " . $_SERVER[""] . "?userExists");
    } else {
        if ($user->registration()) {
            header("Location: ../index.php");
        }
    }
}

?>

<?php require_once('../source/header.php'); ?>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="d-xl-inline-flex p-5 bd-highlight col-lg-4">
            <div class="col-12">
                <h1 class="text-center mb-3" >Регистрация</h1>
                <form method="post" action="register_page.php">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Имя</label>
                        <input required name="user_name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control"
                               id="user_name"
                               aria-describedby="user name">
                    </div>
                    <div class="mb-3">
                        <label for="user_login" class="form-label">Логин</label>
                        <input required name="user_login" type="text" class="form-control" id="user_login"
                               aria-describedby="user login">
                    </div>
                    <div class=" mb-3">
                        <label for="user_passwd" class="form-label">Пароль</label>
                        <input required name="user_passwd" type="password" class="form-control" id="user_passwd">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="d-inline-block btn btn-primary mr-3">Зарегистрироваться</button>
                        <a class="d-inline-block btn btn-secondary" href="/index.php/">Назад</a>
                    </div>
                </form>
                <?php if (isset($_GET["userExists"])): ?>
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                            <use xlink:href="#exclamation-triangle-fill"/>
                        </svg>
                        <div>
                            Ошибка! Такой пользователь уже существует
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once('../source/footer.php'); ?>
