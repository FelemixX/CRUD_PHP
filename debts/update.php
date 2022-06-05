<?php

$conn = null;

try
{
    $conn = new PDO("mysql:host=" . "localhost:3306" . ";dbname=" . "debts_docs_payments", "root", "root");
}
catch (PDOException $exception)
{
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}

if(isset($_GET["id"]))
{
    $id = $_GET["id"];

    require_once ('../tables/document.php');
    $document = new Document($conn);
    $documents = $document->read();
}

if(isset($_GET["deleteID"]))
{
    $deleteID = $_GET["deleteID"];

    require_once('../tables/debt.php');
    $debt = new Debt($conn);
    $debt->id = $deleteID;
    if($debt->delete())
    {
        header("Location: debts_page.php");
    }
}

if(isset($_POST["document_ID"]) && isset($_POST["id"]) && isset($_POST["debt"]))
{
    $postID = $_POST["id"];
    $totalDebt = $_POST["debt"];
    $document = $_POST["document_ID"];
    $conn = null;

    try
    {
        $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
    } catch (PDOException $exception)
    {
        echo "Ошибка подключения к БД!: " . $exception->getMessage();
    }
    require_once('../tables/debt.php');
    $debt = new Debt($conn);
    $debt->debt = $totalDebt;
    $debt->document_ID = $document;
    $debt->id = $postID;
    if($debt->update())
    {
        header("Location: debts_page.php");
    }
}
?>

<?php require_once ('../source/header.php'); ?>
<form action="update.php" method="post">
    <input class="invisible" name="id" value="<?=$id?>">
    <div class="mb-3">
        <label for="document_ID" class="form-label">Документ</label>
        <select name="document_ID" class="form-select" aria-label="client select" id="document_ID">  <!-- Выпадашка -->
            <?php foreach ($documents as $item): ?>
                <option value="<?=$item["id"]?>" selected><?=$item["number"]?></option>
            <?php endforeach?>
        </select>
        <label for="debt" class="form-label">Задолженность</label>
        <input required name="debt" type="number" class="form-control" id="debt">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="debts_page.php">Отмена</a>
</form>
<?php require_once ('../source/footer.php'); ?>

