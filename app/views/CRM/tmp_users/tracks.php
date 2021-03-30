<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$CI =& get_instance();
$this->load->helper('form');
$CI->load->library('Piero_jdate');
$def_css_class="form-control";
$attributes = array('class' => 'form', 'id' => 'form');
$main_form= form_open('CRM/Tmp_users/add_tracks/'.$id_user, $attributes);
$message=form_input(array('id'=>'track[1]', 'placeholder' => _TYPE_TRACK,'name' => 'track[1]','class'=>$def_css_class , "onchange"=>"add_track()" ));
$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);
$edit_link="<a class='btn btn-info' href='".site_url("CRM/Tmp_users/edit/".$id_user)."'> <i class=\"fa fa-edit\"></i> "  . _EDIT." "._DETAILS. '</a>';
$tmp_tracks=$tracks;
$cur_value=array();
$tmp_html="";
?>
<h2 class="page-header"> <?php echo _MANAGE.__. _TMP_USERS ."(".$tmp_user[0]["name"].")"  ?> </h2>
<?php foreach ($state as $key => $value) {
    $cur_value=($tmp_user[0]["state"] == $value["id"])?$value:$cur_value;
} ?>
<?php if(!$cur_value["disable_converting"]) : ?>
<div class="label label-info"  >
    <?php echo _ID ." : ". $tmp_user[0]["id"]?> |
    <?php echo _NAME ." : ".$tmp_user[0]["name"]?> |
    <?php echo _CONTACT ." : ". $tmp_user[0]["contact"]?> |
    <?php echo _MOBILE ." : ".$tmp_user[0]["mobile"]?> |
    <?php echo ($tmp_user[0]["tell"])?_TELL ." : ".$tmp_user[0]["tell"]." | ":null ?>
    <?php echo ($tmp_user[0]["des"])?_DES ." : ".$tmp_user[0]["des"]." | ":null ?>
    <?php echo ($tmp_user[0]["email"])?_EMAIL ." : ".$tmp_user[0]["email"]." | ":null ?>
    <?php echo ($tmp_user[0]["des"])?_DES ." : ".$tmp_user[0]["des"]." | ":null ?>
    <?php echo ($tmp_user[0]["extra1"])?_EXTRA1_TMP_USER ." : ".$tmp_user[0]["extra1"]." | ":null ?>
    <?php echo ($tmp_user[0]["extra2"])?_EXTRA2_TMP_USER ." : ".$tmp_user[0]["extra2"]." | ":null ?>
</div>
    <div class="label label-primary"  >
        <?php echo _DATE_CREATE ." : ". $CI->piero_jdate->jdate("Y/m/d", $tmp_user[0]["date_create"])?>|
        <?php echo _MAKER ." : ". $this->system->get_user_admin_from_id($tmp_user[0]["maker_id"]) ?>
    </div>
    <div class="label label-danger" style="margin-top: -150px;width: 100%" >  <?php echo _CURRENT_STATE." : ". $cur_value["name"] ?> </div>
    <br/><br/>
    <div class="btn-group well well-sm " >
    <div class="btn"><?php echo _OP ?></div>
    <?php foreach ($state as $key => $value):?>
    <?php if($tmp_user[0]["state"] != $value["id"] ) :?>
        <a class="btn <?php echo $value["css"] ?> " href="<?php echo site_url("CRM/Tmp_users/change_state/".$tmp_user[0]["id"]."/".$value["id"]) ?>" > <i class="fa fa-arrow-circle-o-left"></i> <?php echo  _CONVERT_TO.__.$value["name"] ?></a>
    <?php endif; ?>
    <?php endforeach; ?>
    </div>
<div class="btn-group well well-sm  ">
<?php if($cur_value["enable_edit"]) { echo $edit_link;
}?>
<?php endif; ?>
</div>
<?php foreach ($tracks as $key => $value) :?>

    <?php if(!$value["replay"]) : ?>

    <div class="panel panel-primary">
        <div class="panel-heading"  > <i class="fa fa-user fa-1x"> </i> <?php echo $CI->system->get_user_admin_from_id($value["from_user"]);  ?>   |  <small  > <i class="fa fa-clock-o fa-1x"> </i>  <?php echo $CI->piero_jdate->jdate("Y/m/d   H:m   ", $value["date"]);?></small>
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
<?php  if($cur_value["enable_commenting"]) : ?>
<div class="col-sm-12 well">
    <?php echo $savebtn ?>
    <?php echo form_input(array('id'=>'track', 'placeholder' => _MESSAGE,'name' => 'track','class'=>'form-control' )); ?>
    <span class="input-group-btn"><button type="submit" class="btn btn-primary" ><i class="fa fa-arrow-circle-left"></i></button></span>

</div>
<div  id="tracks">

    <div class="col-sm-12 well">
    <?php echo $message ?>
    </div>

</div>
<?php echo form_close(); ?>
<?php endif; ?>
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


    <?php if(isset($user_id)) : ?>
    $(document).ready(function(){
        piero_message('<?php echo _SUC_OP_CONVERT_USER ?>'');
        load_ajax_popupfull('<?php echo site_url("MaLi/pusers/users/edit/");?>','id=<?php echo $user_id ?>')
    });
    <?php endif; ?>

</script>
