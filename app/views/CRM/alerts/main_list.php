<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?=loadHeader(['title' => _ALERT . _S])?>
<?php if(count($db)): ?>
<table class="table table-hover table-striped dataTbl" >
   <thead>
   <th>
        <td><?=_DATE?></td>
        <td><?=_ALERT?></td>
        <td></td>
        <td></td>
    </th>
   </thead>

    <tbody>
    <?php foreach ($db as $key => $value):
    $value['color'] = ($value['readed'] == 0) ? $value['color'] : "";
    ?>
        <tr style="background-color: <?=$value['color'];?>" id="row-<?=$value["id"]?>" >
            <td> <?=printDate($value['date']);?></td>
            <td> <?=$this->element->edit_text($value["id"], $value["message"], "alerts", "message", "text")?></td>
            <td> <?=$value['actions'];?> </td>
            <td>
            <?php if ($value["readed"] == 0): ?>
            <a class='btn btn-info' onclick="read(<?= $value["id"] ?>)" id="btn-<?=$value["id"]?>" > <i class="fa fa-check" ></i> <?=_SEED?> </a>
            <?php endif;?>
            <a class='btn btn-danger' "<a class='btn btn-danger' onclick="piero_confirm(del,<?=$value["id"]?>)"  > <i class="fa fa-close" ></i> <?=_DELETE?> </a>
            </td>
        </tr>
    <?php endforeach;?>
</tbody>
</table>

<script type="text/javascript">
    // function for  ajax
    function read(_id) {
            $.ajax({
                url : "<?=site_url("/CRM/alerts/read_alert/")?>",
                type: "POST",
                dataType: "JSON",
                "data": "id="+_id,
                success: function(data)
                {
                    if(data.status)
                    {
                        piero_message();
                        $("#btn-"+_id).hide();
                        $("#row-"+_id).css("background","#fff");
                    }
                    else
                    {
                        piero_alert();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    piero_alert("<?=_ERROR?>","<?=_ERROR_AJAX?>");
                }
            });
    }

    //delete aleret
    function del(_id) {
        $.ajax({
            url : "<?=site_url("/CRM/alerts/delete/")?>",
            type: "POST",
            dataType: "JSON",
            "data": "id="+_id,
            success: function(data)
            {
                if(data.status)
                {
                    piero_message();
                    $("#row-"+_id).hide(500);
                }
                else
                {
                    piero_alert();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                piero_alert("<?=_ERROR?>","<?=_ERROR_AJAX?>");
            }
        });
    }
</script>
<?php else: ?>
    <p class='alert alert-danger' > <?= _ALERT_NOT_FOUND ?></p>
<?php endif?>

