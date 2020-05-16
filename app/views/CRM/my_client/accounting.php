<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$this->load->library("Bed_beslib");
$all_price=0;
$all_get=0;
$c=0;
?>
<div class="btn-group">

<div class="dropdown  btn btn-primary">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-money" ></i> <?= _BEDEHKARAN?>
        <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li><a href="<?= site_url("CRM/my_client/acounting/debtor/day") ?>"><?= _TO.__. _DAY.__._CURRENT?></a></li>
        <li><a href="<?= site_url("CRM/my_client/acounting/debtor/mounth") ?>"><?= _TO.__._MOUNTH.__._CURRENT?></a></li>
        <li><a href="<?= site_url("CRM/my_client/acounting/debtor") ?>"><?= _KOL?></a></li>
    </ul>
</div>
<div class="dropdown  btn btn-primary">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-life-buoy" ></i> <?= _FACTOR._S?>
        <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li><a href="<?= site_url("CRM/my_client/acounting/factor/week") ?>"><?= _WEEK.__._CURRENT?></a></li>
        <li><a href="<?= site_url("CRM/my_client/acounting/factor/mounth") ?>"><?= _MOUNTH.__._CURRENT?></a></li>
    </ul>
</div>

<div class="dropdown  btn btn-primary">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-download" ></i> <?= _DARIAFTI ?>
        <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li><a href="<?= site_url("CRM/my_client/acounting/bes/day") ?>"><?= _DAY.__._CURRENT?></a></li>
        <li><a href="<?= site_url("CRM/my_client/acounting/bes/week") ?>"><?= _WEEK.__._CURRENT?></a></li>
        <li><a href="<?= site_url("CRM/my_client/acounting/bes/mounth") ?>"><?= _MOUNTH.__._CURRENT?></a></li>
        <li><a href="<?= site_url("CRM/my_client/acounting/bes/kol") ?>"><?= _KOL?></a></li>
    </ul>
</div>
    <div class="dropdown  btn btn-primary">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-expand" ></i> <?= _EXPORT ?>
            <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li> <a onclick="printp('acc_body')" type="button"   > <i class="fa fa-print"></i> <?= _PRINT ?> </a></li>
        </ul>
    </div>
</div>
<div id="acc_body">
<table class="table table-hover table-striped dataTbl" id="datatable"  >
    <thead>
    <tr>
    <td>#</td>
    <td><?=_ID ?></td>
    <td><?=_NAME ?></td>
    <td><?=_TOTAL_PLUS._R ?></td>
    <td><?=_TOTAL_PLUS.__._DARIAFTI._R ?></td>
    <td><?=_REMIND._R?></td>
    <td><?= _DATE.__._LAST.__._FACTOR ?></td>
    <td><?= _DATE.__._LAST.__._GET?></td>
    <td><?= _KARSHENAS?></td>
    <td class="dis_print"> <?=_OP ?></td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($res as $key => $value):
        //    print_r($value);
        $all_price +=$value['total_price'];
        $all_get +=$value['total_dariafti'];
        //view ajax
        $show_link= site_url("MaLi/pusers/Users/show_details") ;
        $opv="<a class=' btn btn-default ' onclick=load_ajax_popupfull('$show_link','id=".$value["id"]."','full')> <i class='fa fa-eye' ></i> "  . $value['perfix_code'] . $value['id']. ' </a>';
        //view bill ajax
        $show_link_bill= site_url("MaLi/pusers/Users/show_bill") ;
        $opbill="<a class=' btn btn-danger ' onclick=load_ajax_popupfull('$show_link_bill','id=".$value["id"]."','full')> <i class='fa fa-eye' ></i> "  ._BILL. ' </a>';
        //pardakht ajax
        if($this->permision->check("base_accounting"))
        {
            $get_link= site_url("MaLi/Bed_bes/ajax_get/") ;
            $opp="<a class=' btn btn-danger ' onclick=load_ajax_popup('$get_link','group_id=0&user_id=".$value["id"]."')> <i class='fa fa-dollar' ></i>  </a>";
        }
        else
        {$opp="";}
        $c++;
        ?>
        <tr>
            <td><?= $c  ?></td>
            <td><?= $opv  ?></td>
            <td>
                <p data-toggle="tooltip" data-placement="bottom"  title="<?= $value['address'] . " - " .$value['tell']. " - " .$value['mobile'] ?>" >
                    <?= $value['name'] ?>
                    <?php if($value["agent"])
                        echo  "-". $value['agent'];
                    ?>
                </p>
            </td>
            <td><?= number_format($value['total_price']) ?></td>
            <td><?= number_format($value['total_dariafti']) ?></td>
            <td><?= number_format($value['remind']) ?></td>
            <td><?=$this->piero_jdate->jdate("Y/m/d",$value['last_date']);  ?></td>
            <td> <p  data-toggle="tooltip" data-placement="bottom"  title="<?=number_format($value['last_get_price']) ._R ?> " > <?= ($value['last_get_date'])?$this->piero_jdate->jdate("Y/m/d",$value['last_get_date']):null;  ?> </p></td>
            <td><?= @$this->system->get_user_eemploy_from_id($value['maker_id']) ;  ?></td>
            <td class="dis_print" >
                <?=$opp  ?>
                <a class='btn btn-info' href='<?= site_url("CRM/my_client/tracks/".$value["id"]) ?>'> <i class="fa fa-list-alt"></i> <?= _PEIGIRI._S ?> </a>
                <?= $opbill ?>
            </td>
        </tr>


    <?php endforeach; ?>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td><?= _TOTAL_PLUS ?></td>
        <td> <?= number_format($all_price) ?></td>
        <td> <?= number_format($all_get) ?></td>
        <td> <?= number_format($all_price-$all_get) ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
    </tbody>
</table>
</div>
