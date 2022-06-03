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
    //Проверка на правильность введенного запроса
    try
    {
        /* Обработать полученный SQL запрос чтобы не уколоться инъекцией */
        $query = $_GET['user_query'];
        $query = trim($query);
        $query = htmlspecialchars($query);
        /* Выполнить запрос */
        $queryToExec = $conn->prepare($query);
        $queryToExec->execute();
        if ((preg_match('DELETE' || 'INSERT', $query)) > 0)
        {
            echo "Успешно применено к: " . $queryToExec->rowCount() . " столбцов";
        }
        else
        {
            $queryToExec = $queryToExec->fetchAll(PDO::FETCH_ASSOC);
        }

    }
    catch(Exception $error)
    {
        $caughtError = $error->getMessage();
    }
}
?>

<?php require_once ('source/header.php'); ?>
<div class="d-flex p-2 bd-highlight"> </div>
<div class="d-flex justify-content-center">
    <div>
       <h4>Отправить SQL Запрос</h4>
        <form method="get" action="index.php">
            <input required name="user_query" type="text" />
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
        <?php if(isset($_GET['user_query'])): ?>
            <?php if(empty($queryToExec)): ?>
                <p>Ничего не найдено</p>
            <?php elseif(isset($caughtError)): ?>
                <p><h4>Запрос введен неверно</h4></p>
            <?php else: ?>
                <table class="table table-hover">
                    <thead>
                        <h2>Результат запроса</h2>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($queryToExec as $key=>$value): ?>
                            <?php foreach($value as $row=>$val): ?>
                                <td><?= $val ?></td>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php endif; ?>
    </div>
</div>
<?php require_once('source/footer.php'); ?>