<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$CI =& get_instance();
$CI->load->library("auto");
$CI->load->library("element");

$def_css_class="form-control";
$this->load->helper('form');
$attributes = array('class' => 'form', 'id' => 'form');
$main_form= form_open('/AUTO/manage_form/manage/padd_field_data/'.$id, $attributes);
$name=form_input(array('id'=>'name[1]', 'placeholder' => _NAME,'name' => 'name[1]','class'=>$def_css_class , "onchange"=>"add_field()" ));
$valuei=form_input(array('id'=>'value[1]', 'placeholder' => _VALUE,'name' => 'value[1]','class'=>$def_css_class  ));
$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);
?>
<table class=" table table-hover table-striped"  >
    <thead>
    <tr>
<td><?php echo _ID?></td>
<td><?php echo _NAME?></td>
<td><?php echo _VALUE?></td>
<td><?php echo _FATHER ?></td>
</tr>
</thead>
<?php foreach ($db as $key => $value):?>
    <tr>
        <td><?php echo $value["id"] ?></td>
        <td>
            <?php echo $this->element->edit_text($value["id"], $value["name"], "auto_forms_field_data", "name", "text") ?>
        </td>
        <td>
            <?php echo $this->element->edit_text($value["id"], $value["value"], "auto_forms_field_data", "value", "text") ?>
        </td>
        <td>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<hr>
<h3> <?php echo _ADD ?> </h3>
<!--add multi-->
<?php echo $main_form ?>

    <div  id="tracks">
        <div class="col-sm-12 well">
            <?php echo $savebtn ?>
        </div>
        <div class="col-sm-6 well">
            <?php echo $name?>
        </div>
        <div class="col-sm-6 well">
            <?php echo $valuei ?>
        </div>

    </div>
<?php echo form_close(); ?>

<script type="text/javascript">

    var _row =2;
    function add_field() {
        $("#tracks").append( '<div  class="col-sm-6 well"  >'+'<?php echo $this->element->rep_ele($name, "1", "'+_row+'") ?>'+'</div>'+'<div  class="col-sm-6 well"  >'+'<?php echo $this->element->rep_ele($valuei, "1", "'+_row+'") ?>'+'</div>');
        _row++;
    }

</script>
