<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    header("Location: /index.php/");
} ?>

<?php require_once('../source/header.php') ?>
<form id="mainTable">

</form>
<?php require_once('../source/footer.php') ?>
<script type="text/javascript">
    $.ajax({
        type: 'GET',
        url: 'read.php',
        dataType: 'html',
        success: function (data) {
            let test = $('#mainTable');
            test.html(data);
        }
    });
</script>
