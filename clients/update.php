<?php

$conn = null;

try {
    $conn = new PDO("mysql:host=" . "localhost:3306" . ";dbname=" . "debts_docs_payments", "root", "root");
} catch (PDOException $exception) {
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    require_once('../tables/client.php');
    $client = new Client($conn); //Вывод клиентов для выпадашки
    $clients = $client->read("");
}

if (isset($_GET["deleteID"])) {
    $deleteID = $_GET["deleteID"];
    require_once('../tables/client.php');
    $client = new Client($conn);
    $client->id = $deleteID;
    if ($client->delete()) {
        header("Location: clients_page.php");
    }
}

if (isset($_POST["id"]) && isset($_POST["birth_date"]) && isset($_POST["name"])) {
    $postID = $_POST["id"];
    $date = $_POST["birth_date"];
    $name = $_POST["name"];

    require_once('../tables/client.php');
    $client = new Client($conn);
    $client->name = $name;
    $client->birth_date = $date;
    $client->id = $postID;
    if ($client->update()) {
        header("Location: clients_page.php");
    }
}
?>

<?php require_once('../source/header.php'); ?>
<form action="update.php" method="post">
    <input class="invisible" name="id" value="<?= $id ?>">
    <br>
    <div class="mb-3">
        <label for="client_ID" class="form-label">Клиент</label>
        <select name="client_ID" class="form-select" aria-label="client select" id="client_ID">  <!-- Выпадашка -->
            <?php foreach ($clients as $item): ?> <!-- Выборка клиентов -->
                <option value="<?= $item["id"] ?>" <?php if ($id == $item["id"]) echo "selected"; ?>><?= $item["name"] ?></option>
            <?php endforeach ?>
        </select>
        <label for="name" class="form-label">Имя</label>
        <input required name="name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control" id="name">
    </div>
    <div class="mb-3">
        <label for="birth_date" class="form-label">Дата рождения</label>
        <input required name="birth_date" type="date" class="form-control" id="birth_date">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a class="btn btn-danger" href="clients_page.php">Отменить</a>
</form>
<?php require_once('../source/footer.php'); ?>

