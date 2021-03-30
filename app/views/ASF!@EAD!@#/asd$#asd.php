<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$this->load->helper('form');
echo form_open("Dashboard/fill_profilep");
$def_class = 'form-control';
$res = $this->system->get_user_admin_from_id($this->system->get_user(), "*");?>
<div class="col-sm-12" >
    <label><?php echo _NAME ?></label>
    <?php echo form_input(array('value' => $res->name, 'name' => "name", 'class' => $def_class, 'required' => 'required')) ?>
</div>
<div class="col-sm-12" >
    <label><?php echo _EMAIL ?></label>
    <?php echo form_input(array('value' => $res->email, 'name' => "email", 'class' => $def_class)) ?>
</div>
<div class="col-sm-12" >
    <label><?php echo _MOBILE ?></label>
    <?php echo form_input(array('value' => $res->mobile, 'name' => "mobile", 'class' => $def_class)) ?>
</div>
<div class="col-sm-12" >
    <label><?php echo _TELL ?></label>
    <?php echo form_input(array('value' => $res->tell, 'name' => "tell", 'class' => $def_class)) ?>
</div>
<div class="col-sm-12" >
    <label><?php echo _POSTAL_CODE ?></label>
    <?php echo form_input(array('value' => $res->postal_code, 'name' => "postal_code", 'class' => $def_class)) ?>
</div>
<div class="col-sm-12" >
    <label><?php echo _ADDRESS ?></label>
    <?php echo form_input(array('value' => $res->address, 'name' => "address", 'class' => $def_class)) ?>
</div>
<div class="col-sm-12" >
    <label><?php echo _BIRTH ?></label>
    <?php echo $this->element->input_date("birthday", (isset($res->birthday) ? $res->birthday : null)) ?>
</div>
<div class="col-sm-12"><br><?php
echo form_hidden("id", $this->system->get_user());
echo form_submit(array('class' => 'btn btn-success btn-block '), _SAVE2);

?> <br>
</div>
<?php form_close();?>
