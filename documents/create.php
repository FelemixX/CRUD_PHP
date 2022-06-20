<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}

require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();


if (isset($_POST["client_ID"]) && isset($_POST["number"]) && isset($_POST["creation_date"])) {
    require_once('../tables/client.php');

    $docNumber = $_POST["number"];
    $creationDate = $_POST["creation_date"];
    $clientID = $_POST["client_ID"];

    require_once('../tables/document.php');

    $document = new Document($conn);
    $document->number = $docNumber;
    $document->creation_date = $creationDate;
    $document->client_ID = $clientID;

    if ($document->create()) {
        header("Location: documents_page.php");
    }
}

require_once('../tables/client.php');
$client = new Client($conn); //Вывод клиентов для выпадашки
$clients = $client->read("");

?>

<?php require_once('../source/header.php'); ?>
<div class="container">
    <form action="create.php" method="post">
        <div class="mt-3 mb-3">
            <label for="client_ID" class="form-label">Клиент</label>
            <select name="client_ID" class="form-select" aria-label="client select" id="client_ID">  <!-- Выпадашка -->
                <?php foreach ($clients as $item): ?> <!-- Выборка клиентов -->
                    <option value="<?= $item["id"] ?>" selected><?= $item["first_name"] . "\t" . $item["second_name"] . "\t" . $item["third_name"] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
        <label for="number" class="form-label">Номер документа</label>
        <input required name="number" type="number" class="form-control" id="number">
        </div>
        <div class="mb-3">
            <label for="creation_date" class="form-label">Дата создания</label>
            <input required name="creation_date" type="date" class="form-control" id="creation_date">
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
        <a class="btn btn-danger" href="documents_page.php">Отмена</a>
    </form>
        <?php if (isset($_SERVER["err"])): ?>
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