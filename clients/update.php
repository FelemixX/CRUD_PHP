<?php
if(isset($_GET["id"]))
{
    $id = $_GET["id"];
}

if(isset($_GET["deleteID"]))
{
    $deleteID = $_GET["deleteID"];
    $conn = null;
    try
    {
        $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
    } catch (PDOException $exception)
    {
        echo "Ошибка подключпения к БД!: " . $exception->getMessage();
    }
    require_once('../tables/client.php');
    $client = new Client($conn);
    $client->id = $deleteID;
    if($client->delete())
    {
        header("Location: clients_page.php");
    }
}

if(isset($_POST["id"]) && isset($_POST["birth_date"]) && isset($_POST["name"]))
{
    $postID = $_POST["id"];
    $date = $_POST["birth_date"];
    $name = $_POST["name"];

    $conn = null;
    try
    {
        $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
    } catch (PDOException $exception)
    {
        echo "Ошибка подключения к БД!: " . $exception->getMessage();
    }
    require_once('../tables/client.php');
    $client = new Client($conn);
    $client->name = $name;
    $client->birth_date = $date;
    $client->id = $postID;
    if($client->update())
    {
        header("Location: clients_page.php");
    }
}
?>

<?php require_once ('../source/header.php'); ?>
<form action="update.php" method="post">
    <input class="invisible" name="id" value="<?=$id?>">
    <div class="mb-3">
        <label for="name" class="form-label">Имя</label>
        <input required name="name" type="text" class="form-control" id="name">
    </div>
    <div class="mb-3">
        <label for="birth_date" class="form-label">Дата рождения</label>
        <input required name="birth_date" type="date" class="form-control" id="birth_date">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="clients_page.php">Отменить</a>
</form>
<?php require_once ('../source/footer.php'); ?>

