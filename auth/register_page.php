<?php require_once ('../tables/user.php'); ?>

<?php

$config = require_once ('../source/config.php');

$conn = null;
try
{
    $conn = new PDO("mysql:host=" . "localhost:3306" . ";dbname=" . "debts_docs_payments", "root", "root");
}
catch (PDOException $exception)
{
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}

if(isset($_POST['user_name']) && isset($_POST['user_login']) && isset($_POST['user_passwd']))
{
    $user = new User($conn);
    $user->userName = $_POST['user_name'];
    $user->login = $_POST['user_login'];
    $user->pass = $_POST['user_passwd'];

    if ($user->userExists())
    {
        $err = 'Пользователь с таким логином уже существует';
    }
    else
    {
        if ($user->registration())
        {
            header("Location: ../index.php");
        }
        else
        {
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    }
}

?>

<?php require_once ('../source/header.php'); ?>

<form method="post" action="register_page.php">
    <div class="mb-3">
        <label for="user_name" class="form-label">Имя</label>
        <input required name="user_name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control" id="user_name" aria-describedby="user name">
    </div>
    <div class="mb-3">
        <label for="user_login" class="form-label">Логин</label>
        <input required name="user_login" type="text" class="form-control" id="user_login" aria-describedby="user login">
    </div>
    <div class="mb-3">
        <label for="user_passwd" class="form-label">Пароль</label>
        <input required name="user_passwd" type="password" class="form-control" id="user_passwd">
    </div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    <?php if(isset($err)): ?>
        <?php echo '<br>' . $err; ?>
    <?php endif; ?>
</form>

<?php require_once ('../source/footer.php'); ?>
