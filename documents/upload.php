<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    if (!isset($_SESSION["isAdmin"])) {
        header("Location: /index.php/");
    }
}

require_once('../config/Database.php');

$db = new Database();
$conn = $db->getConnection();

if (isset($_GET["id"])) {
    $docID = $_GET["id"];
    $query = "SELECT number FROM document
            WHERE id = $docID";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $docNumber = $stmt[0]["number"];

}
$message = '';

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {

    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
        // опознать файл
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        // сделать имя файла уникальным, чтобы не было конфликтов
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // проверить, имеет ли файл одно из этих расширений
        $allowedFileExtensions = array('docx');

        if (in_array($fileExtension, $allowedFileExtensions)) {
            // директория, в которую будет сохранен файл
            $uploadFileDir = 'uploaded_files/';
            $dest_path = $uploadFileDir . $newFileName;

            if (isset($docNumber) && (move_uploaded_file($fileTmpPath, $dest_path))) {
                $fileName = preg_replace('/\..+$/u', '', $fileName); //отделить название от расширения файла
                $query = "INSERT INTO document (`number`, `file_path`, `file_name`, `file_extension`, `doc_ID`) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->execute([$docNumber, $dest_path, $fileName, $fileExtension, $docID]);

                $_POST["succUpload"] = true; //файл был успешно загружен
                header("refresh:1;url=documents_page.php"); //редирект на страницу с документами через секунду после загрузки файла

            } else {
                $_POST["wrongDir"] = true; //проблемы с указанным путем для загрузки
            }
        } else {
            $message = implode(',', $allowedFileExtensions);
            $_POST["wrongExtension"] = $message; //недопустимое расширение файла
        }
    } else {
        $message .= 'Error:' . $_FILES['uploadedFile']['error'];
        $_POST["uplError"] = $message;  //прочие ошибки загрузки
    }
}
?>
<?php require_once('../source/header.php'); ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
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
                                <br>
                                Поддерживаемые форматы файлов: <?php echo $message; ?>
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
                                <br>
                                https://www.php.net/manual/en/features.file-upload.errors.php"
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
    <!-- Crop modal -->
    <div class="container" align="center">
        <div class="row">
            <div class="col-md-4">&nbsp;</div>
            <div class="col-md-4">
                <div class="image_area">
                    <form method="post">
                        <label for="upload_image">
                            <button class="btn btn-primary" id="uploaded_image" class="img-responsive img-circle">Загрузить фото</button>
                            <div class="overlay">
                                <div class="text">Click to Change Profile Image</div>
                            </div>
                            <input type="file" name="image" class="image" id="upload_image" style="display:none"/>
                        </label>
                    </form>
                </div>
            </div>
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Кадрирование фото</h5>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <img src="" id="sample_image"/>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="crop" class="btn btn-primary">Применить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                var $modal = $('#modal');
                var image = document.getElementById('sample_image');
                var cropper;

                $('#upload_image').change(function (event) {
                    var files = event.target.files;

                    var done = function (url) {
                        image.src = url;
                        $modal.modal('show');
                    };

                    if (files && files.length > 0) {
                        reader = new FileReader();
                        reader.onload = function (event) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(files[0]);
                    }
                });

                $modal.on('shown.bs.modal', function () {
                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 3,
                        preview: '.preview'
                    });
                }).on('hidden.bs.modal', function () {
                    cropper.destroy();
                    cropper = null;
                });

                $('#crop').click(function () {
                    canvas = cropper.getCroppedCanvas({
                        width: 400,
                        height: 400
                    });

                    canvas.toBlob(function (blob) {
                        url = URL.createObjectURL(blob);
                        var reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function () {
                            var base64data = reader.result;
                            $.ajax({
                                url: 'crop.php',
                                method: 'POST',
                                data: {image: base64data},
                                success: function (data) {
                                    $modal.modal('hide');
                                    $('#uploaded_image').attr('src', data);
                                }
                            });
                        };
                    });
                });

            });
        </script>
<?php require_once('../source/footer.php'); ?>