<div class="mb-3">
    <label for="formFile" class="form-label">Загрузить файл</label>
    <input name="toUpload" class="form-control" type="file" id="formFile">
</div>
<div class="text-center">
    <button type="submit" class="btn btn-primary" id="upload">Загрузить</button>
</div>

<a data-bs-toggle="modal" data-bs-target="#myModal"
   data-upload="<?= $document["id"] ?>" class="btn btn-outline-info upload">Загрузить</a>