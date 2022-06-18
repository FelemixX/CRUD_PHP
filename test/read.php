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
                <td>
                    <a data-bs-toggle="modal" data-bs-target="#myModal" data-update="<?= $client["id"] ?>" class="btn btn-outline-success update">Изменить</>
                    <a data-delete="<?= $client["id"] ?>" class="btn btn-outline-danger delete">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>
    <a class="btn btn-primary" href='create.php'>Создать</a>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        let update = $('.update');
        let del = $('.delete');

        update.click(function () {
            let updateId = $(this).data("update");
            let modalBody = $('#modalBody');
            $.ajax({
                type: 'GET',
                url: 'update.php',
                dataType: 'html',
                data: {
                    id: updateId,
                },
                success: function (data) {
                    modalBody.html(data); //updateID - ID клиента которого обновляем

                    let saveBtn = $("#save" + updateId);
                    let ddata = {};

                    saveBtn.click(function () {
                        $("#modalBody :input").each(function(){
                            if ($(this).val() !== "")
                            {
                                ddata[$(this).attr('name')] = $(this).val()
                            }
                        });
                        console.log(ddata);
                        $.ajax({
                            type: 'POST',
                            url: 'update.php',
                            dataType:'json',
                            data: {
                                updateData: ddata,
                            },
                            success: function () {
                            }
                        });
                    })
                }
            });
        })
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
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modalBody" class="modal-body">
            </div>

        </div>
    </div>
</div>