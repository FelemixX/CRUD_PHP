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

if (isset($_POST["client_FK"]) && isset($_POST["product_FK"]) && isset($_POST["document_FK"]))
{
    require_once ('../tables/documents_clients_products.php.php');

    $documentFK = $_POST["document_FK"];
    $productFK = $_POST["product_FK"];
    $clientFK = $_POST["client_FK"];

    $dcp = new Documents_Clients_Products($conn);
    $dcp->document_FK = $documentFK;
    $dcp->product_FK = $productFK;
    $dcp->client_FK = $clientFK;

    if ($dcp->create())
    {
        header("Location: documents_products_clients_page.php");
    }
}

require_once ('../tables/client.php');
$client = new Client($conn); //Вывод клиентов для выпадашки
$clients = $client->read();

require_once ('../tables/document.php');
$document = new Document($conn);    //Доки для выпадашки
$documents = $document->read();

require_once ('../tables/product.php');
$product = new Product($conn);  //Товары для выпадашки
$products = $product->read();

?>

<?php require_once('../source/header.php'); ?>

<form action="create.php" method="post">
    <br>
    <div class="mb-3">
        <label for="client_ID" class="form-label">Клиент</label>
        <select name="client_ID" class="form-select" aria-label="client select" id="client_ID">  <!-- Выпадашка -->
            <?php foreach ($clients as $item): ?> <!-- Выборка клиентов -->
                <option value="<?=$item["id"]?>" selected><?=$item["name"]?></option>
            <?php endforeach?>
        </select>
        <br>
        <label for="number" class="form-label">Наименование товара</label>
        <select name="product_name" class="form-select" aria-label="product select" id="product_name">  <!-- Выпадашка -->
            <?php foreach ($products as $item): ?> <!-- Выборка товаров -->
                <option value="<?=$item["id"]?>" selected><?=$item["p_name"]?></option>
            <?php endforeach?>
        </select>
        <br>
        <label for="number" class="form-label">Номер документа</label>
        <select name="document_number" class="form-select" aria-label="document select" id="document_number">  <!-- Выпадашка -->
            <?php foreach ($documents as $item): ?> <!-- Выборка документов -->
                <option value="<?=$item["id"]?>" selected><?=$item["number"]?></option>
            <?php endforeach?>
        </select>

    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="documents_products_clients_page.php">Отмена</a>
</form>

<?php require_once('../source/footer.php'); ?>