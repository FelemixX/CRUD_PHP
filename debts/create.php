<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    if(!isset($_SESSION["isAdmin"])) {
        header("Location: /index.php/");
    }
}

require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();


if (isset($_POST["document_ID"]) && isset($_POST["debt"])) {
    $totalDebt = $_POST["debt"];
    $documentID = $_POST["document_ID"];

    require_once('../tables/debt.php');
    $debt = new Debt($conn);
    $debt->debt = $totalDebt;
    $debt->document_ID = $documentID;
    $debt->client_ID = $debt->getClientByDocID()["client_ID"];
    if ($debt->create()) {
        header("Location: debts_page.php");
    }
}

require_once('../tables/document.php');
$doc = new Document($conn);
$documents = $doc->read("");
?>
<?php require_once('../source/header.php'); ?>
<div class="container">
    <form action="create.php" method="post">
        <label for="document_ID" class="form-label">Документ</label>
        <select name="document_ID" class="form-select" aria-label="document select" id="document_ID">
            <!-- Выпадашка -->
            <?php foreach ($documents as $item): ?> <!-- Выборка клиентов -->
                <option value="<?= $item["id"] ?>" selected><?= $item["number"] ?></option>
            <?php endforeach ?>
        </select>
        <div class="mb-3">
            <label for="debt" class="form-label">Задолженность</label>
            <input required name="debt" type="number" class="form-control" id="debt">
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
        <a class="btn btn-danger" href="debts_page.php">Отмена</a>
    </form><?php if (isset($_SERVER["err"])): ?>
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
    <?php endif; ?>
    <?php require_once('../source/footer.php'); ?>
</div>

