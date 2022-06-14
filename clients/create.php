<?php
require_once ('../source/Database.php');
$db = new Database();
$conn = $db->getConnection();

if (isset($_POST["birth_date"]) && isset($_POST["name"])) {
    $date = $_POST["birth_date"];
    $name = $_POST["name"];
    require_once('../tables/client.php');
    $client = new Client($conn);
    $client->name = $name;
    $client->birth_date = $date;
    if ($client->create()) {
        header("Location: clients_page.php");
    }
}
?>
<?php require_once('../source/header.php'); ?>
<div class="container">
    <form action="create.php" method="post">
        <div class="mb-3">
            <label for="number" class="form-label">Имя</label>
            <input required name="name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control" id="name">
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
