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
    /* Обработать полученный SQL запрос чтобы не уколоться инъекцией */
    $query = $_GET['user_query'];
    $query = trim($query);
    $query = htmlspecialchars($query);
    /* Выполнить запрос */
    $queryToExec = $conn->prepare($query);
    $queryToExec->execute();
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
            <?php echo "<table>";
                foreach ($queryToExec as $key=>$value)
                {
                   echo "<tr>";
                    foreach ($value as $row=>$val)
                    {
                        echo '<td>' .$val. '</td>';
                    }
                    echo "</tr>";
                } ?>
    </div>
</div>
<?php require_once('source/footer.php'); ?>