<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
echo $this->template->load_custom_js("js-persian-cal.min");
echo $this->template->load_custom_css("js-persian-cal");
$def_css_class="form-control";
$this->load->helper('form');
$attributes = array('class' => 'form', 'id' => 'form');
$main_form= form_open('CRM/my_client/add_tracks/'.$id_user, $attributes);
$message=form_input(array('id'=>'track[1]', 'placeholder' => _TYPE_TRACK,'name' => 'track[1]','class'=>$def_css_class , "onchange"=>"add_track()" ));
$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);
$CI =& get_instance();
$CI->load->library('Piero_jdate');
$tmp_tracks=$tracks;
if($this->permission->check("user_edit")) {
    $edit_link="<a class='btn btn-info' style='font-size:12px !important ;' onclick=areyousure('link','".site_url("MaLi/pusers/users/edit/".$id_user)."')> <i class=\"fa fa-edit\"></i> "  . _EDIT.'</a>';
} else {
    $edit_link="<a class='btn btn-default' style='font-size:12px !important ;' ></i> "  . _EDIT.'</a>';
}

?>

<div class="row well" >
    <?php if($last) : ?>
<!--lastests folows-->
        <div class="col-lg-2 col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">

                        </div>
                        <div class="col-xs-12 text-center">
                            <div class="huge"></div>
                            <div style="text-align: center;font-weight: bolder"><?php echo _LAST_FOLOWS?></div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left"><?php echo _VIEW ._FOLOWS  ?></span>
                        <span class="pull-right"><i class="fa fa-list"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
<!--last folow-->

    <div class="col-lg-2 col-md-3" data-toggle="tooltip" title="<?php echo $des_last ?>">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">

                    </div>
                    <div class="col-xs-12 text-center">
                        <div class="huge"></div>
                        <div style="text-align: center;font-weight: bolder"><?php echo $CI->piero_jdate->jdate("y/m/d", $last) ?></div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo _VIEW ._FOLOWS  ?></span>
                    <span class="pull-right"><i class="fa fa-list"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
    <?php if($cur) : ?>
<!--    curent-folow-->
    <div class="col-lg-3 col-md-3" data-toggle="tooltip" title="<?php echo $des_cur ?>">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">

                    </div>
                    <div class="col-xs-12 text-center">
                        <div class="huge"></div>
                        <div style="text-align: center;font-weight: bolder"><?php echo $CI->piero_jdate->jdate("y/m/d", $cur)?></div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo _VIEW ._FOLOWS._CURRENT  ?></span>
                    <span class="pull-right"><i class="fa fa-list"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
<?php
    $c=0;
    //next
foreach ($period as $key => $value):
    $c++;?>
    <div class="col-lg-1 col-md-1" data-toggle="tooltip" title="<?php echo $value["des"] ?>">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">

                </div>
                <div class="col-xs-12 text-center">
                    <div class="huge"></div>
                    <div style="text-align: center;font-weight: bolder"><?php echo $CI->piero_jdate->jdate("m/d", $value["date"])?></div>
                </div>
            </div>
            </div>

            <div class="panel-footer">
                <span class="pull-center"  ><?php echo $CI->piero_jdate->jdate("l", $value["date"])?></span>

                <div class="clearfix"></div>
            </div>

        </div>
    </div>
<?php endforeach;?>
<?php
//add
if($this->system->get_setting("max_user_time_period")>$c) : ?>
    <div class="col-lg-1 col-md-1"  data-target="#add-track" style="cursor: pointer" data-toggle="modal">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">

                    </div>
                    <div class="col-xs-12 text-center">
                        <div class="huge"></div>
                        <div style="text-align: center;font-weight: bolder"><i class="fa fa-plus fa-2x "></i> </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                <span class="pull-center"  ><?php echo _ADD ?></span>

                <div class="clearfix"></div>
            </div>

        </div>
    </div>
<?php endif; ?>
        <?php if($des_cur) : ?>
        <div class="col-sm-8 well" ><?php echo _DES ?> : <?php echo $des_cur?> </div>
        <?php endif; ?>

    <?php if($cur) : ?>
        <div class="col-sm-4 well" ><?php echo _ENTIRE_TIME ?> : <?php echo ceil(($cur-time())/60/60/24)._DAY?> </div>
    <?php endif; ?>

</div>



<div class="row well ">
    <div class="col-sm-1 well tmp_user_details" ><?php echo _ID ?> : <?php echo $tmp_user[0]["id"]?> </div>
    <div class="col-sm-2 well tmp_user_details " ><?php echo _NAME ?> : <?php echo $tmp_user[0]["name"]?> </div>
    <div class="col-sm-2 well tmp_user_details " ><?php echo _CONTACT ?> : <?php echo $tmp_user[0]["agent"]?> </div>
    <div class="col-sm-2 well tmp_user_details " > <?php echo _MOBILE ?> : <?php echo $tmp_user[0]["mobile"]?> </div>
    <div class="col-sm-2 well tmp_user_details " > <?php echo _TELL ?> : <?php echo $tmp_user[0]["tell"]?> </div>
    <div class="col-sm-2 well tmp_user_details " ><?php echo _ADDRESS ?> : <?php echo $tmp_user[0]["address"]?> </div>
    <div class="col-sm-1 well tmp_user_details " ><?php echo $edit_link ?> </div>
</div>

<?php foreach ($tracks as $key => $value) :

    ?>

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
            echo form_open('CRM/my_client/add_tracks/'.$id_user, $attributes);


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
                <div class="panel-heading"  > <i class="fa fa-user fa-1x"> </i> <?php echo $CI->system->get_user_from_id($value2["from_user"]);  ?>   |  <small  > <i class="fa fa-clock-o fa-1x"> </i>  <?php echo $CI->piero_jdate->jdate("Y/m/d   H:m   ", $value2["date"]);?></small>

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



<!-- Modal -->
<div id="add-track" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo _ADD . _FOLOWS ?></h4>
            </div>
            <?php
            echo form_open("CRM/my_client/tracks/".$tmp_user[0]["id"]);
            $date= form_input(array('id'=>'pcal1', 'class'=>$def_css_class." pdate"));
            $date_hidden=form_input(array("name"=>"date","id"=>"date","type"=>"hidden"));
            $des= form_input(array('id'=>'des', 'placeholder' => _DES,'name' => 'des','class'=>$def_css_class));

            ?>
            <div class="modal-body">

                <div class="col-sm-12 well"><label for="contry_maker"><?php echo _DATE?></label><?php echo $date . $date_hidden ?></div>
                <div class="col-sm-12 well"><label for="contry_maker"><?php echo _DES?></label><?php echo $des; ?></div>

            </div>
            <div class="modal-footer">
                <button type="submit"  class="btn btn-success btn-block .btn-lg " > <i class="fa fa-plus  "></i> <?php echo _ADD ?> </button>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>
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

    var objCal1 = new AMIB.persianCalendar( 'pcal1' ,{
        extraInputID: 'date',
        extraInputFormat: 'YYYY/MM/DD ',
        initialDate: '<?php echo $def_time ?>'
    });

</script>
<style type="text/css" rel="stylesheet">
    .tmp_user_details{background-color: #4d4d4d;color: #fff;font-size: small;min-height: 80px;}

</style>
