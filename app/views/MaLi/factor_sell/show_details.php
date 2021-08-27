<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();

$radif=0;
$CI->load->model('MaLi/Factor_sell_model');
$CI->load->model('MaLi/Comission_model');
$CI->load->library("Factor");
$tprice=0;
$tnum=0;
$tnumc=0;
$ttprice=0;
//other price
$tpriceoth=0;
$radifoth=0;

//opartions drop down menu
$atts = array(
    'width'      => '_w',
    'height'     => '_h',
    'scrollbars' => 'yes',
    'status'     => 'yes',
    'resizable'  => 'yes',
    'screenx'    => '0',
    'screeny'    => '0',
    'class'       =>'btn btn-default',
);
$id_factor=$factor_id;
$dellink=site_url("MaLi/factor_sell/Manage_factor/manage_delete/".$id_factor);
$levlink=site_url("MaLi/factor_sell/Manage_factor/manage_change_level/".$id_factor);
$edilink=site_url("MaLi/factor_sell/Manage_factor/edit/".$id_factor);
$op=array();
$level_pro=$CI->factor->get_level_info_from_factor_id($id_factor);

if ($level_pro["stock_in_recepie"] || $this->permission->is_admin()) {
    $op[]=anchor_popup("MaLi/factor_preview/Factor_sell_pre/index/$id_factor/4", "<i class='fa fa-file-pdf-o' ></i> "._PRINT.__._GHABZ.__._STOCK, $atts);
}

if ($level_pro["show_details"] || $this->permission->is_admin()) {
    $show_link= site_url("MaLi/factor_sell/manage_factor/view_details");
    $op[]="<a class=' btn btn-link ' onclick=load_ajax_popup('$show_link','id=$id_factor')> <i class='fa fa-table' ></i> "  . _VIEW_FACTOR. ' </a>';
}
if ($level_pro["editable"] ||  $this->permission->check("factor_edit")) {
    $op[]="<a class='btn btn-link' onclick=areyousure('link','$edilink')> <i class='fa fa-edit' ></i>  "  ._EDIT. '</a>';
}
if ($level_pro["removable"] || $this->permission->is_admin()) {
    $op[]="<a class='btn btn-link' onclick=areyousure('link','$dellink')><i class='fa fa-close' ></i>"  ._DELETE. '</a>';
}
//daryaft pool
if ($this->permission->is_admin()  ) {
    $get_link= site_url("MaLi/factor_sell/manage_factor/get_money");
    $op[]="<a class=' btn btn-link ' onclick=load_ajax_popup('$get_link','id=$id_factor')> <i class='fa fa-dollar' ></i> " . _GET.' </a>';
}
//saier pardakhtha
if ($this->permission->is_admin() || $this->permission->user_permision() ) {
    $other_pay_link= site_url("MaLi/factor_sell/manage_factor/other_pay");
    $op[]="<a class=' btn btn-link ' onclick=load_ajax_popup('$other_pay_link','id=$id_factor')> <i class='fa fa-car' ></i> " . _OTHER_PAY.' </a>';
}

if(isset($detail_factor[0]["params"])){
    $paramstmp=json_decode($detail_factor[0]["params"]);
}
?>

    <div class="row well col-sm-12">
    <div class=" col-lg-3">
        <div class="dropdown">
            <button class="btn btn-default btn-lg dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li role="presentation" class="dropdown-header"><?php echo _OP ?></li>
                <?php foreach ($op as $key2): ?>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"> <?php echo $key2 ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        </div>


    <div class="col-lg-3">    <?php echo _FACTOR_NUM?> :<?php echo $detail_factor[0]["id"]  ?></div>
    <div class="col-lg-3">    <?php echo _DATE.__. _FACTOR  ?> :<?= printDate($detail_factor[0]["date"]) ?></div>
    <div class="col-lg-3">    <?php echo _EXPIRE?> :<?= printDate($detail_factor[0]["expire_date"])  ?></div>


</div>
<div class="row well col-sm-12">
    <div class="col-lg-4">    <?php echo _MAKER ?> :<?php echo $this->system->get_user_admin_from_id($detail_factor[0]["maker_id"], "name")  ?></div>
    <div class="col-lg-4">   <?php echo _TOTAL_PLUS?> : <?php echo price($CI->Factor_sell_model->show_total_price($factor_id))  ?></div>
    <div class="col-lg-4">  <?php if(1) :?>  <?php echo _COMMISSION ?> :<?php echo price($CI->Comission_model->commison_factor($factor_id))  ?> <?php
   endif; ?></div>

    </div>



<div class="row well col-sm-12">
    <?php echo _CLIENT ?> :
    <?php echo $this->system->get_user_from_id($detail_factor[0]["user_id"], "name") . " -- " . $this->system->get_user_from_id($detail_factor[0]["user_id"], "tell"). " -- ". $this->system->get_user_from_id($detail_factor[0]["user_id"], "mobile"). " -- " . $this->system->get_user_from_id($detail_factor[0]["user_id"], "address") ?>

</div>
<div class="row well col-sm-12">
    <?php echo _DES  ?> :<?php echo $detail_factor[0]["des"]?>
</div>
<?php if (@$paramstmp->delivery_address1 || @$paramstmp->delivery_address2) :  ?>
<div class="row well col-sm-12">
    <?php echo _ADDRESS.__._DELIVERY ?> :<?php echo $paramstmp->delivery_address1?> <br><?php echo $paramstmp->delivery_address2?>
</div>
<?php endif; ?>
<!-------------------------------------------------show _prd -->
<table  class=" table table-hover table-striped " >
    <thead>
<tr>
    <td>#</td>
    <td><?php echo _NAME ?></td>
    <td><?php echo _NUM ?></td>
    <td><?php echo _NUM ?> <?php echo config("perfix_alt_unit_fa")?></td>
    <td><?php echo _PRICE._R?></td>

    <td><?php echo _TOTAL_PLUS._R ?></td>
</tr>
    </thead>
    <?php  foreach ($detail_factor as $key => $value):
        $radif++;
        $tprice +=$value["price"];
        $tnum +=$value["num"];
        $ttprice += $value["num"]*$value["price"]-$value["takhfif"];
        ?>

        <tr>
            <td><?php echo $radif ?></td>
            <td><?php echo  $this->system->get_prd_from_id($value["id_prd"], "name") ?></td>
            <td><?php echo $value["num"]?></td>

            <td><?php echo ($value["price"]>0)?price($value["price"]):_FREE?></td>

            <td><?php echo ($value["price"]>0)?price($value["num"]*$value["price"]-$value["takhfif"]):_FREE?></td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
    <tr>
        <td></td>
        <td> <?php echo _TOTAL_PLUS ?></td>
        <td><?php echo $tnum ?></td>
        <td><?php echo $tnumc ?></td>
        <td><?php echo price($tprice) ?></td>
        <td><?php echo price($ttprice)?></td>

    </tr>
    </tfoot>

</table>

<!--//---------------------------------------------------other_pay-->
<?php if ($other_pay) : ?>
<table  class=" table table-hover table-striped" >
    <caption style="text-align: center">
        <?php echo _OTHER_PAY ?>
    </caption>
    <thead>
<tr>
    <td>#</td>
    <td><?php echo _DES ?></td>
    <td><?php echo _PRICE ?></td>
    <td> </td>
</tr>
    </thead>
    <?php  foreach ($other_pay as $key => $value):
        $radifoth++;
        $tpriceoth +=$value["price"];
        ?>

        <tr>
            <td><?php echo $radifoth ?></td>
            <td><?php echo $this->element->edit_text($value["id"], $value["des"], "factor_other_pay", "des", "text") ?></td>
            <td><?php echo $this->element->edit_text($value["id"], $value["price"], "factor_other_pay", "price", "number") ?></td>

        </tr>
    <?php endforeach; ?>
    <tfoot>
    <tr>
        <td></td>
        <td></td>

        <td><?= price($tpriceoth) ?></td>
<td></td>

    </tr>
    </tfoot>
</table>

<?php endif; ?>
<div class="row well col-sm-12">



</div>
