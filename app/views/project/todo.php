<?php defined('BASEPATH') or exit('No direct script access allowed');
if ($msg): ?>
<script> $(function(){
    <?=($msg[0]) ? "piero_message('{$msg[1]}')" : "piero_error('{$msg[1]}')"?> ;
    load_ajax_popup('<?=site_url("Project/todolist")?>','id=<?=$id?>');
    })
</script>
<?php endif;?>
<div class="row well">
<form class="col-sm-12 form-inline" id=formTodo>
        <input type="text" class="form-control" style="width:100%" name="todo" required placeholder="<?=_NAME_TODO?>">
        <input type="hidden" name="id" value="<?=$id?>" />
        <button class="btn btn-success btn-block"><i class='fa fa-plus'> </i> <?=_ADD?></button>
    </form>
    </div>
<br />
<div id="loadingtodo" class="loading" style="display:none;position:fixed;top:30%;left:45%"></div>
<div class="row well">
<table class="table-striped" style="width:100%">
    <?php foreach ($db as $key => $value): ?>
    <tr>
        <td style='<?= ($value->done)?"text-decoration: line-through;opacity:.7":null?>'>
        <?=$value->name?></td>
        <td style="text-align:left">
        <div class="btn-group">
            <!-- <button  class="btn btn-default "><i class='fa fa-eye'>  </i> </button> -->
            <?php if(!$value->done): ?><button  class="btn btn-success" onclick="setDone(<?= $value->id ?>)" ><i class='fa fa-check'></i> </button> <?php endif;?>
            <button  class="btn btn-danger" onclick="deleteTodo(<?= $value->id ?>)"><i class='fa fa-close'></i> </button>
        </div>
        </td>
    </tr>
    <?php endforeach;?>.
    </table>
</div>
<br />


<?=$this->element->load_ajax_submit("#formTodo", "Project/todolist")?>
<script type="text/javascript">

    function setDone(_id){
        $.ajax({
            url: "<?=site_url("project/op_todo/done/")?>"+_id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                     if (data.status == true) {
                        if (data.mes) piero_message("", data.mes)
                        else piero_message();
                        load_ajax_popup('<?=site_url("Project/todolist")?>','id=<?=$id?>');

                    } else {
                        if (data.error) piero_message("", data.error)
                        else piero_alert();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    piero_alert("<?=_ERROR?>", "<?=_ERROR_AJAX?>");
                }
            });
    }
    function deleteTodo(_id){
        $.ajax({
            url: "<?=site_url("project/op_todo/delete/")?>"+_id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                     if (data.status == true) {
                        if (data.mes) piero_message("", data.mes)
                        else piero_message();
                        load_ajax_popup('<?=site_url("Project/todolist")?>','id=<?=$id?>');

                    } else {
                        if (data.error) piero_message("", data.error)
                        else piero_alert();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    piero_alert("<?=_ERROR?>", "<?=_ERROR_AJAX?>");
                }
            });
    }

</script>