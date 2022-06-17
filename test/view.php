<?php require_once('../source/header.php') ?>
<form id="test">
</form>
<?php require_once('../source/footer.php') ?>
<script type="text/javascript">
    $.ajax({
        type: 'GET',
        url: 'read.php',
        dataType: 'html',
        success: function (data) {
            let test = $('#test');
            test.html(data);
        }
    });
</script>