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

require_once('../tables/document.php');
$documents = new Document($conn);
$readDocuments = $documents->read();
?>

<?php
//поиск
if(isset($_GET['search']))
{
    $query = $_GET['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM document
			        WHERE (`number` LIKE '%" . $query . "%')");
    $result->execute();
    while($row = $result->fetch(PDO::FETCH_BOTH))
    {
        $id = array_shift($row);
        $array[$id] =array($row[0], $row[1], $row[2]);
    }
}

?>

<?php require_once('../source/header.php'); ?>

    <div class="container">
        <div class="row">
            <h1 >Список документов</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">ID Документа</th>
                    <th scope="col">Номер документа</th>
                    <th scope="col">Имя клиента</th>
                    <th scope="col">Дата создания</th>
                    <th scope="col">Действие с документами</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readDocuments as $document):?>
                    <tr>
                        <td><?= $document["id"]?></td>
                        <td><?= $document["number"] ?></td>
                        <td><?= $document["name"]?></td> <!-- Имя клиента -->
                        <td><?= $document["creation_date"]?></td>
                        <td> <a href='update.php?id=<?= $document["id"] ?>'>Обновить</a> </td>
                        <td> <a href='update.php?deleteID=<?= $document["id"] ?>'>Удалить</a> </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <a href='create.php'>Создать</a>
            <form method="get" action="documents_page.php">
                <br> Поиск документов
                <br><input required name="search" type="text" />
                <button type="submit" class="btn btn-primary">Поиск</button>
            </form>
            <?php if(isset($_GET['search'])): ?>
                <?php if(empty($array)): ?>
                    <p>Ничего не найдено</p>
                <?php else: ?>
                    <table class="table table-hover">
                        <thead>
                        <h2>Найденные совпадения</h2>
                        <tr>
                            <th scope="col">ID Документа</th>
                            <th scope="col">Номер</th>
                            <th scope="col">Дата создания</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($array as $result):?>
                            <tr>
                                <td><?= $result["0"] ?></td>
                                <td><?= $result["1"] ?></td>
                                <td><?= $result["2"] ?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>