<?php
    $config = require_once ('source/config.php');
    $conn = null;
    try
    {
        $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
    } catch (PDOException $exception)
    {
        echo "Ошибка подключпения к БД!: " . $exception->getMessage();
    }
    require_once('tables/client.php');
    $clients = new Client($conn);
    $readDocuments = $clients->read();
?>

<?php require_once ('source/header.php'); ?>

    <div class="container">
        <div class="row">
            <h1 >Список клиентов</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Номер</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Дата рождения</th>
                    <th scope="col">Действие</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readDocuments as $client):?>
                    <tr>
                        <td><?= $client["id"] ?></td>
                        <td><?= $client["name"] ?></td>
                        <td><?= $client["birth_date"]?></td>
                        <td> <a href='clients/update.php?id=<?= $client["id"] ?>'>Обновить</a> </td>
                        <td> <a href='clients/update.php?deleteID=<?= $client["id"] ?>'>Удалить</a> </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <a href='clients/create.php'>Создать</a>
        </div>
    </div>
<?php require_once('source/footer.php'); ?>

