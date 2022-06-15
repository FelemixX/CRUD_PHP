<?php
require_once('../source/Database.php');
$db = new Database();
$conn = $db->getConnection();


if (isset($_POST["client_ID"]) && isset($_POST["number"]) && isset($_POST["creation_date"]) && isset($_POST["tin"])) {
    require_once('../tables/client.php');

    $docNumber = $_POST["number"];
    $creationDate = $_POST["creation_date"];
    $clientID = $_POST["client_ID"];
    $docTin = $_POST["tin"];

    require_once('../tables/document.php');

    $document = new Document($conn);
    $document->number = $docNumber;
    $document->creation_date = $creationDate;
    $document->client_ID = $clientID;
    $document->tin = $docTin;

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
            <label for="tin" class="form-label">ИНН</label>
            <input required name="tin" type="number" class="form-control" oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="15" id="tin">
        </div>
        <div class="mb-3">
            <label for="creation_date" class="form-label">Дата создания</label>
            <input required name="creation_date" type="date" class="form-control" id="creation_date">
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
        <a class="btn btn-danger" href="documents_page.php">Отмена</a>
    </form>
</div>
<?php require_once('../source/footer.php'); ?>
