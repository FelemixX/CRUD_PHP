<?php require_once('../source/header.php') ?>
<div>
    <h1 class="text-center">Это тест говнища</h1>
    <p id="trigger">triggered</p>
    <div id="test">
        <p>Пожилой глэк вещает</p>
    </div>
</div>
<script type="text/javascript">
    let trig = $('#trigger');
    let counter = 0;
    trig.click(function () {
        $.ajax({
            type: 'GET',
            url: 'babaji.php',
            data: {
                sex: 'chlen',
            },
            dataType: 'html',
            success: function (data) {
                let test = $('#test');
                test.append(data);
                //document.getElementById("test").innerHTML = data;
            }
        })
    });
</script>