<?php
require_once('../source/Database.php');
$db = new Database();
$conn = $db->getConnection();

if (isset($_POST["birth_date"]) && isset($_POST["first_name"]) && isset($_POST["second_name"]) && isset($_POST["second_name"])) {
    $date = $_POST["birth_date"];
    $firstName = $_POST["first_name"];
    $secondName = $_POST["second_name"];
    $thirdName = $_POST["third_name"];
    require_once('../tables/client.php');
    $client = new Client($conn);
    $client->first_name = $firstName;
    $client->second_name = $secondName;
    $client->third_name = $thirdName;
    $client->birth_date = $date;
    if ($client->create()) {
        header("Location: clients_page.php");
    }
}
?>
<?php require_once('../source/header.php'); ?>
<div class="container">
    <form action="create.php" method="post">
        <div class="mt-3 mb-3">
            <label for="first_name" class="form-label">Фамилия</label>
            <input required name="first_name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control" id="first_name">
        </div>
        <div class="mb-3">
            <label for="second_name" class="form-label">Имя</label>
            <input required name="second_name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control" id="second_name">
        </div>
        <div class="mb-3">
            <label for="hird_name" class="form-label">Отчество</label>
            <input required name="third_name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control" id="third_name">
        </div>
        <div class="mb-3">
            <label for="creation_date" class="form-label">Дата рождения</label>
            <input required name="birth_date" type="date" class="form-control" id="birth_date">
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
        <a class="btn btn-danger" href="clients_page.php">Отмена</a>
    </form>
    <?php require_once('../source/footer.php'); ?>
</div>
