<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$CI =& get_instance();
$CI->load->library("element");
$CI->load->library("auto");
echo  $CI->element->quick_add("AUTO/manage_form/Manage/padd_field/".$form_id, array("0"=>array("name"=>"name","placeholder"=>_NAME.__._FIELD ."[EN]", "type" => "input"),"1"=>array("name"=>"des","placeholder"=>_DES.__._FIELD , "type" => "input"),"2"=>array("name"=>"type","data" =>$this->auto->list_elements(), "type" => "dropdown"),"3"=>array("name"=>"order_by","placeholder"=>_ORDER_BY , "type" => "input"),"4"=>array("name"=>"show_list","data" =>array(0=>_FALSE,1=>_TRUE), "type" => "dropdown"))); ?>
<table class=" table table-hover table-striped"  >
    <thead>
    <tr>
        <td><?php echo _ID?></td>
        <td><?php echo _ORDER_BY?></td>
        <td><?php echo _NAME?></td>
        <td><?php echo _DES?></td>
        <td><?php echo _SHOW_LIST?></td>
        <td><?php echo _CSS_CLASS_PARENT?></td>
        <td><?php echo _CSS_CLASS?></td>
        <td><?php echo _CSS_STYLE?></td>
        <td><?php echo _ADVANCED_SETTING?></td>
        <td></td>
    </tr>
    </thead>
    <?php foreach ($db as $key => $value):?>
    <tr>
    <td><?php echo $value["id"] ?></td>
    <td>
        <?php echo $this->element->edit_text($value["id"], $value["order_by"], "auto_forms_fields", "order_by", "text") ?>
    </td>
    <td>
        <?php echo $this->element->edit_text($value["id"], $value["name"], "auto_forms_fields", "name", "text") ?>
    </td>
    <td>
        <?php echo $this->element->edit_text($value["id"], $value["des"], "auto_forms_fields", "des", "text") ?>
    </td>
    <td>
        <?php echo $this->element->edit_select_bool($value["id"], $value["show_list"], "auto_forms_fields", "show_list", "text") ?>
    </td>
        <td>
            <?php echo $this->element->edit_text($value["id"], $value["parent_class"], "auto_forms_fields", "parent_class", "text") ?>
        </td>
        <td>
            <?php echo $this->element->edit_text($value["id"], $value["class"], "auto_forms_fields", "class", "text") ?>
        </td>
        <td>
            <?php echo $this->element->edit_textarea($value["id"], $value["style"], "auto_forms_fields", "style", "text") ?>
        </td>
        <td>
            <?php echo $this->element->edit_textarea($value["id"], $value["params"], "auto_forms_fields", "params", "text") ?>
        </td>

    </tr>
    <?php endforeach; ?>
</table>

e
