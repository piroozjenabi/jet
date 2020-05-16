<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('form');

//form open
$attributes = array('class' => 'form', 'id' => 'form');
if (@$mode="edit" && $detail_user[0]["id"]) {
    echo form_open('CRM/Tmp_users/pedit/'.$detail_user[0]["id"], $attributes);
}
else
{
    //sett empety for edit
    $detail_user[0] = array("id" => "" , "name"=>"","contact"=>"","tmp_client_type"=>"0","mobile"=>"",
           "tmp_client_peyment" => "" , "address"=>"","postal_code"=>"","usergroup"=>"",
           "extra5" => "" ,"extra1" => "" , "extra2"=>"","extra3"=>"","extra4"=>"",
           "tell" => "" , "email"=>"","website"=>"http://",
           "perfix_code"=> $this->system->get_setting("perfix_user") ,
           "comerical_type"=>"1","usergroup"=>"2","status_id"=>"1");

    echo form_open('CRM/Tmp_users/padd', $attributes);
}

$def_css_class="form-control";
$data = array('class' => $def_css_class,"required"=>"required");
$tmp_client_type=form_dropdown('tmp_client_type', $this->element->pselect("tmp_client_type"), $detail_user[0]["tmp_client_type"], $data);
$tmp_client_peyment=form_dropdown('tmp_client_peyment', $this->element->pselect("tmp_client_peyment_type"), $detail_user[0]["tmp_client_peyment"], $data);


$name= form_input(array('value'=> $detail_user[0]["name"] ,'id'=>'name', 'placeholder' => _NAME_USER,'required' => 'required','name' => 'name','class'=>$def_css_class));
$tell= form_input(array('value'=> $detail_user[0]["tell"] ,'id'=>'tell', 'placeholder' => _TELL,'required' => 'required','name' => 'tell','class'=>$def_css_class));
$mobile= form_input(array('value'=> $detail_user[0]["mobile"] ,'id'=>'mobile', 'placeholder' => _MOBILE,'required' => 'required','name' => 'mobile','class'=>$def_css_class));
$email= form_input(array('value'=> $detail_user[0]["email"] ,'id'=>'email', 'placeholder' => _EMAIL,'name' => 'email','class'=>$def_css_class,'type'=>'email'));
$address= form_input(array('value'=> $detail_user[0]["address"] ,'id'=>'address', 'placeholder' => _ADDRESS,'required' => 'required','name' => 'address','class'=>$def_css_class));

$contact= form_input(array('value'=> $detail_user[0]["contact"] ,'id'=>'agent', 'placeholder' => _CONTACT,'name' => 'contact','class'=>$def_css_class));
$extra1= form_input(array('value'=> $detail_user[0]["extra1"] ,'id'=>'extra1', 'placeholder' => _EXTRA1_TMP_USER,'name' => 'extra1','class'=>$def_css_class));
$extra2= form_input(array('value'=> $detail_user[0]["extra2"] ,'id'=>'extra2', 'placeholder' => _EXTRA2_TMP_USER,'name' => 'extra2','class'=>$def_css_class));

$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block btn-lg '), _SAVE);
?>
<h3 class="panel-heading"><?php echo _ADD.__._BELGHOVE ?></h3>
<div class="row  well modal-body ">
  <div class="col-sm-3 row"><label for="type"><?php echo _TMP_TYPE?> </label><?php echo $tmp_client_type ?></div>
  <div class="col-sm-3 row"><label for="type"><?php echo _TMP_PEYMENT?> </label><?php echo $tmp_client_peyment ?></div>
  <div class="col-sm-3 row"><label for="type"><?php echo _NAME_USER ?></label><?php echo $name ?></div>
  <div class="col-sm-3 row"><label for="type"><?php echo _CONTACT?></label><?php echo $contact ?></div>
</div>
    <div class="row  well modal-body ">
  <div class="col-sm-3 row"><label for="tell"><?php echo _TELL ?></label><?php echo $tell ?></div>
  <div class="col-sm-3 row"><label for="mobile"><?php echo _MOBILE ?></label><?php echo $mobile ?></div>
  <div class="col-sm-3 row"><label for="email"><?php echo _EMAIL ?></label><?php echo $email ?></div>

  <div class="col-sm-3 row"><label for="mobile"><?php echo _EXTRA1_TMP_USER ?></label><?php echo $extra1 ?></div>

  <div class="col-sm-6 row"><label for="email"><?php echo _EXTRA2_TMP_USER ?></label><?php echo $extra2 ?></div>
  <div class="col-sm-6 row"><label for="address"><?php echo _ADDRESS ?></label><?php echo $address ?></div>



</div>

    <div class="row well" > <?php echo $savebtn ?> </div>




<?php echo form_close(); ?>
