<?php
//Сделать работу с внешними ключами
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
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>