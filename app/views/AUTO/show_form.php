<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$radif=0;
//print_r($detail_factor);
$CI =& get_instance();
$CI->load->library('Auto');
$detail_form=$CI->auto->get_form_from_id($form_id);
$refer=$this->auto->list_refer_from_id($form_id);
$history=$this->auto->get_history($form_id);
$detail_form[0]["mainid"]= $detail_form[0]["id"];
$detail_form[0]["f_id"]= $detail_form[0]["form_id"];
$op=$CI->auto->render_op_form($detail_form[0],"btn btn-default");
?>
<center>
    <?php foreach ( $op as $key => $value)
        echo $value;
        ?>
</center>
<hr>
<br>
<div class="row well  " >
    <div class="col-sm-3">    <?= _MAKER ?> :<?= $this->system->get_user_admin_from_id($detail_form[0]["maker_id"],"name")  ?></div>
    <div class="col-sm-3">   <?= _DATE.__._MAKE?> : <?= printDate($detail_form[0]["date"]);  ?></div>
    <div class="col-sm-2">   <?= _NUMBER.__._FORM ?> :<?= $detail_form[0]["id"] ?> </div>
    <div class="col-sm-2">   <?= _EDIT?> : <?= (isset($detail_form[0]["modify_date"]))?printDate($detail_form[0]["modify_date"]):null  ?></div>
    <div class="col-sm-2">    <?= _EDITOR ?> :<?= (isset($detail_form[0]["modifire_id"]))?$this->system->get_user_admin_from_id($detail_form[0]["modifire_id"],"name"):null  ?></div>

</div>
<div class="row well col-sm-12">
<?=$view_form ?>
</div>
<h3><?= _LIST.__._REFER._S ?> </h3>
<div class="row well">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
        <td> <i class="fa fa-list"></i> </td>
        <td><?= _FROM ?></td>
        <td><?= _REFER_TO ?></td>
        <td><?= _DATE ?></td>
        <td><?= _DES ?></td>
        <td><?= _STATE ?></td>
        <td><?= _ACCEPTER ?></td>
        <td><?= _DATE_ACCEPT ?></td>
        <td><?= _REJECTER ?></td>
        <td><?= _DATE_REJECT ?></td>
        <td><?= _DES_REJECT ?></td>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($refer as $key => $value):
           $tmp= (isset($value["params"]))?json_decode($value["params"]):null;
            $op=$CI->auto->render_op_refer($value["id"],null,"btn btn-link");

            ?>
        <tr id="row_<?= $value["id"] ?>">
            <td>
                <?= $this->element->drop_down_menu($op) ?>
            </td>
            <td> <?=$this->system->get_user_admin_from_id($value["from_user_id"])  ?> </td>
            <td> <?=$this->system->get_user_admin_from_id($value["to_user_id"])  ?> </td>
            <td> <?= printDate($value["date"])  ?> </td>
            <td> <?= $value["des"] ?> </td>
            <td> <?= $CI->auto->print_state ($value["state"]) ?> </td>
            <td> <?= (isset($tmp->user_accept))?$this->system->get_user_admin_from_id($tmp->user_accept):null  ?> </td>
            <td> <?= (isset($tmp->date_accept))?printDate($tmp->date_accept):null  ?> </td>
            <td> <?= (isset($tmp->user_reject))?$this->system->get_user_admin_from_id($tmp->user_reject):null  ?> </td>
            <td> <?= (isset($tmp->date_reject))?printDate($tmp->date_reject):null  ?> </td>
            <td> <?= (isset($tmp->des_reject))?$tmp->des_reject:null  ?> </td>

        </tr>

        <?php endforeach; ?>
        </tbody>
    </table>


</div>
<button class="btn btn-default btn-block" onclick="$('#history').slideToggle(1000)"> <i class="fa fa-clock-o"></i> <?= _HISTORY_FORM ?></button>
<div class="row well" id="history" style="display: none;">
    <table class="table table-hover table-striped"  >
        <thead >
        <tr>
            <td><?= _USER ?></td>
            <td><?= _DATE ?></td>
            <td><?= _OP ?></td>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $key => $value): ?>
                <tr>
                <td> <?=$this->system->get_user_admin_from_id($value["user_id"])  ?></td>
                <td> <?=printDate($value["date"])  ?> </td>
                <td> <?=$CI->auto->get_auto_history_type($value["type"])  ?> </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div>
<?= $CI->auto->render_op_refer_js(); ?>
<?= $CI->auto->render_op_form_js(); ?>
