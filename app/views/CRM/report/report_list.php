<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
echo $this->template->load_custom_js("js-persian-cal.min");
echo $this->template->load_custom_css("js-persian-cal");
$this->load->helper('form');
echo form_open('CRM/Report_work/report_list');
$attributes = array('class' => 'form', 'id' => 'form');
$def_css_class="form-control";
$data = array('class' => $def_css_class);
//$where=array("user.usergroup"=>"4","user.usergroup"=>"1");
$user= form_dropdown('user', $this->element->pselect("user_admin", "name"), post("user", true), $data);
$date_start= form_input(array('id'=>'date_start',"name"=>"date_start", 'class'=>" $def_css_class pdate"));
$date_end= form_input(array('id'=>'date_end',"name"=>"date_end", 'class'=>" $def_css_class pdate"));
$date_hidden_start=form_input(array("name"=>"dateh_start","id"=>"dateh_start","type"=>"hidden"));
$date_hidden_end=form_input(array("name"=>"dateh_end","id"=>"dateh_end","type"=>"hidden"));
$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SEARCH);

?>
    <div class="rowwell ">
    <div class="col-sm-3 well"><label for="type"><?php echo _NAME." "._USER ?></label><?php echo $user ?></div>
    <div class="col-sm-3 well"><label for="type"><?php echo _DATE." "._START ?></label><?php echo $date_start ?><?php echo $date_hidden_start ?></div>
    <div class="col-sm-3 well"><label for="type"><?php echo _DATE." "._END ?></label><?php echo $date_end ?><?php echo $date_hidden_end ?></div>
    <div class="col-sm-3 well" style="padding:32px;"><?php echo $savebtn ?></div>
<?php form_close() ?>

<?php echo $table_list ?>
        <script>
            var objCal1 = new AMIB.persianCalendar( 'date_start' ,{
                extraInputID: 'dateh_start',
                extraInputFormat: 'YYYY/MM/DD ',
                initialDate: '<?php echo $def_time_start ?>'
            });

            var objCal1 = new AMIB.persianCalendar( 'date_end' ,{
                extraInputID: 'dateh_end',
                extraInputFormat: 'YYYY/MM/DD ',
                initialDate: '<?php echo $def_time_end ?>'
            });



        </script>
