<?php
$config = require_once('../source/config.php');
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

<?php
//поиск
if(isset($_GET['search']))
{
    $query = $_GET['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM product
			        WHERE (`p_name` LIKE '%" . $query . "%')");
    $result->execute();
    while($row = $result->fetch(PDO::FETCH_BOTH))
    {
        $id = array_shift($row);
        $array[$id] =$row[2];
    }
}

?>

<?php require_once('../source/header.php'); ?>

    <div class="container">
        <div class="row">
            <h1 >Список товаров</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">ID Товара</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Номер документа</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Действие с товарами</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readProducts as $product):?>
                    <tr>
                        <td><?= $product["id"] ?></td>
                        <td><?= $product["p_name"] ?></td>
                        <td><?= $product["number"]?></td>
                        <td><?= $product["quantity"]?></td>
                        <td> <a href='update.php?id=<?= $product["id"] ?>'>Обновить</a> </td>
                        <td> <a href='update.php?deleteID=<?= $product["id"] ?>'>Удалить</a> </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <a href='create.php'>Создать</a>
            <form method="get" action="products_page.php">
                <br> Поиск товаров
                <br><input required name="search" type="text" />
                <button type="submit" class="btn btn-primary">Поиск</button>
            </form>
            <?php if(isset($_GET['search'])): ?>
                <?php if(empty($array)): ?>
                    <p>Ничего не найдено</p>
                <?php else: ?>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">ID Товара</th>
                            <th scope="col">Наименование</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($array as $id => $prod):?>
                            <tr>
                                <td><?= $id?></td>
                                <td><?= $prod ?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>