<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('form');
echo form_open("Dashboard/change_PASS_p", array("id"=>"sdkljjkl"));
?>
<div class=" col-sm-12" >
    <h2 style="text-align: center" > <?php echo $this->system->get_user("name")  ?></h2>
    <div class="col-sm-12" >
        <label><?php echo _CURRENT_PASSWORD?></label>
        <?php echo form_input(array('name' => "old",'id' => "old",'class'=>'form-control','type'=>'password'))?>
    </div>
    <div class="col-sm-12" >
        <label><?php echo _NEW_PASSWORD ?></label>
        <?php echo form_input(array('name' => "neW",'id' => "neW",'class'=>'form-control','type'=>'password'))?>
    </div>
    <div class="col-sm-12" >
        <label><?php echo _RETYPE_NEW_PASSWORD ?></label>
        <?php echo form_input(array('name' => "vnew",'id' => "vnew",'class'=>'form-control','type'=>'password'))?>
    </div>

<div class="col-sm-12"><br><?php echo form_button(array('type' => "submit",'class'=>'btn-success btn-block btn-lg'), _SAVE) ?></div>
</div>

<script type="text/javascript">
    $("#sdkljjkl").on("submit",function(e){
        e.preventDefault();
        if($("new").val() == $("vnew").val() ){
            $("#sdkljjkl").submit();
        }else{
            alert("<?= _ERROR_RETYPE_PASSWORD ?>");
        }
    })
</script>
