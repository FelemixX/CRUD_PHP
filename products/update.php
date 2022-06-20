<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}
require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();


if (isset($_GET["id"])) {
    $id = $_GET["id"];

    require_once('../tables/document.php');
    $document = new Document($conn); //Вывод клиентов для выпадашки
    $documents = $document->read("");
}

if (isset($_GET["deleteID"])) {
    $deleteID = $_GET["deleteID"];
    require_once('../tables/product.php');

    $product = new Product($conn);
    $product->id = $deleteID;

    if ($product->delete()) {
        header("Location: products_page.php");
    }
}

if (isset($_POST["id"]) && isset($_POST["p_name"]) && isset($_POST["quantity"])) {
    $postID = $_POST["id"];
    $productName = $_POST["p_name"];
    $quantity = $_POST["quantity"];
    $documentID = $_POST["document_ID"];

    require_once('../tables/product.php');
    $product = new Product($conn);
    $product->p_name = $productName;
    $product->quantity = $quantity;
    $product->document_ID = $documentID;
    $product->id = $postID;
    if ($product->update()) {
        header("Location: products_page.php");
    }
}
?>

<?php require_once('../source/header.php'); ?>
<div class="container">
    <div action="update.php" method="post">
        <input class="invisible" name="id" value="<?= $id ?>">
        <div class="mb-3">
            <label for="document_ID" class="form-label">Документ</label>
            <select name="document_ID" class="form-select" aria-label="client select" id="document_ID">
                <!-- Выпадашка -->
                <?php foreach ($documents as $item): ?> <!-- Выборка клиентов -->
                    <option value="<?= $item["id"] ?>" selected><?= $item["number"] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="p_name" class="form-label">Наименование</label>
            <input required name="p_name" type="text" class="form-control" id="p_name">
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Количество</label>
            <input required name="quantity" type="number" class="form-control" id="quantity">
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
        <a class="btn btn-danger" href="products_page.php">Отмена</a>
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