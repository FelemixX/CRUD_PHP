<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
    <title>Документы</title>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-nav-scroll navbar-expand-lg navbar-light bg-light ">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php/">Главная</a>
            <?php if (isset($_SESSION["usedId"])): ?>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                               href="../clients/clients_page.php">Клиенты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../documents/documents_page.php">Документы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                               href="../products/products_page.php">Товары</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                               href="../debts/debts_page.php">Задолженности</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                               href="../documents_products_clients/documents_products_clients_page.php">Документ -
                                клиент - товар</a>
                        </li>
                        <?php if (isset($_SESSION["isAdmin"])): ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../source/direct_sql_query.php">Запрос
                                    к БД</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../auth/logout.php">Выйти</a>
                        </li>

                        <?php if (isset($_SESSION["isAdmin"])): ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../auth/logout.php">Admin</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </nav>
