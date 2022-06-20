<?php

?>
<?php require_once('../source/header.php'); ?>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="mb-3">
                <label for="formFile" class="form-label"><h3>Загрузить файл</h3></label>
                <input class="form-control" type="file" id="formFile">
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary" id="upload">Загрузить</button>
        </div>
    </div>
<?php require_once('../source/footer.php'); ?>