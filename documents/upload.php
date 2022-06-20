<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    if(!isset($_SESSION["isAdmin"])) {
        header("Location: /index.php/");
    }
}

require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();

$message = '';

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {

    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
        // get details of the uploaded file
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // sanitize file-name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // check if file has one of the following extensions
        $allowedFileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');

        if (in_array($fileExtension, $allowedFileExtensions)) {
            // directory in which the uploaded file will be moved
            $uploadFileDir = 'uploaded_files/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
//                $message = 'File is successfully uploaded.';
                $_POST["succUpload"] = true;
            } else {
//                $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                $_POST["wrongDir"] = true;
            }
        } else {
            $message = implode(',', $allowedFileExtensions);
            $_POST["wrongExtension"] = $message;
        }
    } else {
//        $message = 'There is some error in the file upload. Please check the following error.<br>';
        $message .= 'Error:' . $_FILES['uploadedFile']['error'];
        $_POST["uplError"] = $message;
    }
    $_SERVER["redirect"] = true;
}
?>
<?php require_once('../source/header.php'); ?>
    <form method="post" action="upload.php" enctype="multipart/form-data">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="mb-3">
                    <label for="formFile" class="form-label"><h3>Загрузить файл</h3></label>
                    <input class="form-control" type="file" id="uploadedFile" name="uploadedFile">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="mb-2 btn btn-primary" name="uploadBtn" value="Upload">Загрузить</button>
            </div>
            <div class="container">
                <div class="d-flex justify-content-center">
                        <?php if (isset($_POST["succUpload"])): ?>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                     aria-label="Success:">
                                    <use xlink:href="#check-circle-fill"/>
                                </svg>
                                <div>
                                    Успешно! Файл загружен!
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_POST["wrongDir"])): ?>
                            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
                                 role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                     aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill"/>
                                </svg>
                                <div>
                                    Ошибка! Неверная директория для сохранения файла!
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_POST["wrongExtension"])): ?>
                            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
                                 role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                     aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill"/>
                                </svg>
                                <div>
                                    Ошибка! Неподдерживаемый формат файлов!
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_POST["uplError"])): ?>
                            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mt-3"
                                 role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                     aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill"/>
                                </svg>
                                <div>
                                    Ошибка при загрузке!
                                    <br>
                                    <?php echo $_POST["uplError"]; ?>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    </form>
<?php require_once('../source/footer.php'); ?>