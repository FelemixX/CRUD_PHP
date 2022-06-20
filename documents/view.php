<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    if (!isset($_SESSION["isAdmin"])) {
        header("Location: /index.php/");
    }
}

require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();

require_once('../tables/document.php');
$documents = new Document($conn);

$query = "SELECT * FROM document WHERE client_ID IS NULL";
$readDocument = $conn->prepare($query);
$readDocument->execute();
$readDocument = $readDocument->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require_once('../source/header.php'); ?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID файла</th>
            <th scope="col">Название</th>
            <th scope="col">Тип</th>
            <th scope="col">Номер документа</th>
            <th scope="col">Действие</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($readDocument

        as $document): ?>
        <tr>
            <td><?= $document["id"] ?></td>
            <td><?= $document["file_name"] ?></td>
            <td><?= $document["file_extension"] ?></td>
            <td><?= $document["number"] ?></td>
            <td>
                <form action="" method="post">
                    <a class="btn btn-outline-info">Открыть</a>
                </form>
            </td>
            <?php endforeach; ?>
        </tr>
        </tbody>
    </table>
<?php require_once('../source/footer.php'); ?>