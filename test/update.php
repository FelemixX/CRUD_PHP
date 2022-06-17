<?php
if (isset($_POST["id"])
    && isset($_POST["birth_date"])
    && isset($_POST["first_name"])
    && isset($_POST["second_name"])
    && isset($_POST["third_name"])
    && isset($_POST["tin"])) {
    require_once('../config/Database.php');
    require_once('../tables/client.php');

    $db = new Database();
    $conn = $db->getConnection();

    $postID = $_POST["id"];
    $firstName = $_POST["first_name"];
    $secondName = $_POST["second_name"];
    $thirdName = $_POST["third_name"];
    $date = $_POST["birth_date"];
    $tin = $_POST["tin"];

    $client = new Client($conn);
    $client->first_name = $firstName;
    $client->second_name = $secondName;
    $client->third_name = $thirdName;
    $client->birth_date = $date;
    $client->tin = $tin;
    $client->id = $postID;
    if ($client->update()) {
        header("Location: clients_page.php");
    }
}
?>
<?php $id = $_GET["id"]; ?>
<?php if (isset($id)): ?>

    <?php
    require_once('../config/Database.php');
    require_once('../tables/client.php');
    $db = new Database();
    $conn = $db->getConnection();
    $client = new Client($conn);
    $clients = $client->read("");
    ?>
    <div>
        <form id="updateForm">
            <input class="invisible" name="id" value="<?= $id ?>">
            <br>
            <div class="mt-3 mb-3">
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
                <label for="hird_name" class="form-label">Отчество</label>
                <input required name="third_name" type="text" pattern="^[A-Za-zА-Яа-яЁё\s]+$" class="form-control"
                       id="third_name">
            </div>
            <div class="mb-3">
                <label for="tin" class="form-label">ИНН</label>
                <input required name="tin" type="number" class="form-control"
                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                       maxlength="12" id="tin">
            </div>
            <div class="mb-3">
                <label for="birth_date" class="form-label">Дата рождения</label>
                <input required name="birth_date" type="date" class="form-control" id="birth_date">
            </div>
            <a id="updateBtn" class="btn btn-primary">Отправить</a>
            <a class="btn btn-danger">Отменить</a>
        </form>
    </div>
    <script type="text/javascript">
        let updateBtn = $('#updateBtn');
        updateBtn.click(function (){
            let data;
            $("form#updateForm :input").each(function(){
                let input = $(this);
                console.log(input);
                let clientID = data[input.#client_ID];

            });
        })

    </script>
<?php endif; ?>
