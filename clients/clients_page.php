<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}

require_once('../tables/client.php');
require_once('../source/Database.php');
$db = new Database();
$conn = $db->getConnection();
$clients = new Client($conn);

//сортировка
$query = " ";
foreach ($_GET as $index => $item) {
    $query .= $index . " " . $item . ", ";
}
$query = substr_replace($query, "", -2);

$readClients = $clients->read($query);
?>

<?php
//поиск
if (isset($_POST['search'])) {
    $query = $_POST['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM client
                    WHERE (`first_name` LIKE '%" . $query . "%')");
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_BOTH)) {
        $id = array_shift($row);
        $array[$id] = array($row[0], $row[1], $row[2], $row[3], $row[4]);
    }
}

?>

<?php require_once('../source/header.php'); ?>
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
<?php require_once('../source/footer.php'); ?>
<!-- Сортировка -->
<script type="text/javascript">
    let sortId = document.getElementById("Id");
    let sortFName = document.getElementById("First_Name");
    let sortSName = document.getElementById("Second_Name");
    let sortTName = document.getElementById("Third_Name");
    let sortDate = document.getElementById("Date");
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
    sortFName.onclick = function (e) {
        if (url.searchParams.has("first_name")) {
            if (url.searchParams.get("first_name") === "asc") {
                url.searchParams.set("first_name", "desc");
            } else {
                url.searchParams.delete("first_name");
            }
        } else {
            url.searchParams.append("first_name", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
    sortSName.onclick = function (e) {
        if (url.searchParams.has("second_name")) {
            if (url.searchParams.get("second_name") === "asc") {
                url.searchParams.set("second_name", "desc");
            } else {
                url.searchParams.delete("second_name");
            }
        } else {
            url.searchParams.append("second_name", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
    sortTName.onclick = function (e) {
        if (url.searchParams.has("third_name")) {
            if (url.searchParams.get("third_name") === "asc") {
                url.searchParams.set("third_name", "desc");
            } else {
                url.searchParams.delete("third_name");
            }
        } else {
            url.searchParams.append("third_name", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
    sortDate.onclick = function (e) {
        if (url.searchParams.has("birth_date")) {
            if (url.searchParams.get("birth_date") === "asc") {
                url.searchParams.set("birth_date", "desc");
            } else {
                url.searchParams.delete("birth_date");
            }
        } else {
            url.searchParams.append("birth_date", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }

</script>
