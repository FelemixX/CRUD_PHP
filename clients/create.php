<?php
if (isset($_POST["number"]) && isset($_POST["creation_date"]))
{
    $date = $_POST["birth_date"];
    $name = $_POST["name"];

    $conn = null;
    try
    {
        $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
    } catch (PDOException $exception)
    {
        echo "Ошибка подключпения к БД!: " . $exception->getMessage();
    }
    require_once('../tables/document.php');
    $client = new Client($conn);
    $client->name = $name;
    $client->birth_date = $date;
    if ($client->create())
    {
        header("Location: ../index.php");
    }
}
?>
<?php require_once('../source/header.php'); ?>
<form action="create.php" method="post">
    <div class="mb-3">
        <label for="number" class="form-label">Номер документа</label>
        <input required name="name" type="text" class="form-control" id="name">
    </div>
    <div class="mb-3">
        <label for="creation_date" class="form-label">Дата создания</label>
        <input required name="birth_date" type="date" class="form-control" id="birth_date">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="../source/documents_page.php">Отмена</a>
</form>
<?php require_once('../source/footer.php'); ?>