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

    require_once('../tables/document.php');
    $document = new Document($conn); //Вывод клиентов для выпадашки
    $documents = $document->read();
}

if(isset($_GET["deleteID"]))
{
    $deleteID = $_GET["deleteID"];
    require_once('../tables/product.php');

    $product = new Product($conn);
    $product->id = $deleteID;

    if($product->delete())
    {
        header("Location: products_page.php");
    }
}

if(isset($_POST["id"]) && isset($_POST["p_name"]) && isset($_POST["quantity"]))
{
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
    if($product->update())
    {
        header("Location: products_page.php");
    }
}
?>

<?php require_once ('../source/header.php'); ?>
<form action="update.php" method="post">
    <input class="invisible" name="id" value="<?=$id?>">
    <div class="mb-3">
        <label for="document_ID" class="form-label">Документ</label>
        <select name="document_ID" class="form-select" aria-label="client select" id="document_ID">  <!-- Выпадашка -->
            <?php foreach ($documents as $item): ?> <!-- Выборка клиентов -->
                <option value="<?=$item["id"]?>" selected><?=$item["number"]?></option>
            <?php endforeach?>
        </select>
        <label for="p_name" class="form-label">Наименование</label>
        <input required name="p_name" type="text" class="form-control" id="p_name">
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Количество</label>
        <input required name="quantity" type="number" class="form-control" id="quantity">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="products_page.php">Отмена</a>
</form>
<?php require_once ('../source/footer.php'); ?>

