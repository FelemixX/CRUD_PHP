<?php
require_once('../tables/client.php');
require_once('../config/Database.php');

$db = new Database();
$conn = $db->getConnection();

$client = new Client($conn);
$readClients = $client->read("");
?>
<div class="container">
    <h1>Список клиентов</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th id="Id" scope="col">ID Клиента</th>
            <th id="First_Name" scope="col">Фамилия</th>
            <th id="Second_Name" scope="col">Имя</th>
            <th id="Third_Name" scope="col">Отчество</th>
            <th id="Date" scope="col">Дата рождения</th>
            <th scope="col">Действие с клиентами</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($readClients as $client): ?>
            <tr id="<?= $client["id"] ?>">
                <td><?= $client["id"] ?></td>
                <td><?= $client["first_name"] ?></td>
                <td><?= $client["second_name"] ?></td>
                <td><?= $client["third_name"] ?></td>
                <td><?= $client["birth_date"] ?></td>
                <td> <!-- Update and delete buttons for existing clients -->
                    <a data-bs-toggle="modal" data-bs-target="#myModal" data-update="<?= $client["id"] ?>"
                       class="btn btn-outline-success update">Изменить</a>
                    <a data-delete="<?= $client["id"] ?>" class="btn btn-outline-danger delete">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a data-bs-toggle="modal" data-bs-target="#creationModal"
       class="btn btn-primary create">Создать</a>
</div>
<!-- Modal for updating existing clients -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Редактирование клиента</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modalBody" class="modal-body">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        let update = $('.update');

        update.click(function () {
            let modalBody = $('#modalBody');
            let updateID = $(this).data("update");
            $.ajax({
                type: 'GET',
                url: 'update.php',
                dataType: 'html',
                data: {
                    id: updateID,
                },
                success: function (data) {
                    modalBody.html(data);
                    let saveBtn = $("#save" + updateID);
                    let updData = {};
                    saveBtn.click(function (){
                        $("#modalBody:input").each(function(){
                            if ($(this).val() !== "") {
                                updData[$(this).attr('name')] = $(this).val();
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: 'update.php',
                            data: {
                                updateData: updData,
                            },
                            success: function () {
                                location.reload();
                            }
                        })
                    })
                }
            })
        });
    })

    $(document).ready(function () {
        let del = $('.delete');
        del.click(function () {
            $.ajax({
                type: 'GET',
                url: 'delete.php',
                dataType: 'json',
                data: {
                    deleteID: $(this).data("delete"),
                },
                success: function (data) {
                    let deleteID = data["id"];
                    let element = $('#' + deleteID);
                    element.remove();
                }
            })
        });
    })
</script>

<!-- Modal for creating new clients -->
<div class="modal fade" id="creationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создание клиента</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="creationModalBody" class="modal-body">

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let create = $('.create');

        create.click(function () {
            let modalBody = $('#creationModalBody');
            let createID = $(this).data("create");
            $.ajax({
                type: 'GET',
                url: 'create.php',
                dataType: 'html',
                data: {
                    id: createID,
                },
                success: function (data) {
                    modalBody.html(data);
                    let createBtn = $("#create");
                    let crtData = {};
                    createBtn.click(function (){
                        $("#creationModalBody :input").each(function(){
                            if ($(this).val() !== "") {
                                crtData[$(this).attr('name')] = $(this).val();
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: 'create.php',
                            data: {
                              createData: crtData,
                            },
                            success: function () {
                                location.reload();
                            }
                        })
                    })
                }
            })
        });
    })
</script>


