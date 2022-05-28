<?php
$config = require_once ('../source/config.php');
$conn = null;
try
{
    $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
} catch (PDOException $exception)
{
    echo "Ошибка подключпения к БД!: " . $exception->getMessage();
}
require_once('../tables/document.php');
$documents = new Document($conn);
$readDocuments = $documents->read();
?>

<?php require_once ('../source/header.php'); ?>

    <div class="container">
        <div class="row">
            <h1 >Список документов</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Номер</th>
                    <th scope="col">Дата создания</th>
                    <th scope="col">Действие</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($readDocuments as $document):?>
                    <tr>
                        <td><?= $document["id"] ?></td>
                        <td><?= $document["number"] ?></td>
                        <td><?= $document["creation_date"]?></td>
                        <td> <a href='../documents/update.php?id=<?= $document["id"] ?>'>Обновить</a> </td>
                        <td> <a href='../documents/update.php?deleteID=<?= $document["id"] ?>'>Удалить</a> </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <a href='../documents/create.php'>Создать</a>
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>