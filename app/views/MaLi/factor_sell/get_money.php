<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$radif = 0;
$this->load->helper('form');
echo form_open("MaLi/factor_sell/manage_factor/get_moneypadd/" . $factor_id);
//print_r($detail_factor);
//        time
$this->load->library('Piero_jdate');
echo $this->template->load_custom_js("js-persian-cal.min");
echo $this->template->load_custom_css("js-persian-cal");

?>

<div class="row well col-sm-12">
    <?php echo _DATE ?> :
    <?php
    echo  form_input(array('id' => 'pcalreject', 'class' => "form-control pdate"));
    echo form_input(array("name" => "date", "id" => "daterej", "type" => "hidden"));

    ?>
</div>
<div class="row well col-sm-12">
    <div class="col-sm-9">
        <label><?php echo _GET_MONEY ?> :</label>
        <?php echo form_input(array('name' => "price", 'class' => 'form-control', 'paceholder' => _GET_MONEY)) ?>
    </div>
    <div class="col-sm-3">
        <label><?php echo _PAYOFF ?> :
            <?php echo form_checkbox(array('name' => "payoff", 'class' => 'form-control', 'value' => '1')) ?>
        </label>
    </div>
</div>

<div class="row well col-sm-12">
    <label><?php echo _DES ?> :</label>
    <?php echo form_textarea(array('name' => "des", 'class' => 'form-control', "style" => "height:80px", 'paceholder' => _DES)) ?>
</div>
<div class="row well col-sm-12">
    <?php echo _CLIENT ?> :
    <?php echo $this->system->get_user_from_id($detail_factor[0]["user_id"], "name") . " -- " . $this->system->get_user_from_id($detail_factor[0]["user_id"], "tell") . " -- " . $this->system->get_user_from_id($detail_factor[0]["user_id"], "address") ?>

</div>


<?php echo form_button(array('type' => "submit", 'class' => 'btn-success btn-block btn-lg'), _SAVE) ?>


<?php echo form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {

        var objCal1 = new AMIB.persianCalendar('pcalreject', {
            extraInputID: 'daterej',
            extraInputFormat: 'YYYY/MM/DD ',
            initialDate: '<?= printDate(); ?>'
        });


    });
</script>