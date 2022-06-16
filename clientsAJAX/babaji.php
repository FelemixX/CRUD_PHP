<?php
require_once ('../tables/client.php');
require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();
$client = new Client($conn);
$readClients = $client->read("");
$client = json_encode($client,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
echo $client;
?>
<div class="container">
    <h1>Список клиентов</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th id="Id" scope="col">ID Клиента</th>
            <th id="First_Name" scope="col">Фамилия</th>
            <th id="Second_Name" scope="col">Имя</th>
            <th id="Third_Name" scope="col">Отчество</th>
            <th id="Date" scope="col">Дата рождения</th>
            <?php if (isset($_SESSION["isAdmin"])): ?>
                <th scope="col">Действие с клиентами</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($readClients as $client): ?>
            <tr>
                <td><?= $client["id"] ?></td>
                <td><?= $client["first_name"] ?></td>
                <td><?= $client["second_name"] ?></td>
                <td><?= $client["third_name"] ?></td>
                <td><?= $client["birth_date"] ?></td>
                <?php if (isset($_SESSION["isAdmin"])): ?>
                    <td>
                        <a class="btn btn-outline-success" href='update.php?id=<?= $client["id"] ?>'>Изменить</a>
                        <a class="btn btn-outline-danger" href='update.php?deleteID=<?= $client["id"] ?>'>Удалить</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (isset($_SESSION["isAdmin"])): ?>
        <a class="btn btn-primary" href='create.php'>Создать</a>
    <?php endif; ?>
    <form class="mb-2" method="post" action="clients_page.php">
         <h5 class="mt-3">Поиск клиентов по ФИО</h5>
        <input class="form-control" required name="search" type="text"/>
        <button type="submit" class="mt-3 btn btn-primary">Поиск</button>
    </form>
    <?php if (isset($_POST['search'])): ?>
        <?php if (empty($array)): ?>
            <p>Ничего не найдено</p>
        <?php else: ?>
            <table class="table table-hover">
                <thead>
                <h2>Найденные совпадения</h2>
                <tr>
                    <th scope="col">ID Клиента</th>
                    <th scope="col">Фамилия</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Отчество</th>
                    <th scope="col">Дата рождения</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($array as $result): ?>
                    <tr>
                        <td><?= $result["0"] ?></td>
                        <td><?= $result["1"] ?></td>
                        <td><?= $result["2"] ?></td>
                        <td><?= $result["3"] ?></td>
                        <td><?= $result["4"] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>