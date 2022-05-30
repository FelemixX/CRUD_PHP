<?php

$conn = null;

try
{
    $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
}
catch (PDOException $exception)
{
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}

if (isset($_POST["document_ID"]) && isset($_POST["debt"]))
{
    $totalDebt = $_POST["debt"];
    $documentID = $_POST["document_ID"];

    require_once('../tables/debt.php');
    $debt = new Debt($conn);

    $debt->debt = $totalDebt;
    $debt->document_ID = $documentID;

    if ($debt->create())
    {
        header("Location: debts_page.php");
    }
}

require_once ('../tables/document.php');
$document = new Document($conn);
$documents = $document->read();

?>
<?php require_once('../source/header.php'); ?>
<form action="create.php" method="post">
    <label for="document_ID" class="form-label">Документ</label>
    <select name="document_ID" class="form-select" aria-label="client select" id="document_ID">  <!-- Выпадашка -->
        <?php foreach ($documents as $item): ?> <!-- Выборка клиентов -->
            <option value="<?=$item["id"]?>" selected><?=$item["number"]?></option>
        <?php endforeach?>
    </select>
    <div class="mb-3">
        <label for="debt" class="form-label">Долг</label>
        <input required name="debt" type="number" class="form-control" id="debt">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="debts_page.php">Отмена</a>
</form>
<?php require_once('../source/footer.php'); ?>