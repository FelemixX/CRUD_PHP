<?php
if(isset($_GET["id"]))
{
    $id = $_GET["id"];
}

if(isset($_GET["deleteID"]))
{
    $deleteID = $_GET["deleteID"];
    $conn = null;
    try
    {
        $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
    } catch (PDOException $exception)
    {
        echo "Ошибка подключения к БД!: " . $exception->getMessage();
    }
    require_once('../tables/debt.php');
    $debt = new Debt($conn);
    $debt->id = $deleteID;
    if($debt->delete())
    {
        header("Location: ../source/debts_page.php");
    }
}

if(isset($_POST["id"]) && isset($_POST["p_name"]) && isset($_POST["quantity"]))
{
    $postID = $_POST["id"];
    $totalDebt = $_POST["debt"];
    $paidDebt = $_POST["paid_debt"];
    $unpaidDebt = $_POST["unpaid_debt"];

    $conn = null;

    try
    {
        $conn = new PDO("mysql:host=" . "localhost:3366" . ";dbname=" . "debts_docs_payments", "root", "");
    } catch (PDOException $exception)
    {
        echo "Ошибка подключения к БД!: " . $exception->getMessage();
    }
    require_once('../tables/debt.php');
    $debt = new Debt($conn);
    $debt->debt = $totalDebt;
    $debt->paidDebt = $paidDebt;
    $debt->unpaidDebt = $unpaidDebt;
    $debt->id = $postID;
    if($debt->update())
    {
        header("Location: ../source/debts_page.php");
    }
}
?>

<?php require_once ('../source/header.php'); ?>
<form action="update.php" method="post">
    <input class="invisible" name="id" value="<?=$id?>">
    <div class="mb-3">
        <label for="debt" class="form-label">Долг</label>
        <input required name="debt" type="number" class="form-control" id="debt">
    </div>
    <div class="mb-3">
        <label for="paid_debt" class="form-label">Оплаченный долг</label>
        <input required name="paid_debt" type="number" class="form-control" id="paid_debt">
    </div>
    <div class="mb-3">
        <label for="unpaid_debt" class="form-label">Неоплаченный долг</label>
        <input required name="unpaid_debt" type="number" class="form-control" id="unpaid_debt">
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
    <a href="../source/debts_page.php">Отмена</a>
</form>
<?php require_once ('../source/footer.php'); ?>
