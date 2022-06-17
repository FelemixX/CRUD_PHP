<?php
require_once('../config/Database.php');
require_once('../tables/client.php');

$db = new Database();
$conn = $db->getConnection();

if (isset($_POST["birth_date"]) && isset($_POST["first_name"]) && isset($_POST["second_name"]) && isset($_POST["second_name"]) && isset($_POST["tin"])) {
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
    if ($client->create()) {
        header("Location: clients_page.php");
    }
}
?>
<?php require_once ('../source/header.php');?>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Launch static backdrop modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>
<?php require_once ('../source/footer.php'); ?>