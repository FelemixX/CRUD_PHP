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
if(isset($_GET['search']))
{
    $query = $_GET['search'];
    $rawResults = ("SELECT client.name FROM client
			        WHERE (`name` LIKE '%" . $query . "%')");
    if (isset($rawResults))
    {
        while ($results = mysqli_fetch_array($rawResults))
        {
            echo $results['name'];
        }
    }
    else
    {
        echo "Клиент не найден";
    }
}
?>


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
        <form method="get" action="clients_page.php">
            Поиск клиентов
            <input required name="search" type="text" />
            <button type="submit" class="btn btn-primary">Поиск</button>
        </form>
         <?php //fetchSearch($result); ?>
    </div>
</div>
<?php require_once('../source/footer.php'); ?>
