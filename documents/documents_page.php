<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}
require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();

require_once('../tables/document.php');
$documents = new Document($conn);

$query = " ";
foreach ($_GET as $index => $item) {
    $query .= $index . " " . $item . ", ";
}
$query = substr_replace($query, "", -2);

$readDocuments = $documents->read($query);
?>

<?php
//поиск
if (isset($_POST['search'])) {
    $query = $_POST['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM document
			        WHERE (`number` LIKE '%" . $query . "%')");
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_BOTH)) {
        $id = array_shift($row);
        $array[$id] = array($row[0], $row[1], $row[2]);
    }
}

?>

<?php require_once('../source/header.php'); ?>
<div class="container">
    <h1>Список документов</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th id="Id" scope="col">ID Документа</th>
            <th id="Number" scope="col">Номер документа</th>
            <th scope="col">ФИО</th>
            <th scope="col">ИНН</th>
            <th id="Creation_Date" scope="col">Дата создания</th>
            <?php if (isset($_SESSION["isAdmin"])): ?>
                <th scope="col">Действие с документами</th>
            <?php endif ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($readDocuments as $document): ?>
            <tr>
                <td><?= $document["id"] ?></td>
                <td><?= "№\t" . $document["number"] ?></td>
                <td><?= $document["first_name"] . "\t" . $document["second_name"] . "\t" . $document["third_name"] ?></td> <!-- Имя клиента -->
                <td><?= $document["tin"] ?></td>
                <td><?= $document["creation_date"] ?></td>
                <?php if (isset($_SESSION["isAdmin"])): ?>
                    <td>
                        <a class="btn btn-outline-success" href='update.php?id=<?= $document["id"] ?>'>Изменить</a>
                        <a class="btn btn-outline-danger" href='update.php?deleteID=<?= $document["id"] ?>'>Удалить</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (isset($_SESSION["isAdmin"])): ?>
        <form class="mb-2">
            <a class="btn btn-primary" href='create.php'>Создать</a>
        </form>
    <?php endif; ?>
    <form class="mb-2" method="post" action="documents_page.php">
        <h5 class="mt-3">Поиск документов по номеру</h5>
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
                    <th scope="col">ID Документа</th>
                    <th scope="col">Номер</th>
                    <th scope="col">Дата создания</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($array as $result): ?>
                    <tr>
                        <td><?= $result["0"] ?></td>
                        <td>№ <?= $result["1"] ?></td>
                        <td><?= $result["2"] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php require_once('../source/footer.php'); ?>
<!-- Сортировка -->
<script type="text/javascript">
    let sortId = document.getElementById("Id");
    let sortNumber = document.getElementById("Number");
    let sortCreationDate = document.getElementById("Creation_Date");
    let url = new URL(location.href);

    sortId.onclick = function (e) {
        if (url.searchParams.has("id")) {
            if (url.searchParams.get("id") === "asc") {
                url.searchParams.set("id", "desc");
            } else {
                url.searchParams.delete("id");
            }
        } else {
            url.searchParams.append("id", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
    sortNumber.onclick = function (e) {
        if (url.searchParams.has("number")) {
            if (url.searchParams.get("number") === "asc") {
                url.searchParams.set("number", "desc");
            } else {
                url.searchParams.delete("number");
            }
        } else {
            url.searchParams.append("number", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
    sortCreationDate.onclick = function (e) {
        if (url.searchParams.has("creation_date")) {
            if (url.searchParams.get("creation_date") === "asc") {
                url.searchParams.set("creation_date", "desc");
            } else {
                url.searchParams.delete("creation_date");
            }
        } else {
            url.searchParams.append("creation_date", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
</script>
