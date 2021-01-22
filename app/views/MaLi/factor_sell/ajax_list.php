<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$CI =& get_instance();
$CI->load->library("Search");
$CI->load->library("Factor");
$CI->load->library('Piero_jdate');
$CI->load->library('Page');
?>
<div class=" col-lg-12 " >
    <div class="col-lg-2 alert alert-danger " > <b><?php echo   $CI->factor->get_level($level)["name"] ?></b>  </div>
    <div class="col-lg-2 alert alert-warning "><?php echo _JAME_KOL ?> : <?php echo number_format($tot)._R ?></div>
    <?php if ($this->system->get_setting("show_comision_list_factor")) : ?>
    <div class="col-lg-3 alert alert-success "><?php echo _JAME_KOL." "._COMMISSION ?> : <?php echo number_format($comtot)._R ?></div>
    <?php endif;?>
    <?php if ($this->system->get_setting("show_pay_on_factor_list")) : ?>
    <div class="col-lg-3 alert alert-warning "><?php echo _JAME_KOL." "._GET ?> : <?php echo number_format($gettot)._R ?></div>
    <div class="col-lg-2 alert alert-danger "><?php echo _REMIND ?> : <?php echo number_format($tot-$gettot)._R ?></div>
    <?php endif;?>
</div>
<table class="table table-hover table-striped dataTbl" >
    <thead>
        <td></td>
        <td>  <?php echo _ID?></td>
        <td><?php echo _FACTOR_NUM?></td>
        <td> <a style="color: #fff"   onclick="load_ajax('<?php echo site_url("MaLi/factor_sell/manage_factor/ajax_list") ?>','#ajax_load','<?php echo 'user_id='.$user_id."&sort=factor.user_id" ?>')"> <i class="fa fa-sort"></i> <?php echo _NAME?> </a>  </td>
        <td  > <a style="color: #fff"   onclick="load_ajax('<?php echo site_url("MaLi/factor_sell/manage_factor/ajax_list") ?>','#ajax_load','<?php echo 'user_id='.$user_id."&sort=factor.date" ?>')"> <i class="fa fa-sort"></i>  <?php echo _DATE.__._FACTOR?> </a> </td>
        <td> <a style="color: #fff"   onclick="load_ajax('<?php echo site_url("MaLi/factor_sell/manage_factor/ajax_list") ?>','#ajax_load','<?php echo 'user_id='.$user_id."&sort=factor.expire_date" ?>')"> <i class="fa fa-sort"></i> <?php echo _EXPIRE_FACTOR?> </a> </td>
        <td><?php echo _PRICE_FACTOR.__._R ?></td>
<!--        if comision enabled-->
        <?php if ($this->system->get_setting("show_comision_list_factor")) : ?>
        <td><?php echo _COMMISSION.__._R ?></td>
        <?php endif;?>
<!--        if pay enabled-->
        <?php if ($this->system->get_setting("show_pay_on_factor_list")) : ?>
        <td><?php echo _GETED.__._R ?></td>
        <td><?php echo _REMIND.__._R ?></td>
        <?php endif;?>
        <td><?php echo _MY_EMPLOY ?></td>
    </thead>
    <tbody>
<?php foreach ($db as $key => $value):?>
    <?php
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
    $id_factor=$value["id"];
    $dellink=site_url("MaLi/factor_sell/Manage_factor/manage_delete/".$id_factor);
    $levlink=site_url("MaLi/factor_sell/Manage_factor/manage_changelevel/".$id_factor);
    $edilink=site_url("MaLi/factor_sell/Manage_factor/edit/".$id_factor);
    $op=array();
    $level_pro=$CI->factor->get_level_info_from_factor_id($id_factor);

    // stock out or stock in
    if(1 ) {
        $reject_link= site_url("Stock/Stock_out/render_recipe");
        $op[]="<a class='btn' onclick=load_ajax_popup('$reject_link','id=$id_factor')> <i class='fa fa-cubes' ></i> "  . _RENDER_STOCK_RECEPI. ' </a>';
    }
    // stock out or stock in end

    if ($level_pro["show_pdf"] || $this->permission->is_admin()) {
        $op[]=anchor_popup("MaLi/factor_preview/Factor_sell_pre/index/".$id_factor, "<i class='fa fa-file-pdf-o' ></i> "._PRINT.__._FACTOR, $atts);
    }

    if ($level_pro["stock_in_recepie"] || $this->permission->is_admin()) {
        $op[]=anchor_popup("MaLi/factor_preview/Factor_sell_pre/index/$id_factor/4", "<i class='fa fa-file-pdf-o' ></i> "._PRINT.__._GHABZ.__._STOCK, $atts);
    }

    if ($level_pro["show_details"] || $this->permission->is_admin()) {
        $show_link= site_url("MaLi/factor_sell/manage_factor/view_details");
        $op[]="<a class=' btn  ' onclick=load_ajax_popup('$show_link','id=$id_factor')> <i class='fa fa-table' ></i> "  . _VIEW_FACTOR. ' </a>';
    }
    if ($level_pro["editable"] ||  $this->permission->check("factor_edit")) {
        $op[]="<a class='btn ' onclick=areyousure('link','$edilink')> <i class='fa fa-edit' ></i>  "  ._EDIT. '</a>';
    }
    if ($level_pro["removable"] || $this->permission->is_admin()) {
        $op[]="<a class='btn ' onclick=areyousure('link','$dellink')><i class='fa fa-close' ></i>"  ._DELETE. '</a>';
    }
    //daryaft pool
    if ($this->permission->is_admin()  ) {
        $get_link= site_url("MaLi/factor_sell/manage_factor/get_money");
        $op[]="<a class=' btn  ' onclick=load_ajax_popup('$get_link','id=$id_factor')> <i class='fa fa-dollar' ></i> " . _GET.' </a>';
    }
    //saier pardakhtha
    if ($this->permission->is_admin() || $this->permission->user_permision() ) {
        $other_pay_link= site_url("MaLi/factor_sell/manage_factor/other_pay");
        $op[]="<a class=' btn  ' onclick=load_ajax_popup('$other_pay_link','id=$id_factor')> <i class='fa fa-car' ></i> " . _OTHER_PAY.' </a>';
    }


    if ($level_pro["next_levels"] ) {
        if($this->factor->get_level($level_pro["next_levels"])["reject_form"] ) {
            $reject_link= site_url("MaLi/factor_sell/manage_factor/rejectform");
            $op[]="<a class=' btn  ' onclick=load_ajax_popup('$reject_link','id=$id_factor')> <i class='fa fa-share' ></i> "  . $this->factor->get_level($level_pro["next_levels"])["name"]. ' </a>';
        }
        else
        {
            $levlink=site_url("MaLi/factor_sell/Manage_factor/manage_changelevel/".$id_factor."/".$level_pro["next_levels"]);
            $op[]="<a class=' btn btn-primary ' onclick=areyousure('link','$levlink')> <i class='fa fa-share' ></i> "  . $this->factor->get_level($level_pro["next_levels"])["name"]. ' </a>';
        }
    }
    //class for today expire
    $expireclas=($CI->piero_jdate->jdate("Y/m/d", $value["expire_date"])==$CI->piero_jdate->jdate("Y/m/d", time()))?"expire_prd_orange":"";
    if ($type_in=="expire_all") {
        $expireclas=($value["expire_date"] < time())?"expire_prd_red":"";
        $expireclas=($CI->piero_jdate->jdate("Y/m", $value["expire_date"])==$CI->piero_jdate->jdate("Y/m", time()))?"expire_prd_orange":$expireclas;
    }
    ?>
    <tr class="<?php echo $expireclas ?>"  >
        <td>
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
        </td>
        <td><?php echo $value["id"]  ?></td>
        <td> <a class=' btn btn-default ' onclick=load_ajax_popup('<?php echo $show_link?>','id=<?php echo $id_factor ?>')> <i class='fa fa-eye' ></i> <?php echo  $value["factor_id"]  ?> </a></td>
        <td><?php echo $value["name"] ?>  <?php echo ($value["agent"])?"--".$value["agent"]:""; ?></td>
        <td><?php echo $CI->piero_jdate->jdate("Y/m/d", $value["date"])  ?></td>
        <td class="exp" ><?php echo $CI->piero_jdate->jdate("Y/m/d", $value["expire_date"])  ?></td>
        <td><?php echo number_format($value["total_factor"])   ?></td>
        <?php if ($this->system->get_setting("show_comision_list_factor")) : ?>
        <td><?php echo number_format($value["com"])   ?></td>
        <?php endif;?>

        <?php if ($this->system->get_setting("show_pay_on_factor_list")) : ?>
        <td>
            <?php if($this->permission->is_admin()) : ?>
                <a class=' btn  btn-default ' onclick=load_ajax_popup('<?php echo $get_link?>','id=<?php echo $id_factor?>')> <i class='fa fa-dollar' ></i>  </a>
            <?php endif; ?>
            <?php echo number_format($value["get"])  ?></td>

        <td><?php echo number_format($value["total_factor"]-$value["get"])   ?></td>
        <?php endif;?>
        <td><?php echo $value["namec"]  ?></td>
    </tr>
<?php endforeach; die();?>
    </tbody>
</table>
<script type="text/javascript" >
        $('.table').DataTable();
</script>
