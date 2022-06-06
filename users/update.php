<?php
require_once('../tables/user.php');

$conn = null;

try
{
    $conn = new PDO("mysql:host=" . "localhost:3306" . ";dbname=" . "debts_docs_payments", "root", "root");
} catch (PDOException $exception)
{
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}

if (isset($_GET["id"]))
{
    $id = $_GET["id"];

    $user = new User($conn); //Вывод клиентов для выпадашки
    $users = $user->read();
}

if (isset($_GET["deleteID"]))
{
    $deleteID = $_GET["deleteID"];
    $removeUser = new User($conn);
    $removeUser->id = $deleteID;

    if ($removeUser->delete())
    {
        header("Location: users_page.php");
    }
}

if (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["login"]))
{
    $userID = $_POST["id"];
    $userName = $_POST["name"];
    $userLogin = $_POST["login"];

    $updateUser = new User($conn);
    $updateUser->id = $userID;
    $updateUser->name = $userName;
    $updateUser->login = $userLogin;

    if ($updateUser->update())
    {
        header("Location: users_page.php");
    }
}

?>

<?php require_once('../source/header.php'); ?>
<form action="update.php" method="post">
    <br>
    <div class="mb-3">
        <label for="user_ID" class="form-label">Пользователь</label>
        <select name="user_ID" class="form-select" aria-label="client select" id="user_ID">  <!-- Выпадашка -->
            <?php foreach ($users as $item): ?>
                <option value="<?= $item["id"] ?>" selected><?= $item["name"] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <input class="invisible" name="id" value="<?= $id ?>">
    <div class="mb-3">
        <label for="user_login" class="form-label">Логин</label>
        <input required name="user_login" type="text" class="form-control" id="user_login">
    </div>
    <div class="mb-3">
        <label for="user_name" class="form-label">Имя</label>
        <input required name="user_name" type="text" class="form-control" id="user_name">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="users_page.php">Отмена</a>
</form>
<?php require_once('../source/footer.php'); ?>
