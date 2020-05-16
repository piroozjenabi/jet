<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$radif=0;
$this->load->helper('form');
echo form_open("MaLi/factor_sell/manage_factor/rejectformpadd/".$factor_id);
//print_r($detail_factor);
//        time
$this->load->library('Piero_jdate');
echo $this->template->load_custom_js("js-persian-cal.min");
echo $this->template->load_custom_css("js-persian-cal");

?>

<div class="row well col-sm-12">
    <?php echo _DATE ?> :
    <?php
    echo  form_input(array('id'=>'pcalreject', 'class'=>"form-control pdate"));
    echo form_input(array("name"=>"factor_date","id"=>"daterej","type"=>"hidden"));
    echo form_input(array("name"=>"parent_id","value"=>"$factor_id","type"=>"hidden"));

    ?>
</div><div class="row well col-sm-12">
    <?php echo _CLIENT ?> :
    <?php echo $this->system->get_user_from_id($detail_factor[0]["user_id"], "name") . " -- " . $this->system->get_user_from_id($detail_factor[0]["user_id"], "tell"). " -- " . $this->system->get_user_from_id($detail_factor[0]["user_id"], "address") ?>

</div>
<table  class=" table table-hover table-striped" >
<tr>
    <td>#</td>
    <td><?php echo _NAME ?></td>
    <td><?php echo _NUM ?></td>
</tr>
<?php  foreach ($detail_factor as $key => $value):
    $radif++;
    ?>

    <tr>
        <td><?php echo $radif ?></td>
        <td><?php echo form_input(array('name' => "prd[$radif]",'value'=>$value["id_prd"],'type'=>'hidden')) .form_input(array('name' => "price[$radif]",'value'=>$value["price"],'type'=>'hidden')) . $this->system->get_prd_from_id($value["id_prd"], "name") ?></td>
        <td><?php echo form_input(array('name' => "num[$radif]",'class'=>'form-control','type'=>'number','value'=>$value["num"]))?></td>
    </tr>







<?php endforeach; ?>

</table>
<div class="row well col-sm-12">
    <label><?php echo _DES ?> :</label>
<?php echo form_textarea(array('name' => "des",'class'=>'form-control',"style"=>"height:80px",'paceholder'=>_DES)) ?>
</div>
    </table>

        <?php echo form_button(array('type' => "submit",'class'=>'btn-success btn-block btn-lg'), _SAVE) ?>


<?php echo form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {

        var objCal1 = new AMIB.persianCalendar('pcalreject', {
            extraInputID: 'daterej',
            extraInputFormat: 'YYYY/MM/DD ',
            initialDate: '<?php echo $this->system->return_time_persian(); ?>'
        });


    });
</script>
