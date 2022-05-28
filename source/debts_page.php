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
require_once('../tables/debt.php');
$debts = new Debt($conn);
$readDebts = $debts->read();
?>

<?php require_once ('../source/header.php'); ?>

    <div class="container">
        <div class="row">
            <h1 >Список долгов</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Долг</th>
                    <th scope="col">Оплаченный долг</th>
                    <th scope="col">Неоплаченный долг</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readDebts as $debt):?>
                    <tr>
                        <td><?= $debt["id"] ?></td>
                        <td><?= $debt["debt"] ?></td>
                        <td><?= $debt["paid_debt"]?></td>
                        <td><?= $debt["unpaid_debt"]?></td>
                        <td> <a href='../debts/update.php?id=<?= $debt["id"] ?>'>Обновить</a> </td>
                        <td> <a href='../debts/update.php?deleteID=<?= $debt["id"] ?>'>Удалить</a> </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <a href='../debts/create.php'>Создать</a>
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>