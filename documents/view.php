<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    if (!isset($_SESSION["isAdmin"])) {
        header("Location: /index.php/");
    }
}

require_once('../config/Database.php');
require_once('../tables/document.php');

?>
<?php require_once('../source/header.php'); ?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID файла</th>
            <th scope="col">Название</th>
            <th scope="col">Тип</th>
            <th scope="col">Номер документа</th>
            <th scope="col">Имя клиента</th>
            <th scope="col">Действие</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <a class="btn btn-outline-info">Открыть</a>
            </td>
        </tr>
        </tbody>
    </table>
<?php require_once('../source/footer.php'); ?>