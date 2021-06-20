<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$this->load->helper('form');
$attributes = array('class' => 'form', 'id' => 'form');
echo form_open("#", $attributes);
$data = array('class' => "form-control");
//begin elements
$def_css_class="form-control";
$sex=$this->element->select_sex('sex', $detail_user[0]["sex"]);
$user_group=form_dropdown('usergroup', $this->element->pselect("usergroup_eemploy"), $detail_user[0]["usergroup"], $data);
$state=form_dropdown('state', [1 => _TRUE,0=>_FALSE], $detail_user[0]["state"], $data);
//name of user
$name= form_input(array('value'=> $detail_user[0]["name"] ,'id'=>'name', 'placeholder' => _FULL_NAME,'required' => 'required','name' => 'name','class'=>$def_css_class));
//kode meli ya eghtesadi
$meli_id= form_input(array('value'=> $detail_user[0]["meli_id"] ,'id'=>'meli_id', 'placeholder' => _NATIONAL_ID,'required' => 'required','name' => 'meli_id','class'=>$def_css_class));

$tell= form_input(array('value'=> $detail_user[0]["tell"] ,'id'=>'tell', 'placeholder' => _TELL,'required' => 'required','name' => 'tell','class'=>$def_css_class));
$mobile= form_input(array('value'=> $detail_user[0]["mobile"] ,'id'=>'mobile', 'placeholder' => _MOBILE,'required' => 'required','name' => 'mobile','class'=>$def_css_class));
$email= form_input(array('value'=> $detail_user[0]["email"] ,'id'=>'email', 'placeholder' => _EMAIL,'name' => 'email','class'=>$def_css_class));
$address= form_input(array('value'=> $detail_user[0]["address"] ,'id'=>'address', 'placeholder' => _ADDRESS,'required' => 'required','name' => 'address','class'=>$def_css_class));
$postal_code= form_input(array('value'=> $detail_user[0]["postal_code"] ,'id'=>'postal_code', 'placeholder' => _POSTAL_CODE,'name' => 'postal_code','class'=>$def_css_class));
$reagent = form_input(array('value'=> $detail_user[0]["reagent"] ,'id'=>'agent', 'placeholder' => _REAGENT,'name' => 'reagent','class'=>$def_css_class));
$limit_sell = form_input(array('value'=> $detail_user[0]["limit_sell"] ,'id'=>'limit_sell', 'placeholder' => _MIN_LIMIT_SELL,'name' => 'limit_sell','class'=>$def_css_class));

//buttun--------------------
$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);

$username= form_input(array('value'=> $detail_user[0]["username"],'placeholder' => _USERNAME,'name' => 'username','class'=>$def_css_class));
$password= form_password(array('placeholder' => _PASSWORD,'name' => 'password','class'=>$def_css_class));
$idE=form_hidden("id", $detail_user[0]["id"]);

?>
<div class="row  well ">
  <div class="col-sm-6 "><label for="type"><?php echo _USER_GROUP ?></label><?php echo $user_group ?></div>
  <div class="col-sm-6 "><label for="name"><?php echo _FULL_NAME ?></label><?php echo $name ?></div>
</div>
<div class="row  well ">
  <div class="col-sm-6 "><label for="username"><?php echo _USERNAME ?></label><?php echo $username?></div>
  <div style="display: none"> <input type="password"> <?php //  for hide save password ?>  </div>
  <div class="col-sm-6 "><label for="password"><?php echo _PASSWORD ?></label><?php echo $password ?></div>
</div>
<div class="row  well ">
  <div class="col-sm-6 "><label for="lname"><?php echo _STATE ?></label><?php echo $state ?></div>
  <div class="col-sm-6 "><label for="lname"><?php echo _NATIONAL_ID ?></label><?php echo $meli_id ?></div>
  <div class="col-sm-6 "><label for="agent"><?php echo _REAGENT ?></label><?php echo $reagent ?></div>
  <div class="col-sm-6 "><label for="type"><?php echo _SEX?></label><?php echo $sex ?></div>
  <div class="col-sm-6 "><label for="tell"><?php echo _TELL ?></label><?php echo $tell ?></div>
  <div class="col-sm-6 "><label for="mobile"><?php echo _MOBILE ?></label><?php echo $mobile ?></div>
  <div class="col-sm-6 "><label for="email"><?php echo _EMAIL ?></label><?php echo $email ?></div>
  <div class="col-sm-6 "><label for="postal_code"><?php echo _POSTAL_CODE ?></label><?php echo $postal_code ?></div>
    <?php if($this->system->get_setting("enable_limit_sell")) : ?>
  <div class="col-sm-12 input-numeral "><label for="password"><?php echo _MIN_LIMIT_SELL?></label><?php echo $limit_sell ?></div>
    <?php endif; ?>
  <div class="col-sm-12 "><label for="address"><?php echo _ADDRESS ?></label><?php echo $address ?></div></div>


<div class="row well">
    <button class="col-sm-12 " type="submit"><span id="submit"  class="btn btn-success btn-block"  >
      <?php echo $idE  ?>
      <?php echo _SAVE ?></span></button>
</div>
<?php echo form_close(); ?>

<?php echo $this->element->load_ajax_submit("form", 'eemploy/Eemploy/pedit'); ?>
