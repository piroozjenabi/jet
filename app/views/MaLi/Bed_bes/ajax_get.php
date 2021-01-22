<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

$def_css_class="form-control";
$data = array('class' => $def_css_class);
$radif=0;

// -- load check options

//end check
$this->load->helper('form');
if(@$detail) {
    if(@$detail["params"]) {
        $tmp_params_array=json_decode($detail["params"]);

        $detail["checku"]=(@ $tmp_params_array->datecheck )?$tmp_params_array->datecheck:null;
    }
    echo form_open("MaLi/Bed_bes/ajax_getp/".$detail["id"]);
}

else{
    $detail=array("price"=>null,"des"=>null,"date"=>null,"checku"=>null);
    echo form_open("MaLi/Bed_bes/ajax_getp");
}
$flag_cheku=( @$tmp_params_array->flagcheck)?true:false;
//print_r($detail_factor);
//        time
$this->load->library('Piero_jdate');
//echo $this->template->load_custom_js("angular.min");

echo $this->template->load_custom_js("js-persian-cal.min");
echo $this->template->load_custom_css("js-persian-cal");

?>



<div class="row well col-sm-12">
    <?php echo _DATE ?> :
    <?php
    echo  form_input(array('id'=>'pcalreject', 'class'=>"form-control pdate"));
    echo form_input(array("name"=>"date","id"=>"daterej","type"=>"hidden"));
    echo form_hidden("user_id", $user_id);
    echo form_hidden("factor_id", $factor_id);
    echo form_hidden("group_id", $group_id);


    ?>
</div>
<div class="row well col-sm-12">
    <label><?php echo _GET_MONEY.__._R ?> :</label>
    <?php echo $this->element->input_price(array("name" => "price","value" => $detail["price"],"required" => "required")); ?>
    </div>
<!--        check start-->


    <div >
        <label class="switch col-sm-12 row">
            <?php echo ($flag_cheku)? form_checkbox(array("name"=>"flagcheck[1]","id"=>"check_flag" ,"checked"=>"checked "))
                :form_checkbox(array("name"=>"flagcheck[1]","id"=>"check_flag" )); ?>
            <div class="slider round"></div>
            <span><?php echo _CHECKOU ?></span>
        </label>
    <div  class="checku row well col-sm-12 "  >
        <!-- Rounded switch -->
        <div class="row col-sm-12">
            <label><?php echo _DATE.__._CHECKOU?> :</label>

            <?php
            echo  form_input(array('id'=>'pcalreject2', 'class'=>"form-control pdate" ,"ng-show" => "enableCheck"));
            echo form_input(array("name"=>"datecheck","id"=>"datecheck","type"=>"hidden"));
            ?>
        </div>

        <div class="row col-sm-12">
            <label><?php echo _NAME_BANK?> :</label>
            <?php echo form_dropdown('bankcheck', $this->element->pselect("mali_banks", "name", null, _DEF_ELEMENT, "public = 1 "), @$tmp_params_array->bankcheck, $data);?>
        </div>

        <div class="row col-sm-12">
            <label><?php echo _BRANCH_BANK?> :</label>
            <?php echo form_input(array('id'=>'branch_bank',"value"=>@$tmp_params_array->branchcheck, 'name' => 'branchcheck','class'=>$def_css_class)); ?>
        </div>
        <div class="row col-sm-12">
            <label><?php echo _SERIAL?> :</label>
            <?php echo form_input(array('id'=>'serial',"value"=>@$tmp_params_array->serialcheck, 'name' => 'serialcheck','class'=>$def_css_class)); ?>
        </div>
        <div class="row col-sm-12">
            <label><?php echo _ACCOUNT_NUMBER_BANK?> :</label>
            <?php echo form_input(array('id'=>'acc_number', "value"=>@$tmp_params_array->accnumbercheck, 'name' => 'accnumbercheck','class'=>$def_css_class)); ?>
        </div>
        <div class="row col-sm-12">
            <label><?php echo _RECIVER_BANK?> :</label>
            <?php echo form_dropdown('reciverbankcheck', $this->element->pselect("mali_banks", "name", null, _DEF_ELEMENT, "private = 1 "), @$tmp_params_array->reciverbankcheck, $data);?>
        </div>
    </div>
<script >
    // checkstart
    $(".checku ").hide();
    $('#check_flag').change(function () {
        if($("#check_flag").is(':checked')) {
            $(".checku").show();
        }
        else {
            $(".checku").hide();
        }
    });
    $('#check_flag').change();
</script>
<!--check end-->

        </div>
<div class="row well col-sm-12">
    <label><?php echo _DES ?> :</label>
<?php echo form_textarea(array('name' => "des",'class'=>'form-control',"style"=>"height:80px",'paceholder'=>_DES ,"value"=>$detail["des"])) ?>
</div>
<div class="row well col-sm-12">
    <?php echo _CLIENT ?> :
    <?php echo $this->system->get_user_from_id($user_id, "name") . " -- " . $this->system->get_user_from_id($user_id, "tell"). " -- " . $this->system->get_user_from_id($user_id, "address") ?>
</div>


        <?php echo form_button(array('type' => "submit",'class'=>'btn-success btn-block btn-lg'), _SAVE) ?>


<?php echo form_close() ?>

<script type="text/javascript">

    $(document).ready(function() {

        var objCal1 = new AMIB.persianCalendar('pcalreject', {
            extraInputID: 'daterej',
            extraInputFormat: 'YYYY/MM/DD ',
            initialDate: '<?= printDate($detail["date"]) ?>'
        });
        var objCal1 = new AMIB.persianCalendar('pcalreject2', {
            extraInputID: 'datecheck',
            extraInputFormat: 'YYYY/MM/DD ',
            initialDate: '<?= printDate($detail["checku"]) ?>'
        });





    });



</script>
