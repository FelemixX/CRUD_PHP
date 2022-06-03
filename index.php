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
        $query = $_GET['user_query'];
        $query = trim($query);    //Убрать пробелы
        $query = htmlspecialchars($query);  //Преобразовать спец символы в сущности HTML

        if(str_contains($query, 'SELECT') || str_contains($query, 'select'))    //Обработка SELECT запроса
        {
            /* Выполнить запрос */
            $queryToExec = $conn->prepare($query);
            $queryToExec->execute();
            $queryToExec = $queryToExec->fetchAll(PDO::FETCH_ASSOC);
        }
        //Т.к. во всех запросах кроме SELECT и всего что с ним связано нет смысла отображать таблицу
        //А количество столбцов, к которым применен запрос
        //Выведем вместо таблицы количество задействованных столбцов
        else
        {
            $otherQuery = $conn->prepare($query);
            $otherQueryToExec = $otherQuery->execute();
            $changedRowCount = $otherQuery->rowCount();
        }
    }
    catch(Exception $error)
    {
        $caughtError = $error->getMessage();
        echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($caughtError, true) . '</pre>';
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
            <?php if(empty($query)): ?> <!-- SELECT запрос -->
                <p>Запрос не обнаружен</p>
            <?php elseif(isset($caughtError)): ?>
                <p><h4>Запрос введен неверно</h4></p>
            <?php else: ?>
                <?php if(isset($queryToExec)): ?>
                    <table class="table table-hover">
                        <thead>
                            <h2>Результат запроса</h2>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($queryToExec as $key=>$value): ?> <!-- Вывод таблицы после SELECT -->
                            <?php foreach($value as $row=>$val): ?>
                                <td><?= $val ?></td>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                    <?php endif; ?>
                <?php endif; ?>
                <?php endif; ?>
        <?php if(isset($otherQueryToExec)): ?> <!-- Вывод количества измененных столбцов -->
            <?php print ("Изменено $changedRowCount столбцов") ?>
            <?php endif; ?>
    </div>
</div>
<?php require_once('source/footer.php'); ?>