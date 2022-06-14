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
    <style>
        .gradient-text {
            font-family: 'Rubik One', sans-serif;
            text-transform: uppercase;
            font-size: 20px;
            background: linear-gradient(30deg, #D12229, #F68A1E, #FDE01A, #007940, #24408E, #732982);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #0B2349;
        }
    </style>
    <title>Документы</title>
</head>
<body>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
</svg>
<div class="container">
    <nav class="navbar navbar-nav-scroll navbar-expand-lg navbar-light bg-light ">
        <div class="gradient">
            <div class="container-fluid">
                <?php if (isset($_SESSION["usedId"])): ?>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="btn" aria-current="page"
                                   href="../clients/clients_page.php">Клиенты</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn" aria-current="page" href="../documents/documents_page.php">Документы</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn" aria-current="page"
                                   href="../products/products_page.php">Товары</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn" aria-current="page"
                                   href="../debts/debts_page.php">Задолженности</a>
                            </li>
                            <?php if (isset($_SESSION["isAdmin"])): ?>
                                <li class="nav-item">
                                    <a class="btn" aria-current="page"
                                       href="../users/users_page.php">Список пользователей</a>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION["isAdmin"])): ?>
                                <li class="nav-item">
                                    <a class="btn" aria-current="page" href="../source/direct_sql_query.php">Запрос
                                        к БД</a>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION["userName"])): ?>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page"><?= $_SESSION["userName"] ?></a>
                                </li>
                                <?php if (isset($_SESSION["isAdmin"])): ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page"><strong class="gradient-text">ADMIN</strong></a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item">
                                    <a class="btn btn-danger" aria-current="page" href="../auth/logout.php">Выйти</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
    </nav>
