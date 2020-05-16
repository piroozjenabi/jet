<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$this->load->helper('form');
echo form_open('CRM/Report_work/add_report_work_submit');
$name=form_input(array("name"=>"name[1]","class"=>"form-control","placeholder"=>_TYPE_YOUR_REPORT , "onchange" => "add_task()"));
$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);


?>
<div class="row  well ">

    <div class="col-sm-2 well" style="padding:32px;"><div class="btn btn-success btn-block  " onclick="add_task()" > <?php echo _ADD ?> </div> </a>
    </div>
    <div class="col-sm-5 well" style="padding:32px;"> <a href="<?php echo site_url() ?>" class="btn btn-danger btn-block .btn-lg "><?php echo _CANCEL ?></a>
    </div>
    <div class="col-sm-5 well" style="padding:32px;"> <?php echo $savebtn ?> </div>
</div>
<div class="row  well " id="tasks">
    <div class="row  well ">
    <?php echo $name ?>
    </div>
</div>


<?php form_close() ?>
<script type="text/javascript">
    var _row =2;
    add_task();
    function add_task() {
        $("#tasks").append( '<div class="row  well ">'+'<?php echo $this->element->rep_ele($name, "1", "'+_row+'") ?>'+'</div>');
        _row++;
    }

</script>
