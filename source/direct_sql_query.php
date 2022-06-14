<?php
require_once('../source/Database.php');
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['user_query'])) {
    //Проверка на правильность введенного запроса
    try {
        $query = $_GET['user_query'];

        if (str_contains($query, 'SELECT') || str_contains($query, 'select'))    //Обработка SELECT запроса
        {
            /* Выполнить запрос */
            $queryToExec = $conn->prepare($query);
            $queryToExec->execute();
            $queryToExec = $queryToExec->fetchAll(PDO::FETCH_ASSOC);
        }
        //Т.к. во всех запросах кроме SELECT и всего что с ним связано нет смысла отображать таблицу
        //А количество столбцов, к которым применен запрос
        //Выведем вместо таблицы количество задействованных столбцов
        else {
            $otherQuery = $conn->prepare($query);
            $otherQueryToExec = $otherQuery->execute();
            $changedRowCount = $otherQuery->rowCount();
        }
    } catch (Exception $error) {
        $caughtError = $error->getMessage();
    }
}
?>

<?php require_once('header.php'); ?>
    <div class="d-flex p-2 bd-highlight"></div>
    <div class="d-flex justify-content-center">
        <div>
            <h4>Отправить SQL Запрос</h4>
            <form class="mb-2" method="get" action="direct_sql_query.php">
                <input class="form-control" required name="user_query" type="text"/>
                <br>
                <button type="submit" class="btn btn-primary" name="user_id">Отправить</button>
            </form>
            <?php if (isset($_GET['user_query'])): ?>
                <?php if (empty($query)): ?> <!-- SELECT запрос -->
                    <p>Запрос не обнаружен</p>
                <?php elseif (isset($caughtError)): ?>
                    <p><h4>Запрос введен неверно</h4></p>
                <?php else: ?>
                    <?php if (isset($queryToExec)): ?>
                        <table class="table table-hover">
                            <thead>
                            <h2>Результат запроса</h2>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($queryToExec as $key => $value): ?> <!-- Вывод таблицы после SELECT -->
                                <?php foreach ($value as $row => $val): ?>
                                    <td><?= $val ?></td>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (isset($otherQueryToExec)): ?> <!-- Вывод количества измененных столбцов -->
                <?php print ("Изменено $changedRowCount столбцов") ?>
            <?php endif; ?>
        </div>
    </div>
<?php require_once('footer.php'); ?>