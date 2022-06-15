<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}
require_once('../source/Database.php');
$db = new Database();
$conn = $db->getConnection();


require_once('../tables/debt.php');
$debts = new Debt($conn);

$query = " ";
foreach ($_GET as $index => $item) {
    $query .= $index . " " . $item . ", ";
}
$query = substr_replace($query, "", -2);

$readDebts = $debts->read($query);
?>

<?php
//поиск
if (isset($_POST['search'])) {
    $query = $_POST['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM debt
			        WHERE (`debt` LIKE '%" . $query . "%')");
    $result->execute();
    while ($row = $result->fetch(PDO::FETCH_BOTH)) {
        $id = array_shift($row);
        $array[$id] = $row[3];
    }
}

if (isset($_POST['show_logs'])) {
    $log = $conn->prepare("SELECT * FROM logs ORDER BY last_update");
    $log->execute();
    while ($row = $log->fetch(PDO::FETCH_BOTH)) {
        $id = array_shift($row);
        $logs[$id] = array($row[0], $row[1], $row[2]);
    }
}

if (isset($_POST['call_proc'])) {
    $debts->callProc();
    header("Location: debts_page.php");
}

?>

<?php require_once('../source/header.php'); ?>
<div class="container">
    <h1>Список задолженностей</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th id="Id" scope="col">ID Задолженности</th>
            <th id="Debt" scope="col">Задолженность</th>
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
                <td><?= $debt["debt"] . " руб." ?></td>
                <td><?= "№ " . $debt["number"] ?></td>
                <?php if (isset($_SESSION["isAdmin"])): ?>
                    <td>
                        <a class="btn btn-outline-success" href='update.php?id=<?= $debt["id"] ?>'>Изменить</a>
                        <a class="btn btn-outline-danger" href='update.php?deleteID=<?= $debt["id"] ?>'>Удалить</a>
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
        <form class="mb-2" method="post" action="debts_page.php">
            <input type="hidden" name="call_proc" value="call_proc"/>
            <button type="submit" class="btn btn-primary">Выполнить процедуру</button>
        </form>
        <form class="mb-2" method="post" action="debts_page.php">
            <input type="hidden" name="show_logs" value="show_logs"/>
            <button type="submit" class="btn btn-primary">Показать логи</button>
        </form>
    <?php endif; ?>
    <?php if (isset($_POST['show_logs'])): ?>
        <?php if (empty($logs)): ?>
            <p>Нет логированной информации</p>
        <?php else: ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">ID Лога</th>
                    <th scope="col">Дата создания</th>
                    <th scope="col">ID Задолженности</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $result): ?>
                    <tr>
                        <td><?= $result["0"] ?></td>
                        <td><?= $result["1"] ?></td>
                        <td><?= $result["2"] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
    <form method="post" action="debts_page.php">
        <br>
        <h5>Поиск задолженностей</h5>
        <input class="form-control" required name="search" type="text"/>
        <br>
        <button type="submit" class="btn btn-primary">Поиск</button>
    </form>
    <?php if (isset($_POST['search'])): ?>
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
                        <td><?= $prod . " руб" ?></td>
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
    let sortDebt = document.getElementById("Debt");
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
    sortDebt.onclick = function (e) {
        if (url.searchParams.has("debt")) {
            if (url.searchParams.get("debt") === "asc") {
                url.searchParams.set("debt", "desc");
            } else {
                url.searchParams.delete("debt");
            }
        } else {
            url.searchParams.append("debt", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
</script>
