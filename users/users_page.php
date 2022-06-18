<?php
require_once('../tables/user.php');
require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();

session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}

$users = new User($conn);

$query = " ";
foreach ($_GET as $index => $item) {
    $query .= $index . " " . $item . ", ";
}
$query = substr_replace($query, "", -2);
$readUsers = $users->read($query);
?>

<?php
//поиск
if (isset($_POST['search'])) {
    $query = $_POST['search'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $result = $conn->prepare("SELECT * FROM user
                    WHERE (`name` LIKE '%" . $query . "%')");
    $result->execute();
    while ($row = $result->fetch()) {
        $id = array_shift($row);
        $array[$id] = array($row[0], $row[1], $row[4]);
    }
}

?>


<?php require_once('../source/header.php'); ?>

<div class="container">
    <h1>Список пользователей</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th id="Id" scope="col">ID Пользователя</th>
            <th id="Name" scope="col">Имя</th>
            <th id="Login" scope="col">Логин</th>
            <?php if (isset($_SESSION["isAdmin"])): ?>
                <th scope="col">Действие с пользователями</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($readUsers as $client): ?>
            <tr>
                <td><?= $client["id"] ?></td>
                <td><?= $client["name"] ?></td>
                <td><?= $client["login"] ?></td>
                <?php if (isset($_SESSION["isAdmin"])): ?>
                    <td>
                        <a class="btn btn-outline-success" href='update.php?id=<?= $client["id"] ?>'>Обновить</a>
                        <a class="btn btn-outline-danger" href='update.php?deleteID=<?= $client["id"] ?>'>Удалить</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <form class="mb-2" method="post" action="users_page.php">
        <br>
        <h5>Поиск пользователей по имени</h5>
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
                <h2>Найденные совпадения</h2>
                <tr>
                    <th scope="col">ID Пользователя</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Логин</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($array as $results): ?>
                    <tr>
                        <td><?= $results["0"] ?></td>
                        <td><?= $results["2"] ?></td>
                        <td><?= $results["1"] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (isset($_SERVER["err"])): ?>
        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
             role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                <use xlink:href="#exclamation-triangle-fill"/>
            </svg>
            <div>
                Ошибка! Проверьте данные и попробуйте еще раз.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>
<?php require_once('../source/footer.php'); ?>

<script type="text/javascript">
    let sortId = document.getElementById("Id");
    let sortName = document.getElementById("Name");
    let sortLogin = document.getElementById("Login");
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
    sortName.onclick = function (e) {
        if (url.searchParams.has("name")) {
            if (url.searchParams.get("name") === "asc") {
                url.searchParams.set("name", "desc");
            } else {
                url.searchParams.delete("name");
            }
        } else {
            url.searchParams.append("name", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
    sortLogin.onclick = function (e) {
        if (url.searchParams.has("login")) {
            if (url.searchParams.get("login") === "asc") {
                url.searchParams.set("login", "desc");
            } else {
                url.searchParams.delete("login");
            }
        } else {
            url.searchParams.append("login", "asc");
        }
        console.log(url);
        window.location.replace(url);
    }
</script>
