<?php
require_once('../config/Database.php');

$db = new Database();
$conn = $db->getConnection();

if (isset($_POST["id"])) {
    $docID = $_POST["id"];
    $query = "SELECT number FROM document
            WHERE id = $docID";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $docNumber = $stmt[0]["number"];
}
    if (isset($_POST['image'])) {
        $receivedImage = $_POST['image'];

        $imageArray = explode(";", $receivedImage);
        $imageArray = explode(",", $imageArray[1]);
        $decodedImage = base64_decode($imageArray[1]);
        //$image_name = 'croppedImg' . time() . '.png';
        $newFileName = md5(time() . $decodedImage) . '.' . 'jpg';
        $fileExtension = preg_replace('/^.*\.([^.]+)$/D', '$1', $newFileName);
        $fileName = preg_replace('/\..+$/u', '', $newFileName); //отделить название от расширения файла
        $uploadFileDir = "uploaded_files/";
        $destPath = $uploadFileDir . $newFileName;
        file_put_contents($newFileName, $decodedImage);
        if (rename($newFileName,$uploadFileDir . $newFileName)) {

            $query = "INSERT INTO document (`number`, `file_path`, `file_name`, `file_extension`, `doc_ID`)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$docNumber, $destPath, $fileName, $fileExtension, $docID]);
        }

    }
?>