<?php
    $config = require_once ('config.php');
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
    $readClients = $clients->read();
?>
<?php
require_once ('header.php');
?>

    <div class="container">
        <div class="row">
            <h1 >Cool name</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readClients as $client):?>
                    <tr>
                        <td><?= $client["id"] ?></td>
                        <td><?= $client["name"] ?></td>
                        <td><?= $client["birth_date"]?></td>
                        <td> <a href='clients/update.php?id=<?= $client["id"] ?>'>update</a> </td>
                        <td> <a href='clients/update.php?deleteID=<?= $client["id"] ?>'>delete</a> </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <a href='clients/create.php'>create</a>
        </div>
    </div>
<?php
require_once('footer.php');
