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
require_once('../tables/debt.php');
$debts = new Debt($conn);
$readDebts = $debts->read();
?>

<?php
//поиск
if (isset($_GET['search']))
{
    $query = $_GET['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM debt
			        WHERE (`debt` LIKE '%" . $query . "%')");
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_BOTH))
    {
        $id = array_shift($row);
        $array[$id] = $row[3];
    }
}

?>

<?php require_once('../source/header.php'); ?>

    <div class="container">
        <div class="row">
            <h1>Список задолженностей</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">ID Задолженности</th>
                    <th scope="col">Задолженность</th>
                    <th scope="col">Номер документа</th>
                    <?php if (isset($_SESSION["isAdmin"])): ?>
                        <th scope="col">Действие с задолженностями</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readDebts as $debt): ?>
                    <tr>
                        <td><?= $debt["id"] ?></td>
                        <td><?= $debt["debt"] ?></td>
                        <td><?= $debt["number"] ?></td>
                        <?php if (isset($_SESSION["isAdmin"])): ?>
                            <td><a href='update.php?id=<?= $debt["id"] ?>'>Обновить</a></td>
                            <td><a href='update.php?deleteID=<?= $debt["id"] ?>'>Удалить</a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (isset($_SESSION["isAdmin"])): ?>
                <a href='create.php'>Создать</a>
            <?php endif; ?>
            <form method="get" action="debts_page.php">
                <br> Поиск задолженностей
                <br><input required name="search" type="text"/>
                <button type="submit" class="btn btn-primary">Поиск</button>
            </form>
            <?php if (isset($_GET['search'])): ?>
                <?php if (empty($array)): ?>
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
                        <?php foreach ($array as $id => $prod): ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $prod ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>