<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$this->load->helper('form');
$attributes = array('class' => 'form', 'id' => 'form');
  //sett mpety for edit
echo form_open(null, $attributes);
$def_css_class="form-control";
$data = array('class' => $def_css_class,"style"=>"width:100%  ");
$data_type = array('1' => _HAGHIGHI,'2' => _HOGHOOGHI );
$type=form_dropdown('comerical_type', $data_type, $detail_user[0]["comerical_type"], $data);

$user_group=form_dropdown('usergroup', $this->element->pselect("usergroup"), $detail_user[0]["usergroup"], $data);
//name of user
$name= form_input(array('value'=> $detail_user[0]["name"] ,'id'=>'name', 'placeholder' => _NAME_USER,'required' => 'required','name' => 'name','class'=>$def_css_class));
//kode meli ya eghtesadi
$comerical_id= form_input(array('value'=> $detail_user[0]["comerical_id"] ,'id'=>'comerical_id', 'placeholder' => _COMMERICAL_ID,'required' => 'required','name' => 'comerical_id','class'=>$def_css_class));
$parent=  $this->element->user_select("parent", "parent", $def_css_class, $detail_user[0]['parent']);

$tell= form_input(array('value'=> $detail_user[0]["tell"] ,'id'=>'tell', 'placeholder' => _TELL,'required' => 'required','name' => 'tell','class'=>$def_css_class));
$mobile= form_input(array('value'=> $detail_user[0]["mobile"] ,'id'=>'mobile', 'placeholder' => _MOBILE,'required' => 'required','name' => 'mobile','class'=>$def_css_class));
$email= form_input(array('value'=> $detail_user[0]["email"] ,'id'=>'email', 'placeholder' => _EMAIL,'name' => 'email','class'=>$def_css_class));
$address= form_input(array('value'=> $detail_user[0]["address"] ,'id'=>'address', 'placeholder' => _ADDRESS,'required' => 'required','name' => 'address','class'=>$def_css_class));
$postal_code= form_input(array('value'=> $detail_user[0]["postal_code"] ,'id'=>'postal_code', 'placeholder' => _POSTAL_CODE,'name' => 'postal_code','class'=>$def_css_class));
$web= form_input(array('value'=> $detail_user[0]["website"] ,'id'=>'web', 'placeholder' => _WEB,'name' => 'website','class'=>$def_css_class));
$perfix_code= form_input(array('value'=> $detail_user[0]["perfix_code"] ,'id'=>'perfix_code', 'placeholder' => _PERFIX_CODE,'name' => 'perfix_code','class'=>$def_css_class));
$agent= form_input(array('value'=> $detail_user[0]["agent"] ,'id'=>'agent', 'placeholder' => _AGENT,'name' => 'agent','class'=>$def_css_class));
$status= form_dropdown('status_id', $this->element->pselect("user_status"), $detail_user[0]["status_id"], $data);
$extra1= form_input(array('value'=> $detail_user[0]["extra1"] ,'id'=>'extra1', 'placeholder' => _EXTRA1,'name' => 'extra1','class'=>$def_css_class));
$extra2= form_input(array('value'=> $detail_user[0]["extra2"] ,'id'=>'extra2', 'placeholder' => _EXTRA2,'name' => 'extra2','class'=>$def_css_class));
$extra3= form_input(array('value'=> $detail_user[0]["extra3"],'id'=>'extra3', 'placeholder' => _EXTRA3,'name' => 'extra3','class'=>$def_css_class));
$extra4= form_input(array('value'=> $detail_user[0]["extra4"],'id'=>'extra4', 'placeholder' => _EXTRA4,'name' => 'extra4','class'=>$def_css_class));
$extra5= form_input(array('value'=> $detail_user[0]["extra5"],'id'=>'extra5', 'placeholder' => _EXTRA5,'name' => 'extra5','class'=>$def_css_class));
//buttun--------------------
$savebtn= form_button(array('type' => "button",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);
$username= form_input(array('value'=> $detail_user[0]["username"],'placeholder' => _USERNAME,'name' => 'username','class'=>$def_css_class));
$password= form_password(array('autocomplete'=>"off" ,'placeholder' => _PASSWORD,'name' => 'password','class'=>$def_css_class));

echo form_hidden("id", $detail_user[0]["id"])
?>

<div class="row  well ">
  <div class="col-sm-4 "><label for="type"><?php echo _TYPE_USER ?></label><?php echo $type ?></div>
  <div class="col-sm-4 "><label for="type"><?php echo _USER_GROUP ?></label><?php echo $user_group ?></div>

  <div class="col-sm-4 "><label for="name"><?php echo _NAME_USER ?></label><?php echo $name ?></div>
  <div class="col-sm-4 "><label for="lname"><?php echo _COMMERICAL_ID ?></label><?php echo $comerical_id ?></div>
  <div class="col-sm-4 "><label for="agent"><?php echo _AGENT?></label><?php echo $agent ?></div>

  <div class="col-sm-4 "><label for="tell"><?php echo _TELL ?></label><?php echo $tell ?></div>
  <div class="col-sm-4 "><label for="mobile"><?php echo _MOBILE ?></label><?php echo $mobile ?></div>
  <div class="col-sm-4 "><label for="email"><?php echo _EMAIL ?></label><?php echo $email ?></div>
  <div class="col-sm-4 "><label for="address"><?php echo _ADDRESS ?></label><?php echo $address ?></div>
  <div class="col-sm-4 "><label for="postal_code"><?php echo _POSTAL_CODE ?></label><?php echo $postal_code ?></div>
  <div class="col-sm-4 "><label for="web"><?php echo _WEB ?></label><?php echo $web?></div>
  <div class="col-sm-4 "><label for="perfix_code"><?php echo _PERFIX_CODE ?></label><?php echo $perfix_code ?></div>
  <div class="col-sm-4 "><label for="username"><?php echo _USERNAME ?></label><?php echo $username?></div>
    <div style="display: none"> <input type="password"> <?php //  for hide save password ?>  </div>
  <div class="col-sm-4 "><label for="password"><?php echo _PASSWORD ?></label><?php echo $password ?></div>
</div>
<div class="row well">
    <h3><?php echo _MORE_INFO ?> </h3>
    <div class="col-sm-4"><label for="extra1"><?php echo _EXTRA1?></label><?php echo $extra1 ?></div>
    <div class="col-sm-4"><label for="extra1"><?php echo _EXTRA2?></label><?php echo $extra2 ?></div>
    <div class="col-sm-4"><label for="extra1"><?php echo _EXTRA4?></label><?php echo $extra4 ?></div>
    <div class="col-sm-4"><label for="extra1"><?php echo _EXTRA5?></label><?php echo $extra5 ?></div>
    <div class="col-sm-8"><label for="extra1"><?php echo _EXTRA3?></label><?php echo $extra3 ?></div>

</div>
<button class="col-sm-12 well" type="submit" style="padding:30px;"> <?php echo $savebtn ?> </button>
<?php echo $this->element->load_ajax_submit("form", 'MaLi/pusers/users/pedit'); ?>
