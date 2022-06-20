<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
}

require_once('../config/Database.php');
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
            //echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($queryToExec, true) . '</pre>';
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
        $_POST["wrongQuery"] = true;
    }
}
?>

<?php require_once('header.php'); ?>
    <div class="mt-5 d-flex justify-content-center">
        <div>
            <h4 class="mb-2">Отправить SQL Запрос</h4>
            <form method="get" action="direct_sql_query.php">
                <input class="form-control" required name="user_query" type="text"/>
                <div class="text-center">
                    <button type="submit" class="mt-2 btn btn-primary" name="user_id">Отправить</button>
                </div>
            </form>
            <?php if (isset($_GET['user_query'])): ?>
                <?php if (empty($query)): ?> <!-- SELECT запрос -->
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
                         role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                            <use xlink:href="#exclamation-triangle-fill"/>
                        </svg>
                        <div>
                            Ошибка! Введите запрос и попробуйте еще раз.
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (isset($_POST["wrongQuery"])): ?>
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
                         role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                            <use xlink:href="#exclamation-triangle-fill"/>
                        </svg>
                        <div>
                            Ошибка! Запрос введен неверно.
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php else: ?>
                    <?php if (isset($queryToExec)): ?>
                        <table class="table table-hover">
                            <thead>
                            <h2>Результат запроса</h2>
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