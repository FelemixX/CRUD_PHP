<?php
if (isset($_POST["number"]) && isset($_POST["creation_date"]))
{
    $docNumber = $_POST["number"];
    $creationDate = $_POST["creation_date"];

    $conn = null;

    try
    {
        $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
    } catch (PDOException $exception)
    {
        echo "Ошибка подключпения к БД!: " . $exception->getMessage();
    }
    require_once('../tables/document.php');
    $document = new Document($conn);
    $document->number = $docNumber;
    $document->creation_date = $creationDate;
    if ($document->create())
    {
        header("Location: ../source/documents_page.php");
    }
}
?>
<?php require_once('../source/header.php'); ?>
<form action="create.php" method="post">
    <div class="mb-3">
        <label for="number" class="form-label">Номер документа</label>
        <input required name="number" type="number" class="form-control" id="number">
    </div>
    <div class="mb-3">
        <label for="creation_date" class="form-label">Дата создания</label>
        <input required name="creation_date" type="date" class="form-control" id="creation_date">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="documents_page.php">Отмена</a>
</form>
<?php require_once('../source/footer.php'); ?>