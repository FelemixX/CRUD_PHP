<?php
$config = require_once ('../source/config.php');
$conn = null;
try
{
    $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
} catch (PDOException $exception)
{
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}
require_once('../tables/product.php');
$products = new Product($conn);
$readProducts = $products->read();
?>

<?php require_once ('../source/header.php'); ?>

    <div class="container">
        <div class="row">
            <h1 >Список товаров</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Действие</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readProducts as $product):?>
                    <tr>
                        <td><?= $product["id"] ?></td>
                        <td><?= $product["p_name"] ?></td>
                        <td><?= $product["quantity"]?></td>
                        <td> <a href='../products/update.php?id=<?= $product["id"] ?>'>Обновить</a> </td>
                        <td> <a href='../products/update.php?deleteID=<?= $product["id"] ?>'>Удалить</a> </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <a href='../products/create.php'>Создать</a>
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>