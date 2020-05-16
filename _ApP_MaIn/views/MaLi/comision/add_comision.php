<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$CI =& get_instance();
$CI->load->library("comision");
$CI->load->library("element");
$def_css_class="form-control";
$this->load->helper('form');
$attributes = array('class' => 'form', 'id' => 'form');
$main_form= form_open('/MaLi/comision/Manage_comision/padd_comision/'.$id, $attributes);
$prd=form_dropdown('prd_id[1]', $this->element->pselect("prd"), 0, array('class' => $def_css_class));
$fromc=form_input(array("name"=>"fromc[1]","id"=>"fromc[1]",'class' => $def_css_class));
$toc=form_input(array("name"=>"toc[1]","id"=>"toc[1]",'class' => $def_css_class));
$percent=form_input(array('id'=>'value_percent[1]','name' => 'value_percent[1]','class'=>$def_css_class  ));
$num=form_input(array('id'=>'value_num[1]','name' => 'value_num[1]','class'=>$def_css_class  ));
$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);

?>
<table class=" table table-hover table-striped"  >
<thead>
<tr>
<td><?php echo _ID?></td>
<td><?php echo _NAME.__._PRD?></td>
<td><?php echo _FROM?></td>
<td><?php echo _TO?></td>
<td><?php echo _PERCENT?></td>
<td><?php echo _VALUE?></td>
</tr>
</thead>
<?php foreach ($db as $key => $value):?>
    <tr>
        <td><?php echo $value["id"] ?></td>
        <td>
            <?php echo $value["prd_id"]?>
        </td>
        <td>
            <?php echo $value["fromc"] ?>
        </td>
        <td>
            <?php echo $value["toc"] ?>
        </td>
        <td>
            <?php echo $value["value_percent"] ?>
        </td>
        <td>
            <?php echo $value["value_num"] ?>
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

        <div class="col-sm-4 well" ><?php echo _PRD ?></div>
        <div class="col-sm-2 well" ><?php echo _FROM ?></div>
        <div class="col-sm-2 well" ><?php echo _TO ?></div>
        <div class="col-sm-2 well" ><?php echo _PERCENT ?></div>
        <div class="col-sm-2 well" ><?php echo _VALUE ?></div>


        <div class="col-sm-4 well">
            <?php echo $prd?>
        </div>
        <div class="col-sm-2 well">
            <?php echo $fromc?>
        </div>
        <div class="col-sm-2 well">
            <?php echo $toc?>
        </div>
        <div class="col-sm-2 well">
            <?php echo $percent?>
        </div>
        <div class="col-sm-2 well">
            <?php echo $num?>
        </div>

    </div>
<?php echo form_close(); ?>

<script type="text/javascript">

    var _row =2;
    add_track();
    function add_field() {
        $("#tracks").append( '<div  class="col-sm-4 well"  >'+'<?php echo $this->element->rep_ele($prd, "1", "'+_row+'") ?>'+'</div>'+'<div  class="col-sm-2 well"  >'+'<?php echo $this->element->rep_ele($fromc, "1", "'+_row+'") ?>'+'</div>'+'<div  class="col-sm-2 well"  >'+'<?php echo $this->element->rep_ele($toc, "1", "'+_row+'") ?>'+'</div>'+'<div  class="col-sm-2 well"  >'+'<?php echo $this->element->rep_ele($percent, "1", "'+_row+'") ?>'+'</div>'+'<div  class="col-sm-2 well"  >'+'<?php echo $this->element->rep_ele($num, "1", "'+_row+'") ?>'+'</div>');
        _row++;
    }

</script>
