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
require_once('../tables/client.php');
$clients = new Client($conn);
$readClients = $clients->read();
?>

<?php
if (isset($_GET["search"]))
?>

<!--$searchInput = $_REQUEST[''];-->
<!---->
<!--$query = "SELECT * FROM client-->
<!--WHERE `name` = '$searchInput'";-->
<!---->
<!--$result = $conn -> query($query);-->
<!---->
<!--function fetchSearch($result)-->
<!--{-->
<!--    if ($result->rowCount() > 0)-->
<!--    {-->
<!--        while ($row = $result -> fetch_assoc())-->
<!--        {-->
<!--            $arr = fetchSearch($row);-->
<!--            echo "ID: ". $row['id'] ."<br>-->
<!--                  Имя: ". $row['name'] ."<br>-->
<!--                  Дата рождения: ". $row['birth_date']."<br>";-->
<!--        }-->
<!--    }-->
<!--    else-->
<!--    {-->
<!--        echo "Клиент не найден";-->
<!--    }-->
<!--}-->



<?php require_once ('../source/header.php'); ?>

<div class="container">
    <div class="row">
        <h1 >Список клиентов</h1>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">ID Клиента</th>
                <th scope="col">Имя</th>
                <th scope="col">Дата рождения</th>
                <th scope="col">Действие с клиентами</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($readClients as $client):?>
                <tr>
                    <td><?= $client["id"] ?></td>
                    <td><?= $client["name"] ?></td>
                    <td><?= $client["birth_date"]?></td>
                    <td> <a href='update.php?id=<?= $client["id"] ?>'>Обновить</a> </td>
                    <td> <a href='update.php?deleteID=<?= $client["id"] ?>'>Удалить</a> </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
<!--        <button type="submit" href="create.php" class="btn btn-primary">Создать</button>-->
        <a href='create.php'>Создать</a>
        <form action="clients_page.php" method="get">
            Поиск клиента: <input type="text" name="search" id="search"<input/>
            <input type="button" value="Поиск"<input/>
            <hr>
        </form>
         <?php //fetchSearch($result); ?>
    </div>
</div>
<?php require_once('../source/footer.php'); ?>
