<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//load library date

echo $this->template->load_custom_js("js-persian-cal.min");
echo $this->template->load_custom_css("js-persian-cal");

$this->load->helper('form');
$attributes = array('class' => 'form', 'id' => 'form');
if (@$mode="edit" && $detail_stk[0]["id"]) {

    echo form_open('Stock/Stock_in/padd/'.$detail_stk[0]["id"], $attributes);
}
else
{
    $detail_stk[0] = array("prd_id" => "" , "date"=>"","dateexpire"=>"","prd"=>"","num"=>"0"
    ,"pro_forma" => "" , "des"=>"", "lot"=>"", "stock_id"=>"" ,"date"=>$def_time,"expire_date"=>$def_time);
    echo form_open('Stock/Stock_in/padd/', $attributes);
}
//type product
$def_css_class="form-control";
$data = array('class' => $def_css_class);
$prd=form_dropdown('prd_id', $this->element->pselect("prd"), $detail_stk[0]["prd_id"], $data);
$stock=form_dropdown('stock_id', $this->element->pselect("stock"), $detail_stk[0]["stock_id"], $data);


$pro_forma= form_input(array('value'=> $detail_stk[0]["pro_forma"],'id'=>'pro_forma', 'placeholder' => _PRO_FORMA,'name' => 'pro_forma','class'=>$def_css_class));
$num= form_input(array('value'=> $detail_stk[0]["num"],'id'=>'num', 'placeholder' => _NUM,'name' => 'num','class'=>$def_css_class));
$des= form_input(array('value'=> $detail_stk[0]["des"],'id'=>'num', 'placeholder' => _DES,'name' => 'des','class'=>$def_css_class));
$lot= form_input(array('value'=> $detail_stk[0]["lot"],'id'=>'num', 'placeholder' => _LOT,'name' => 'lot','class'=>$def_css_class));

//date system
$date= form_input(array('id'=>'pcal1', 'class'=>$def_css_class." pdate"));
$expire= form_input(array('id'=>'pcal2','class'=>$def_css_class." pdate"));
$expire_hidden=form_input(array("name"=>"expire", "id"=>"expire","type"=>"hidden"));
$date_hidden=form_input(array("name"=>"date","id"=>"date","type"=>"hidden"));

$savebtn= form_button(array('type' => "submit",'id' => 'submit','class'=>'btn btn-success btn-block .btn-lg '), _SAVE);
$advancedbtn= form_button(array('data-toggle' => "modal",'data-target' => '#advanced_info','class'=>'btn btn-info btn-block'), _ADVANCED_SETTING);

?>
    <div class="row  well ">

        <div class="col-sm-6 well"><label for="type"><?php echo _PRD ?></label><?php echo $prd ?></div>

        <div class="col-sm-3 well" style="padding:32px;"> <a href="<?php echo site_url() ?>" class="btn btn-danger btn-block .btn-lg "><?php echo _CANCEL ?></a>
        </div>
        <div class="col-sm-3 well" style="padding:32px;"> <?php echo $savebtn ?> </div>
    </div>
    <div class="row well">
    <div class="col-sm-3 well"><label for="name"><?php echo _DATE ?></label><?php echo $expire.$expire_hidden ?></div>
    <div class="col-sm-3 well"><label for="vahed_asli"><?php echo _DATE_END ?></label><?php echo $date.$date_hidden ?></div>
    <div class="col-sm-3 well"><label for="company_maker"><?php echo _PRO_FORMA ?></label><?php echo $pro_forma ?></div>
    <div class="col-sm-3 well"><label for="barcode"><?php echo _NUM?></label><?php echo $num ?></div>
    <div class="col-sm-3 well"><label ><?php echo _LOT?></label><?php echo $lot ?></div>
    <div class="col-sm-3 well"><label ><?php echo _STOCK?></label><?php echo $stock ?></div>
    <div class="col-sm-6 well"><label ><?php echo _DES ?></label><?php echo $des ?></div>

    <div class="row well">


        <div class="col-sm-6 well"><?php echo $advancedbtn ?> </div>


    </div>


    <!-- advanced seting by piero.ir -->
    <div class="modal fade" id="advanced_info" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo _ADVANCED_SETTING ?></h4>
                </div>
                <div class="modal-body">
---
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _CLOSE ?> </button>
                </div>
            </div>

        </div>
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
