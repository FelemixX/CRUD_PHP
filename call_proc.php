<?php
$conn = null;
try
{
    $conn = new PDO("mysql:host=" . "localhost:3306" . ";dbname=" . "debts_docs_payments", "root", "root");
} catch (PDOException $exception)
{
    echo "Ошибка подключения к БД!: " . $exception->getMessage();
}

$query = "CALL update_debt()";

$stmt = $conn->prepare($query);
$stmt->execute();
header("Location: debts/debts_page.php/");