<?php
$config = require_once('../source/config.php');
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

<?php
//поиск
if(isset($_GET['search']))
{
    $query = $_GET['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM debt
			        WHERE (`debt` LIKE '%" . $query . "%')");
    $result->execute();
    while($row = $result->fetch(PDO::FETCH_BOTH))
    {
        $id = array_shift($row);
        $array[$id] =$row[3];
    }
}

?>

<?php require_once('../source/header.php'); ?>

    <div class="container">
        <div class="row">
            <h1 >Список задолженностей</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">ID Задолженности</th>
                    <th scope="col">Задолженность</th>
                    <th scope="col">Номер документа</th>
                    <th scope="col">Действие с задолженностью</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readDebts as $debt):?>
                    <tr>
                        <td><?= $debt["id"] ?></td>
                        <td><?= $debt["debt"] ?></td>
                        <td><?= $debt["number"]?></td>
                        <td> <a href='update.php?id=<?= $debt["id"] ?>'>Обновить</a> </td>
                        <td> <a href='update.php?deleteID=<?= $debt["id"] ?>'>Удалить</a> </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <form method="get" action="debts_page.php">
                <br> Поиск товаров
                <br><input required name="search" type="text" />
                <button type="submit" class="btn btn-primary">Поиск</button>
            </form>
            <?php if(isset($_GET['search'])): ?>
                <?php if(empty($array)): ?>
                    <p>Ничего не найдено</p>
                <?php else: ?>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">ID Задолженности</th>
                            <th scope="col">Задолженность</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($array as $id => $prod):?>
                            <tr>
                                <td><?= $id?></td>
                                <td><?= $prod ?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
            <a href='create.php'>Создать</a>
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>