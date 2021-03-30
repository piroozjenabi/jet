<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->library("Auto");
$list_type=$this->auto->list_subject_refer();
?>
<?= loadHeader(['title' => _KARTABL]) ?> 
<div class="row well">
    <div class="btn-group-lg">
        <a class="btn btn-info   " href="<?php echo site_url("/AUTO/kartable/") ?>"><i class="fa fa-list"> </i> <?php echo _ALL ?> </a>
        <?php foreach ($list_type as $key => $value): ?>
        <a class="btn <?php echo ($value["id"]==$subject_id)?"btn-danger":"btn-default"; ?>" href="<?php echo site_url("/AUTO/kartable/index/".$value["id"]) ?>"><i class="fa fa-list"> </i> <?php echo $value["name"] ?> </a>
        <?php endforeach; ?>

        <a class="btn btn-warning" href="<?php echo site_url("/AUTO/kartable/index/$subject_id/exited") ?>"><i class="fa fa-th"> </i> <?php echo _EXITED_FORM_KARTABLE ?> </a>

    </div>

</div>
    <table class="table table-hover table-striped dataTbl"  >
        <thead>
        <tr>
            <td>#</td>
            <td><?= _ID?></td>
            <td><?= _DES.__._REFER?></td>
            <td><?= _DATE.__._REFER?></td>
            <td><?= _REFER.__._FROM?></td>
            <td><?= _REFER_TO?></td>
            <td><?= _TYPE.__._FORM?></td>
            <td><?= _SUBJECT_REFER?></td>
            <td><?= _MORE_INFO?></td>

        </tr>
        </thead>
<tbody>
<?php
//for counter in table
$c=1;
foreach ($forms as $key => $value): ?>
    <tr id="row_<?php echo $value["id"]?>" <?= ($value['state']=="1")?"style='background:#80CBC4'":null; ?> ondblclick="load_ajax_popupfull('<?= site_url("AUTO/Manage/show_form") ?>','id=<?= $value["mainid"] ?>')">
    <?php
    $op=$this->auto->render_op_refer($value["id"], $type);
    $refer_id=$value["id"];
    $form_id=$value["form_value_id"];
    $main_id=$value["mainid"];
    $to_user_id=$value["to_user_id"];
    $f_id=$value["f_id"];
        ?>

        <td><?= $c; ?></td>
        <td><?= $value["form_value_id"] ?></td>
        <td><?= $value["des"] ?>
            <div class="btn-group hover_show col-sm-12">
                <?php foreach ($op as $key2): ?>
                    <a role="menuitem" tabindex="-1" href="#"> <?= $key2 ?></a>
                <?php endforeach; ?>
            </div>
        </td>
        <td><?= $this->piero_jdate->jdate("Y/m/d", $value["date"])  ?></td>
        <td><?= $this->system->get_user_admin_from_id($value["from_user_id"]) ?></td>
        <td><?= $this->system->get_user_admin_from_id($to_user_id) ?></td>
        <td><?= $this->auto->get_form_from_value_id($form_id)[0]["name"] ?></td>
        <td><?= $value["subject_name"] ?></td>
        <td><?= $this->auto->show_list($value["mainid"]) ?></td>

    </tr>
    <?php $c++;
endforeach; ?>
</tbody>
</table>
</div>
<?= $this->auto->render_op_refer_js(); ?>
