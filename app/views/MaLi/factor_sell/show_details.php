<?php defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$index = $tprice = $tnum = $tnumc = $ttprice = $tpriceoth = $indexoth = 0;
$op = [];

$paramsTmp = isset($detail_factor[0]["params"]) ? json_decode($detail_factor[0]["params"]) : [];

$dellink = site_url("MaLi/factor_sell/Manage_factor/manage_delete/{$id}");
$levlink = site_url("MaLi/factor_sell/Manage_factor/manage_change_level/{$id}");
$edilink = site_url("MaLi/factor_sell/Manage_factor/edit/{$id}");

if ($level["stock_in_recepie"] || $this->permission->is_admin()) {
    $op[] = anchor_popup("MaLi/factor_preview/Factor_sell_pre/index/$id/4", "<i class='fa fa-file-pdf-o' ></i> " . _PRINT . __ . _GHABZ . __ . _STOCK, 'default');
}

if ($level["show_details"] || $this->permission->is_admin()) {
    $show_link = site_url("MaLi/factor_sell/manage_factor/view_details");
    $op[] = "<a class=' btn btn-link ' onclick=load_ajax_popup('$show_link','id=$id')> <i class='fa fa-table' ></i> "  . _VIEW_FACTOR . ' </a>';
}
if ($level["editable"] ||  $this->permission->check("factor_edit")) {
    $op[] = "<a class='btn btn-link' onclick=areyousure('link','$edilink')> <i class='fa fa-edit' ></i>  "  . _EDIT . '</a>';
}
if ($level["removable"] || $this->permission->is_admin()) {
    $op[] = "<a class='btn btn-link' onclick=areyousure('link','$dellink')><i class='fa fa-close' ></i>"  . _DELETE . '</a>';
}
//get money
if ($this->permission->is_admin()) {
    $get_link = site_url("MaLi/factor_sell/manage_factor/get_money");
    $op[] = "<a class=' btn btn-link ' onclick=load_ajax_popup('$get_link','id=$id')> <i class='fa fa-dollar' ></i> " . _GET . ' </a>';
}
//other pay
if ($this->permission->is_admin() || $this->permission->user_permision()) {
    $other_pay_link = site_url("MaLi/factor_sell/manage_factor/other_pay");
    $op[] = "<a class=' btn btn-link ' onclick=load_ajax_popup('$other_pay_link','id=$id')> <i class='fa fa-car' ></i> " . _OTHER_PAY . ' </a>';
}

?>
<div class="row well col-sm-12">

    <div class="col-sm-10">
        <b><?= _CLIENT ?> :
            <?= $this->system->get_user_from_id($detail_factor[0]["user_id"], "name") . " -- " . $this->system->get_user_from_id($detail_factor[0]["user_id"], "tell") . " -- " . $this->system->get_user_from_id($detail_factor[0]["user_id"], "mobile") . " -- " . $this->system->get_user_from_id($detail_factor[0]["user_id"], "address")  ?>
    </div>
    <div class="col-sm-2">
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">
                <span class="caret"></span> </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li role="presentation" class="dropdown-header"><?= _OP ?></li>
                <?php foreach ($op as $key2) : ?>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"> <?= $key2 ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div class="row well col-sm-12">


    <div class="col-sm-2"> <b><?= _ID ?> </b> :<?= $detail_factor[0]["id"] ?> </div>

    <div class="col-sm-5"> <b><?= _DATE . __ . _FACTOR  ?> </b> : <?= printDate($detail_factor[0]["date"]) ?></div>
    <div class="col-sm-5"> <b><?= _EXPIRE ?> </b> :<?= printDate($detail_factor[0]["expire_date"])  ?></div>
</div>

<div class="row well col-sm-12">
    <div class="col-sm-4"> <b><?= _MAKER ?> </b> : <?= $this->system->get_user_admin_from_id($detail_factor[0]["maker_id"], "name")  ?></div>
    <div class="col-sm-4"> <b><?= _TOTAL_PLUS ?> </b> : <?= price($CI->Factor_sell_model->show_total_price($id))  ?></div>
    <div class="col-sm-4"> <b><?= _COMMISSION ?> </b> : <?= price($CI->Comission_model->commison_factor($id))  ?> </div>

</div>



<div class="row well col-sm-12">
    <?= _DES  ?> :<?= $detail_factor[0]["des"] ?>
</div>
<?php if (@$paramsTmp->delivery_address1 || @$paramsTmp->delivery_address2) :  ?>
    <div class="row well col-sm-12">
        <?= _ADDRESS . __ . _DELIVERY ?> :<?= $paramsTmp->delivery_address1 ?> <br><?= $paramsTmp->delivery_address2 ?>
    </div>
<?php endif; ?>
<!-------------------------------------------------show _prd -->
<table class=" table table-hover table-striped ">
    <thead>
        <tr>
            <td>#</td>
            <td><?= _NAME ?></td>
            <td><?= _NUM ?></td>
            <td><?= _PRICE . _R ?></td>

            <td><?= _TOTAL_PLUS . _R ?></td>
        </tr>
    </thead>
    <?php foreach ($detail_factor as $key => $value) :
        $index++;
        $tprice += $value["price"];
        $tnum += $value["num"];
        $ttprice += $value["num"] * $value["price"] - $value["takhfif"];
    ?>

        <tr>
            <td><?= $index ?></td>
            <td><?= $this->system->get_prd_from_id($value["id_prd"], "name") ?></td>
            <td><?= $value["num"] ?></td>

            <td><?= ($value["price"] > 0) ? price($value["price"]) : _FREE ?></td>

            <td><?= ($value["price"] > 0) ? price($value["num"] * $value["price"] - $value["takhfif"]) : _FREE ?></td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <td></td>
            <td> <?= _TOTAL_PLUS ?></td>
            <td><?= $tnum ?></td>
            <td><?= price($tprice) ?></td>
            <td><?= price($ttprice) ?></td>

        </tr>
    </tfoot>

</table>

<!--//---------------------------------------------------other_pay-->
<?php if ($other_pay) : ?>
    <table class=" table table-hover table-striped">
        <caption style="text-align: center">
            <?= _OTHER_PAY ?>
        </caption>
        <thead>
            <tr>
                <td>#</td>
                <td><?= _DES ?></td>
                <td><?= _PRICE ?></td>
                <td> </td>
            </tr>
        </thead>
        <?php foreach ($other_pay as $key => $value) :
            $indexoth++;
            $tpriceoth += $value["price"];
        ?>

            <tr>
                <td><?= $indexoth ?></td>
                <td><?= $this->element->edit_text($value["id"], $value["des"], "factor_other_pay", "des", "text") ?></td>
                <td><?= $this->element->edit_text($value["id"], $value["price"], "factor_other_pay", "price", "number") ?></td>

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
