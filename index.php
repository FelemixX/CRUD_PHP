<?php
require_once('tables/user.php');
require_once('source/Database.php');
$db = new Database();
$conn = $db->getConnection();
?>

<?php require_once('source/header.php') ?>
<?php if (isset($_SESSION["userName"])): ?>
    <h2 class="text-center mt-5">Здравствуйте, <?= $_SESSION["userName"] ?>!</h2>
<?php else: ?>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="d-xl-inline-flex p-5 bd-highlight col-lg-4">
                <div class="col-12">
                    <h1 class="text-center mb-3">Авторизация</h1>
                    <form method="post" action="/auth/login.php">
                        <div class="mb-3">
                            <label for="user_login" class="form-label">Логин</label>
                            <input name="user_login" required type="text" class="form-control" id="user_login"
                                   aria-describedby="user login">
                        </div>
                        <div class=" mb-3">
                            <label for="user_passwd" class="form-label">Пароль</label>
                            <input name="user_passwd" required type="password" class="form-control" id="user_passwd">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mr-3">Войти</button>
                            <a type="submit" class="d-inline-block btn btn-secondary" href="/auth/register_page.php">Регистрация</a>
                        </div>
                    </form>
                    <?php if (isset($_GET["error"])): ?>
                        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
                             role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                <use xlink:href="#exclamation-triangle-fill"/>
                            </svg>
                            <div>
                                Ошибка! Пользователя не существует!
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php require_once('source/footer.php'); ?>