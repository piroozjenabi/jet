<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
 
$CI =& get_instance();
$CI->load->library("element");
echo  $CI->element->quick_add("MaLi/pprd/prd/padd_group", array("0"=>array("name"=>"name","placeholder"=>_NAME.__._GROUP.__._PRD , "type" => "input"),"1"=>array("name"=>"des","placeholder"=>_DES.__._GROUP.__._PRD , "type" => "input"))); ?>
<table class=" table table-hover table-striped"  >
    <thead>
    <tr>
        <td><?php echo _ID?></td>
        <td><?php echo _STATE?></td>
        <td><?php echo _NAME?></td>
        <td><?php echo _DES ?></td>
        <td><?php echo _FATHER ?></td>

    </tr>
    </thead>
    <?php foreach ($db as $key => $value):?>
    <tr>
    <td><?php echo $value["id"] ?></td>
    <td>
        <?php echo $this->element->edit_select_bool($value["id"], $value["state"], "prd_group", "state", "text") ?>
    </td>
    <td>
        <?php echo $this->element->edit_text($value["id"], $value["name"], "prd_group", "name", "text") ?>
    </td>
    <td>
        <?php echo $this->element->edit_text($value["id"], $value["des"], "prd_group", "des", "text") ?>
    </td>
    <td>
        <?php echo $this->element->edit_select_db($value["id"], $value["parent"], "prd_group", "parent", "text", array("db"=>"prd_group")) ?>

    </td>
    </tr>
    <?php endforeach; ?>
</table>
