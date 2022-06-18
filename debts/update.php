<?php
require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();


if (isset($_GET["id"])) {
    $id = $_GET["id"];

    require_once('../tables/document.php');
    $document = new Document($conn);
    $documents = $document->read("");
}

if (isset($_GET["deleteID"])) {
    $deleteID = $_GET["deleteID"];

    require_once('../tables/debt.php');
    $debt = new Debt($conn);
    $debt->id = $deleteID;
    if ($debt->delete()) {
        header("Location: debts_page.php");
    }
}

if (isset($_POST["document_ID"]) && isset($_POST["id"]) && isset($_POST["debt"])) {
    $postID = $_POST["id"];
    $totalDebt = $_POST["debt"];
    $document = $_POST["document_ID"];

    require_once('../tables/debt.php');
    $debt = new Debt($conn);
    $debt->debt = $totalDebt;
    $debt->document_ID = $document;
    $debt->id = $postID;
    $debt->client_ID = $debt->getClientByDocID()["client_ID"];
    if ($debt->update()) {
        header("Location: debts_page.php");
    }
}
?>

<?php require_once('../source/header.php'); ?>
<div class="container">
    <form action="update.php" method="post">
        <input class="invisible" name="id" value="<?= $id ?>">
        <div class="mb-3">
            <label for="document_ID" class="form-label">Документ</label>
            <select name="document_ID" class="form-select" aria-label="client select" id="document_ID">
                <!-- Выпадашка -->
                <?php foreach ($documents as $item): ?>
                    <option value="<?= $item["id"] ?>" selected><?= $item["number"] ?></option>
                <?php endforeach ?>
            </select>
            <label for="debt" class="form-label">Задолженность</label>
            <input required name="debt" type="number" class="form-control" id="debt">
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
        <a class="btn btn-danger" href="debts_page.php">Отмена</a>
    </form>
    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
         role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
            <use xlink:href="#exclamation-triangle-fill"/>
        </svg>
        <div>
            Ошибка! Проверьте данные и попробуйте еще раз.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php require_once('../source/footer.php'); ?>
</div>
