<?php
session_start();
require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();
$message = '';
echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . print_r($_POST, true) . '</pre>';
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload')
{
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
    {
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
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');

        if (in_array($fileExtension, $allowedfileExtensions))
        {
            // directory in which the uploaded file will be moved
            $uploadFileDir = '/uploaded_files';
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path))
            {
                $message ='File is successfully uploaded.';
            }
            else
            {
                $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
            }
        }
        else
        {
            $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        }
    }
    else
    {
        $message = 'There is some error in the file upload. Please check the following error.<br>';
        $message .= 'Error:' . $_FILES['uploadedFile']['error'];
    }
}
?>
<?php require_once('../source/header.php'); ?>
    <form method="post" action="upload.php" enctype="multipart/form-data">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="mb-3">
                    <label for="formFile" class="form-label"><h3>Загрузить файл</h3></label>
                    <input class="form-control" type="file" id="uploadForm" name="uploadedFile">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" name="uploadBtn" value="Upload">Загрузить</button>
            </div>
        </div>
    </form>
<?php require_once('../source/footer.php'); ?>