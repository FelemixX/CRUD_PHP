<?php
if (isset($_POST["p_name"]) && isset($_POST["quantity"]))
{
    $productName = $_POST["p_name"];
    $quantity = $_POST["quantity"];

    $conn = null;

    try
    {
        $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
    } catch (PDOException $exception)
    {
        echo "Ошибка подключения к БД!: " . $exception->getMessage();
    }
    require_once('../tables/product.php');
    $product = new Product($conn);
    $product->p_name = $productName;
    $product->quantity = $quantity;
    if ($product->create())
    {
        header("Location: ../source/products_page.php");
    }
}
?>
<?php require_once('../source/header.php'); ?>
<form action="create.php" method="post">
    <div class="mb-3">
        <label for="p_name" class="form-label">Наименование</label>
        <input required name="p_name" type="text" class="form-control" id="p_name">
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Количество</label>
        <input required name="quantity" type="number" class="form-control" id="quantity">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="../source/products_page.php">Отмена</a>
</form>
<?php require_once('../source/footer.php'); ?>