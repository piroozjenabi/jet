<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo $this->template->load_custom_js("js-persian-cal.min");
echo $this->template->load_custom_css("js-persian-cal");

$this->load->helper('form');
$attributes = array('class' => 'form', 'id' => 'form');
if (@$mode="edit" && $detail_stk[0]["id"]) {
    echo form_open('Stock/Stock/padd_check', $attributes);
}
else
{
    $detail_stk[0] = array("prd_id" => "" , "date"=>"","dateexpire"=>"","prd"=>"","stock_id"=>"","num"=>"0"
    ,"pro_forma" => "" , "des"=>"" ,"date"=>$def_time,"expire_date"=>$def_time);
    echo form_open('Stock/Stock/padd_check', $attributes);
}
//type product
$def_css_class="form-control";
$data = array('class' => $def_css_class);
$prd=form_dropdown('prd_id', $this->element->pselect("prd"), $detail_stk[0]["prd_id"], $data);
$stock=form_dropdown('stock_id', $this->element->pselect("stock"), $detail_stk[0]["stock_id"], $data);


$num= form_input(array('value'=> $detail_stk[0]["num"],'id'=>'num', 'placeholder' => _NUM,'name' => 'num','class'=>$def_css_class));
$des= form_input(array('value'=> $detail_stk[0]["des"],'id'=>'num', 'placeholder' => _DES,'name' => 'des','class'=>$def_css_class));

//date system
$date= form_input(array('id'=>'pcal1', 'class'=>$def_css_class." pdate"));
$date_hidden=form_input(array("name"=>"date","id"=>"date","type"=>"hidden"));
$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);

?>
    <div class="row  well ">

        <div class="col-sm-6 well"><label for="type"><?php echo _PRD ?></label><?php echo $prd ?></div>

        <div class="col-sm-3 well" > <label for="type"><?php echo _STOCK ?></label><?php echo $stock ?></a>
        </div>
        <div class="col-sm-3 well" style="padding:32px;"> <?php echo $savebtn ?> </div>
    </div>
    <div class="row well">
    <div class="col-sm-3 well"><label for="vahed_asli"><?php echo _DATE_END ?></label><?php echo $date.$date_hidden ?></div>
    <div class="col-sm-3 well"><label for="barcode"><?php echo _NUM?></label><?php echo $num ?></div>
    <div class="col-sm-6 well"><label ><?php echo _DES ?></label><?php echo $des ?></div>

    <div class="row well">




    </div>



<?php echo form_close(); ?>
        <script>
            var objCal1 = new AMIB.persianCalendar( 'pcal1' ,{
                extraInputID: 'date',
                extraInputFormat: 'YYYY/MM/DD ',
                initialDate: '<?php echo $detail_stk[0]["date"] ?>'
            });
            var objCal = new AMIB.persianCalendar( 'pcal2' ,{
                extraInputID: 'expire',
                extraInputFormat: 'YYYY/MM/DD ',
                initialDate: '<?php echo $detail_stk[0]["expire_date"] ?>'
            });

        </script>
