<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}

if (isset($_POST["updateData"])) {
    $updateData = $_POST["updateData"];
}

if (isset($updateData)) {

    require_once('../config/Database.php');
    require_once('../tables/client.php');

    $db = new Database();
    $conn = $db->getConnection();

    $postID = $updateData["id"];
    $firstName = $updateData["first_name"];
    $secondName = $updateData["second_name"];
    $thirdName = $updateData["third_name"];
    $date = $updateData["birth_date"];
    $tin = $updateData["tin"];

    $client = new Client($conn);
    $client->first_name = $firstName;
    $client->second_name = $secondName;
    $client->third_name = $thirdName;
    $client->birth_date = $date;
    $client->tin = $tin;
    $client->id = $postID;
    if ($client->update()) {
        header("Location: view.php");
    }
}

$id = $_GET["id"];
require_once('../config/Database.php');
require_once('../tables/client.php');
$db = new Database();
$conn = $db->getConnection();
$client = new Client($conn);
$clients = $client->read("");
?>
<input style="display:none;" name="id" value="<?= $id ?>">
<div class="mb-3">
    <label for="client_ID" class="form-label">Клиент</label>
    <select name="client_ID" class="form-select" aria-label="client select" id="client_ID">
        <!-- Выпадашка -->
        <?php foreach ($clients as $item): ?> <!-- Выборка клиентов -->
            <option value="<?= $item["id"] ?>" <?php if ($id == $item["id"]) echo "selected"; ?>><?= $item["first_name"] . "\t" . $item["second_name"] . "\t" . $item["third_name"] ?></option>
        <?php endforeach ?>
    </select>
</div>
<div class="mb-3">
    <label for="first_name" class="form-label">Фамилия</label>
    <input required name="first_name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control"
           id="first_name">
</div>
<div class="mb-3">
    <label for="second_name" class="form-label">Имя</label>
    <input required name="second_name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control"
           id="second_name">
</div>
<div class="mb-3">
    <label for="third_name" class="form-label">Отчество</label>
    <input required name="third_name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control"
           id="third_name">
</div>
<div class="mb-3">
    <label for="tin" class="form-label">ИНН</label>
    <input required name="tin" type="number" class="form-control"
           oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength="12" id="tin">
</div>
<div class="mb-4">
    <label for="birth_date" class="form-label">Дата рождения</label>
    <input required name="birth_date" type="date" class="form-control" id="birth_date">
</div>
<div class="text-center">
    <button type="button" class="me-2 btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
    <button id="save<?= $id ?>" type="button" class="ms-2 btn btn-primary">Сохранить</button>
</div>
<?php if (isset($_SERVER["wrongTIN"])): ?>
    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
         role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
            <use xlink:href="#exclamation-triangle-fill"/>
        </svg>
        <div>
            Ошибка! Введен несуществующий ИНН.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php else: ?>
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
<?php endif; ?>
