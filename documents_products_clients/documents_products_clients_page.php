<?php

$config = require_once('../source/config.php');

$conn = null;

try
{
    $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
}
catch (PDOException $exception)
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
        <h1 >Список документов</h1>
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
            <?php foreach ($readDcp as $dcp):?>
                <tr>
                    <td><?= $dcp["client_FK"]?></td>
                    <td><?= $dcp["name"] ?></td>
                    <td><?= $dcp["birth_date"]?></td>
                    <td><?= $dcp["p_name"]?></td>
                    <td><?= $dcp["number"]?></td>
                    <td><?= $dcp["creation_date"]?></td>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once('../source/footer.php'); ?>


