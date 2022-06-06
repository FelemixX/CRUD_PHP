<?php
session_start();
if (!isset($_SESSION["usedId"]))
{
    header("Location: /index.php/");
}
$config = require_once('../source/config.php');
$conn = null;
try
{
    $conn = new PDO("mysql:host=" . "localhost:3306" . ";dbname=" . "debts_docs_payments", "root", "root");
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
if (isset($_GET['search']))
{
    $query = $_GET['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM product
			        WHERE (`p_name` LIKE '%" . $query . "%')");
    $result->execute();
    //echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($result, true) . '</pre>';
    while ($row = $result->fetch(PDO::FETCH_BOTH))
    {
        $id = array_shift($row);
        $array[$id] = array($row[0], $row[2], $row[3]); //0,2,3
    }
}

?>

<?php require_once('../source/header.php'); ?>

    <div class="container">
            <h1>Список товаров</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">ID Товара</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Номер документа</th>
                    <th scope="col">Количество</th>
                    <?php if (isset($_SESSION["isAdmin"])): ?>
                        <th scope="col">Действие с товарами</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readProducts as $product): ?>
                    <tr>
                        <td><?= $product["id"] ?></td>
                        <td><?= $product["p_name"] ?></td>
                        <td><?= "№ " . $product["number"] ?></td>
                        <td><?= $product["quantity"] ?></td>
                        <?php if (isset($_SESSION["isAdmin"])): ?>
                            <td>
                                <a class="btn btn-success" href='update.php?id=<?= $product["id"] ?>'>Обновить</a>
                                <a class="btn btn-danger" href='update.php?deleteID=<?= $product["id"] ?>'>Удалить</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (isset($_SESSION["isAdmin"])): ?>
                <a class="btn btn-primary" href='create.php'>Создать</a>
            <?php endif; ?>
            <form method="get" action="products_page.php">
                <br> Поиск товаров
                <br><input required name="search" type="text"/>
                <button type="submit" class="btn btn-primary">Поиск</button>
            </form>
            <?php if (isset($_GET['search'])): ?>
                <?php if (empty($array)): ?>
                    <p>Ничего не найдено</p>
                <?php else: ?>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">ID Товара</th>
                            <th scope="col">Наименование</th>
                            <th scope="col">Количество</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($array as $result): ?>
                            <tr>
                                <td><?= $result["0"] ?></td>
                                <td><?= $result["1"] ?></td>
                                <td><?= $result["2"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>