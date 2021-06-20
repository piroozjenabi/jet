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
    echo form_open('CRM/Promator/pedit/'.$detail_user[0]["id"], $attributes);
}
else
{
    //sett empety for edit
    $detail_user[0] = array("id" => "" , "name"=>"","meli_id"=>"","user_id"=>"","mobile"=>"",
           "address"=>"","postal_code"=>"","hour_daily"=>"","user_id"=>"",
           "group_id" => "" ,"extra1" => "" , "extra2"=>"","extra3"=>"",
           "tell" => "" , "email"=>"","sallari"=>"","weekly_alert1"=>"","weekly_alert2"=>"","weekly_alert3"=>"",
           "perfix_code"=> $this->system->get_setting("perfix_user") ,
           "comerical_type"=>"1","usergroup"=>"2","status_id"=>"1");

    echo form_open('CRM/Promoter/padd', $attributes);
}



$def_css_class="form-control";
$data = array('class' => $def_css_class);
$group=form_dropdown('group_id', $this->element->pselect("crm_Promoter_group"), $detail_user[0]["group_id"], $data);

$name= form_input(array('value'=> $detail_user[0]["name"] ,'id'=>'name', 'placeholder' => _NAME_USER,'required' => 'required','name' => 'name','class'=>$def_css_class));
$meli_id= form_input(array('value'=> $detail_user[0]["meli_id"] ,'id'=>'name', 'placeholder' => _NATIONAL_ID,'required' => 'required','name' => 'meli_id','class'=>$def_css_class));
$user_id= $this->element->user_select("user_id", "user_id", $def_css_class, $detail_user[0]['user_id']);
$hour_daily= form_input(array('value'=> $detail_user[0]["hour_daily"] ,'id'=>'name', 'placeholder' => _HOUR_WORK.__._ACCEPTED_SUC,'required' => 'required','name' => 'hour_daily','class'=>$def_css_class));
$sallari= form_input(array('value'=> $detail_user[0]["sallari"] ,'id'=>'name', 'placeholder' => _SALARY,'required' => 'required','name' => 'sallari','class'=>$def_css_class));

$tell= form_input(array('value'=> $detail_user[0]["tell"] ,'id'=>'tell', 'placeholder' => _TELL,'required' => 'required','name' => 'tell','class'=>$def_css_class));
$mobile= form_input(array('value'=> $detail_user[0]["mobile"] ,'id'=>'mobile', 'placeholder' => _MOBILE,'required' => 'required','name' => 'mobile','class'=>$def_css_class));
$email= form_input(array('value'=> $detail_user[0]["email"] ,'id'=>'email', 'placeholder' => _EMAIL,'name' => 'email','class'=>$def_css_class));
$address= form_input(array('value'=> $detail_user[0]["address"] ,'id'=>'address', 'placeholder' => _ADDRESS,'required' => 'required','name' => 'address','class'=>$def_css_class));

$extra1= form_input(array('value'=> $detail_user[0]["extra1"] ,'id'=>'extra1', 'placeholder' => _EXTRA1_PROMOTER,'name' => 'extra1','class'=>$def_css_class));
$extra2= form_input(array('value'=> $detail_user[0]["extra2"] ,'id'=>'extra2', 'placeholder' => _EXTRA2_PROMOTER,'name' => 'extra2','class'=>$def_css_class));
$extra3= form_input(array('value'=> $detail_user[0]["extra3"] ,'id'=>'extra2', 'placeholder' => _EXTRA2_PROMOTER,'name' => 'extra3','class'=>$def_css_class));

$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);


$weekly_alert1=$this->element->select_day("weekly_alert1", $detail_user[0]["weekly_alert1"], $data);
$weekly_alert2=$this->element->select_day("weekly_alert2", $detail_user[0]["weekly_alert2"], $data);
$weekly_alert3=$this->element->select_day("weekly_alert3", $detail_user[0]["weekly_alert3"], $data);



?>
<div class="row  well ">
  <div class="col-sm-6 well"><label for="type"><?php echo _NAME?></label><?php echo $name ?></div>
  <div class="col-sm-3 well"><label for="type"><?php echo _GROUP?> </label><?php echo $group ?></div>
  <div class="col-sm-3 well" style="padding:32px;"> <?php echo $savebtn ?> </div>
</div>

<div class="row well">

  <div class="col-sm-3 well"><label for="type"><?php echo _NATIONAL_ID?></label><?php echo $meli_id ?></div>
  <div class="col-sm-3 well"><label for="tell"><?php echo _TELL ?></label><?php echo $tell ?></div>
  <div class="col-sm-3 well"><label for="mobile"><?php echo _MOBILE ?></label><?php echo $mobile ?></div>
  <div class="col-sm-3 well"><label for="email"><?php echo _EMAIL ?></label><?php echo $email ?></div>
  <div class="col-sm-3 well"><label for="email"><?php echo _HOUR_WORK.__._ACCEPTED_SUC ?></label><?php echo $hour_daily?></div>
  <div class="col-sm-3 well"><label for="address"><?php echo _SHOPING_STORE.__._S.__._ACCEPTED_SUC ?></label><?php echo $user_id ?></div>
  <div class="col-sm-3 well"><label for="address"><?php echo _SALARY ?></label><?php echo $sallari?></div>
  <div class="col-sm-3 well"><label for="address"><?php echo _ADDRESS ?></label><?php echo $address?></div>
    <div class="col-sm-3 well">
        <label><?php echo _DAY._SS.__._ALERT_IN_WEEK ?></label><br>
        <div class="col-sm-4 "> <?php echo $weekly_alert1 ?> </div>
        <div class="col-sm-4 "> <?php echo $weekly_alert2 ?> </div>
        <div class="col-sm-4 "> <?php echo $weekly_alert3 ?> </div>



    </div>

  <div class="col-sm-3 well"><label for="mobile"><?php echo _EXTRA1_PROMOTER ?></label><?php echo $extra1 ?></div>
  <div class="col-sm-3 well"><label for="email"><?php echo _EXTRA2_PROMOTER ?></label><?php echo $extra2 ?></div>
  <div class="col-sm-3 well"><label for="email"><?php echo _EXTRA3_PROMOTER ?></label><?php echo $extra3 ?></div>


</div>


</div>




<?php echo form_close(); ?>
