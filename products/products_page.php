<?php
require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}

require_once('../tables/product.php');
$products = new Product($conn);

$query = " ";
foreach ($_GET as $index => $item) {
    $query .= $index . " " . $item . ", ";
}
$query = substr_replace($query, "", -2);

$readProducts = $products->read($query);
?>

<?php
//поиск
if (isset($_POST['search'])) {
    $query = $_POST['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM product
			        WHERE (`p_name` LIKE '%" . $query . "%')");
    $result->execute();
    //echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($result, true) . '</pre>';
    while ($row = $result->fetch(PDO::FETCH_BOTH)) {
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
            <th id="Id" scope="col">ID Товара</th>
            <th id="P_Name" scope="col">Наименование</th>
            <th scope="col">Номер документа</th>
            <th id="Quantity" scope="col">Количество</th>
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
                <td><?= "№\t" . $product["number"] ?></td>
                <td><?= $product["quantity"] ?></td>
                <?php if (isset($_SESSION["isAdmin"])): ?>
                    <td>
                        <a class="btn btn-outline-success" href='update.php?id=<?= $product["id"] ?>'>Изменить</a>
                        <a class="btn btn-outline-danger" href='update.php?deleteID=<?= $product["id"] ?>'>Удалить</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (isset($_SESSION["isAdmin"])): ?>
        <a class="btn btn-primary" href='create.php'>Создать</a>
    <?php endif; ?>
    <form class="mb-2" method="post" action="products_page.php">
        <h5 class="mt-3">Поиск товаров по наименованию</h5>
        <input class="form-control" required name="search" type="text"/>
        <button type="submit" class="mt-3 btn btn-primary">Поиск</button>
    </form>
    <?php if (isset($_POST['search'])): ?>
        <?php if (empty($array)): ?>
            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
                 role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                <div>
                    Ошибка! Ничего не найдено.
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
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

<?php require_once('../source/footer.php'); ?>
<!-- Сортировка -->
<script type="text/javascript">
    let sortId = document.getElementById("Id");
    let sortName = document.getElementById("P_Name");
    let sortQuantity = document.getElementById("Quantity");
    let url = new URL(location.href);

    sortId.onclick = function (e) {
        if (url.searchParams.has("id")) {
            if (url.searchParams.get("id") === "asc") {
                url.searchParams.set("id", "desc");
            } else {
                url.searchParams.delete("id");
            }
        } else {
            url.searchParams.append("id", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
    sortName.onclick = function (e) {
        if (url.searchParams.has("p_name")) {
            if (url.searchParams.get("p_name") === "asc") {
                url.searchParams.set("p_name", "desc");
            } else {
                url.searchParams.delete("p_name");
            }
        } else {
            url.searchParams.append("p_name", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
    sortQuantity.onclick = function (e) {
        if (url.searchParams.has("quantity")) {
            if (url.searchParams.get("quantity") === "asc") {
                url.searchParams.set("quantity", "desc");
            } else {
                url.searchParams.delete("quantity");
            }
        } else {
            url.searchParams.append("quantity", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
</script>
