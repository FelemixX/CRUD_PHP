<?php
require_once('../config/Database.php');
require_once('../tables/client.php');

$db = new Database();
$conn = $db->getConnection();

//$firstName = $_POST["first_name"];
//$secondName = $_POST["second_name"];
//$thirdName = $_POST["third_name"];
//$date = $_POST["birth_date"];
//$tin = $_POST["tin"];
//
//$client = new Client($conn);
//$client->first_name = $firstName;
//$client->second_name = $secondName;
//$client->third_name = $thirdName;
//$client->birth_date = $date;
//$client->tin = $tin;
//
//if ($client->create()) {
//    header("Location: clients_page.php");
//}
?>
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
    <button id="create" type="button" class="ms-2 btn btn-primary">Сохранить</button>
</div>



