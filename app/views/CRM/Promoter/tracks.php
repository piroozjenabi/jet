<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$def_css_class="form-control";
$this->load->helper('form');
$attributes = array('class' => 'form', 'id' => 'form');
$main_form= form_open('CRM/Promoter/add_tracks/'.$id_user, $attributes);
$message=form_input(array('id'=>'track[1]', 'placeholder' => _TYPE_TRACK,'name' => 'track[1]','class'=>$def_css_class , "onchange"=>"add_track()" ));
$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);
$edit_link="<a class='btn btn-lg btn-info' onclick=areyousure('link','".site_url("CRM/Tmp_users/edit/".$id_user)."')> <i class=\"fa fa-edit\"></i> "  . _EDIT." "._DETAILS. '</a>';
$CI =& get_instance();
$tmp_tracks=$tracks;
$cur_value=array();
$tmp_html="";

?>
<?php foreach ($state as $key => $value) {
    $cur_value=($tmp_user[0]["state"] == $value["id"])?$value:$cur_value;
} ?>


<div class="row well" >
<!--    --><?php //foreach ($state as $key => $value):?>
<!--        --><?php //if($tmp_user[0]["state"] != $value["id"] ):
//            ?>
<!--        <a class="btn btn-lg --><?//=$value["css"] ?><!-- " href="--><?//= site_url("CRM/Tmp_users/change_state/".$tmp_user[0]["id"]."/".$value["id"]) ?><!--" > <i class="fa fa-edit"></i> --><?//=  _CONVERT_TO.$value["name"] ?><!--</a>-->
<!--        --><?php //endif; ?>
<!--    --><?php //endforeach; ?>
        <?php echo $edit_link?>



</div>
<div class="row well ">
    <div class="col-sm-1 well tmp_user_details" ><?php echo _ID ?> : <?php echo $tmp_user[0]["id"]?> </div>
    <div class="col-sm-2 well tmp_user_details " ><?php echo _NAME ?> : <?php echo $tmp_user[0]["name"]?> </div>
    <div class="col-sm-2 well tmp_user_details " ><?php echo _NATIONAL_ID ?> : <?php echo $tmp_user[0]["meli_id"]?> </div>
    <div class="col-sm-2 well tmp_user_details " > <?php echo _MOBILE ?> : <?php echo $tmp_user[0]["mobile"]?> </div>
    <div class="col-sm-2 well tmp_user_details " > <?php echo _TELL ?> : <?php echo $tmp_user[0]["tell"]?> </div>
    <div class="col-sm-3 well tmp_user_details " ><?php echo _ADDRESS ?> : <?php echo $tmp_user[0]["address"]?> </div>

</div>

<?php foreach ($tracks as $key => $value) :?>

    <?php if(!$value["replay"]) : ?>

    <div class="panel panel-primary">
        <div class="panel-heading"  > <i class="fa fa-user fa-1x"> </i> <?php echo $CI->system->get_user_from_id($value["from_user"]);  ?>   |  <small  > <i class="fa fa-clock-o fa-1x"> </i>  <?php echo $CI->piero_jdate->jdate("Y/m/d   H:m   ", $value["date"]);?></small>
            <button  class="btn btn-default btn-xs"  style="float: left" onclick="show_rep(<?php echo $value["id"]?>)" >
                <span class="fa fa-reply fa-1x"></span> <?php echo _REPLAY ?>
            </button>
        </div>
        <div class="panel-body">
            <div class="col-sm-12 "> <i class="fa fa-pencil fa-1x"></i> <?php echo str_replace("\n", "</br>", $value["message"]);?> </div>
            <?php
            echo form_open('CRM/Tmp_users/add_tracks/'.$id_user, $attributes);


            echo form_hidden('replay[1]', $value["id"]);
            ?>
            <div class="form-group input-group " id="rep<?php echo $value["id"]?>" style="display: none;">
                    <?php echo form_input(array('id'=>'track[1]', 'placeholder' => _TYPE_REPLAY,'name' => 'track[1]','class'=>'form-control' )); ?>

                    <span class="input-group-btn"   ><button type="submit" class="btn btn-default" ><i class="fa fa-check"></i></button></span>


                  </div>
            <?php echo form_close() ?>


    </div>
    </div>


<?php foreach ($tracks as $key2 => $value2) : ?>

<?php if($value2["replay"]==$value["id"] ) : ?>

        <div class="panel panel-red " style="margin-right: 50px;">
            <div class="panel-heading"  > <i class="fa fa-user fa-1x"> </i> <?php echo $CI->system->get_user_from_id($value2["from_user"])[0]["name"];  ?>   |  <small  > <i class="fa fa-clock-o fa-1x"> </i>  <?php echo $CI->piero_jdate->jdate("Y/m/d   H:m   ", $value2["date"]);?></small>

            </div>
            <div class="panel-body">
                <div class="col-sm-12 "> <i class="fa fa-reply fa-1x"></i> <?php echo str_replace("\n", "</br>", $value2["message"]);?> </div>
                <div class="col-sm-12 ">  </div>


            </div>
        </div>

<?php endif; ?>
<?php endforeach; ?>
    <?php endif; ?>

<?php endforeach; ?>
<?php echo $main_form ?>

<div class="col-sm-12 well">
    <?php echo $savebtn ?>
</div>
<div  id="tracks">

    <div class="col-sm-12 well">
    <?php echo $message ?>
    </div>

</div>
<?php echo form_close(); ?>

<script type="text/javascript">

    var _row =2;
    add_track();
    function add_track() {
        $("#tracks").append( '<div  class="col-sm-12 well"  >'+'<?php echo $this->element->rep_ele($message, "1", "'+_row+'") ?>'+'</div>');
        _row++;
    }

    function show_rep( _id_ele ) {
       $("#rep"+_id_ele).show(100);
//        alert(_id_ele);
    }

</script>
<style type="text/css" rel="stylesheet">
 .tmp_user_details{background-color: #4d4d4d;color: #fff;font-size: small;min-height: 80px;}

</style>
