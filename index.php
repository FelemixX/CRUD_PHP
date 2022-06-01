<?php

$config = require_once('source/config.php');

$conn = null;
try
{
    $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
}
catch (PDOException $exception)
{
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}
if(isset($_GET['user_query']))
{
    $query = $_GET['user_query'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    $queryToExec = $conn->prepare($query);
    $queryToExec->execute();
     echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($queryToExec, true) . '</pre>';
    $queryToExec = $queryToExec->fetchAll(PDO::FETCH_ASSOC);

}
?>

<?php require_once ('source/header.php'); ?>
<div class="d-flex p-2 bd-highlight">

</div>

<div class="d-flex justify-content-center">
    <div>
       <h4>Отправить SQL Запрос</h4>
        <form  method="get" action="index.php">
            <input required name="user_query" type="text" />
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>
</div>
<?php require_once('source/footer.php'); ?>
