<?php defined('BASEPATH') OR exit('No direct script access allowed');
$radif=0;
$this->load->helper('form');
echo form_open("Stock/Stock/ptransfer");
//print_r($detail_factor);
//        time
$this->load->library('Piero_jdate');
echo $this->template->load_custom_js("js-persian-cal.min");
echo $this->template->load_custom_css("js-persian-cal");
$def_css_class="form-control";
$data = array('class' => $def_css_class,"style"=>"width:90%");
?>
<div class="row well">
<div class="row col-sm-6">
    <?php echo _DATE ?> :
    <?php echo form_input(array('id'=>'pcalreject1', 'class'=>"form-control pdate", "style"=>"width:90%")); ?>
    <?php echo form_input(array("name"=>"date","id"=>"daterej","style"=>"display:none")); ?>
</div>
<div class="row col-sm-6">
    <label><?php echo _NUM.__._TRANSFER?> :</label>
    <?php echo form_input(array('name' => "num",'class'=>$def_css_class,'paceholder'=>_NUM , "style"=>"width:90%")) ?>
</div>
    <div class="row  col-sm-6">
    <label><?php echo _STOCK.__._SOURCE?> :</label>
    <?php echo form_dropdown('stock_source', $this->element->pselect("stock"), 0, $data); ?>
    </div>
    <div class="row  col-sm-6">
    <label><?php echo _STOCK.__._DEST?> :</label>
    <?php echo form_dropdown('stock_dest', $this->element->pselect("stock"), 0, $data); ?>
    </div>
    <div class="row col-sm-6">
    <label><?php echo _PRD.__._SOURCE?> :</label>
    <?php echo form_dropdown('prd_source', $this->element->pselect("prd"), 0, $data); ?>
    </div>
    <div class="row col-sm-6">
    <label><?php echo _PRD.__._DEST?> :</label>
    <?php echo form_dropdown('prd_dest', $this->element->pselect("prd"), 0, $data); ?>
    </div>
    <div class="row col-sm-6">
    <label><?php echo _PRO_FORMA?> :</label>
    <?php echo form_input(array('name' => "proforma",'class'=>'form-control','paceholder'=>_PRO_FORMA, "style"=>"width:90%")) ?>
    </div>
    <div class="row col-sm-6">
    <label><?php echo _LOT?> :</label>
    <?php echo form_input(array('name' => "lot",'class'=>'form-control','paceholder'=>_LOT, "style"=>"width:90%")) ?>
    </div>
    <div class="row col-sm-12">
        <label><?php echo _DES ?> :</label>
    <?php echo form_textarea(array('name' => "des",'class'=>'form-control',"style"=>"height:80px",'paceholder'=>_DES)) ?>
</div>
</div>
        <?php echo form_button(array('type' => "submit",'class'=>'btn btn-success btn-block'), _SAVE) ?>


<?php echo form_close() ?>

<script type="text/javascript">

        var objCal1 = new AMIB.persianCalendar('pcalreject1', {
            extraInputID: 'daterej',
            extraInputFormat: 'YYYY/MM/DD ',
            initialDate: '<?= printDate(); ?>'
        });




</script>
