<?php
session_start();
if (!isset($_SESSION["usedId"])) {
    if (!isset($_SESSION["isAdmin"])) {
        header("Location: /index.php/");
    }
}
require_once('../tables/document.php');
require_once('../config/Database.php');
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET["deleteID"])) {
    $deleteID = $_GET["deleteID"];
    require_once('../tables/document.php');
    $document = new Document($conn);
    $document->id = $deleteID;

    if ($document->delete()) {
        header("Location: view.php");
    }
}

$documents = new Document($conn);
$query = "SELECT * FROM document WHERE client_ID IS NULL";
$readDocument = $conn->prepare($query);
$readDocument->execute();
$readDocument = $readDocument->fetchAll(PDO::FETCH_ASSOC);

function readZippedXML($archiveFile, $dataFile)
{
// Сделать архив
    $zip = new ZipArchive;
// Открыть полученный архив
    if ($zip->open($archiveFile)) {
        // Если выполнено успешно, то ищем файл в архиве
        if (($index = $zip->locateName($dataFile)) !== false) {
            // Если нашли, то читаем в строке
            $data = $zip->getFromIndex($index);
            // Закрываем архив
            $zip->close();
            // Загружаем XML, привязанный к docx файл
            $xml = new DOMDocument();
            $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            // Убираем из текста теги XML
            return strip_tags($xml->saveXML());
        }
        $zip->close();
    }
// Если считать ничего не получилось, то вернем пустую строку
    return "";
}

if (isset($_GET["openBtn"])) {
    $id = $_GET["openBtn"];
    $query = "SELECT file_path, file_extension FROM document WHERE doc_ID = $id";
    $getFileInfo = $conn->prepare($query);
    $getFileInfo->execute();
    $file = $getFileInfo->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php require_once('../source/header.php'); ?>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID файла</th>
                <th scope="col">ID документа</th>
                <th scope="col">Название</th>
                <th scope="col">Тип</th>
                <th scope="col">Номер документа</th>
                <th scope="col">Действие</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($readDocument as $document): ?>
            <tr>
                <td><?= $document["id"] ?></td>
                <td><?= $document["doc_ID"] ?></td>
                <td><?= $document["file_name"] ?></td>
                <td><?= $document["file_extension"] ?></td>
                <td><?= $document["number"] ?></td>
                <td>
                    <form method="get">
                        <button type="submit" class="btn btn-outline-info" name="openBtn"
                                value="<?= $document["doc_ID"] ?>">Открыть
                        </button>
                    </form>
                    <a class="btn btn-outline-danger" href='view.php?deleteID=<?= $document["id"] ?>'>Удалить</a>
                </td>
                <?php endforeach; ?>
            </tr>
            </tbody>
        </table>
    </div>
<?php if (isset($file)): ?>
    <?php if ($file[0]["file_extension"] === 'jpg'): ?>
        <div class="text-center">
            <img src="<?= $file[0]["file_path"] ?>" width="500" height="600">
        </div>
    <?php else: ?>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row"><?= $reader = readZippedXML($file[0]["file_path"], "word/document.xml"); ?></th>
                </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php require_once('../source/footer.php'); ?>