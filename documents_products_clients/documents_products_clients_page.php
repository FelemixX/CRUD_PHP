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

require_once('../tables/documents_clients_products.php');
$dcp = new Documents_Clients_Products($conn);
$readDcp = $dcp->read();
?>

<?php require_once('../source/header.php'); ?>

<div class="container">
    <div class="row">
        <h1>Список документов - клиентов - товаров</h1>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">ID клиента</th>
                <th scope="col">Имя клиента</th>
                <th scope="col">Дата рождения</th>
                <th scope="col">Товар</th>
                <th scope="col">Номер документа</th>
                <th scope="col">Дата создания документа</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($readDcp as $dcp): ?>
                <tr>
                    <td><?= $dcp["client_FK"] ?></td>
                    <td><?= $dcp["name"] ?></td>
                    <td><?= $dcp["birth_date"] ?></td>
                    <td><?= $dcp["p_name"] ?></td>
                    <td><?= $dcp["number"] ?></td>
                    <td><?= $dcp["creation_date"] ?></td>
                    <?php if (isset($_SESSION["isAdmin"])): ?>
                    <td><a href='update.php?id=<?= $dcp["id"] ?>'>Обновить</a></td>
                    <td><a href='update.php?deleteID=<?= $dcp["id"] ?>'>Удалить</a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (isset($_SESSION["isAdmin"])): ?>
        <a href='create.php'>Создать</a>
        <?php endif; ?>
    </div>
</div>
<?php require_once('../source/footer.php'); ?>


