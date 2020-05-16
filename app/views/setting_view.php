<?php defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$CI->load->library("element");
?>
<table class="table table-hover table-striped dataTbl" id="datatable" >
    <thead >
    <tr >
        <td><?php echo _ID ?></td>
        <td><?php echo _NAME ?></td>
        <td><?php echo _DES ?></td>
        <td><?php echo _VALUE ?></td>
    </tr>
    </thead>
    <?php foreach ($db as $key => $value): ?>
        <tr>
            <td><?php echo $value["id"] ?>  </td>
            <td><?php echo $value["name"] ?></td>
            <td><?php echo $value["des"] ?> </td>
            <td>
                <?php $tmp_jsn = json_decode($value["type"]);$tmp_typ = "edit_" . $tmp_jsn->type;?>
                <?php echo $this->element->$tmp_typ($value["id"], $value["value"], "setting", "value", "text") ?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=$this->template->load_static_datatable_js()?>
