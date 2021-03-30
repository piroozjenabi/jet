<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();

$radif=0;
$CI->load->model('MaLi/Factor_sell_model');
$CI->load->model('MaLi/Comission_model');
$CI->load->library('factor');
$CI->load->library('bed_beslib');
//get levels
$levelsar=$CI->factor->get_level_list("bed_bes");
$tprice=0;
$ttprice=0;
$allprice=0;

?>
    <div class="col-sm-3 well" style="min-height: 70px;">    <?php echo _NAME?> :<?php echo $detail_users[0]["name"]  ?>.<?php echo $detail_users[0]["agent"] ?> </div>
    <div class="col-sm-3 well" style="min-height: 70px;">    <?php echo _MAKE  ?> :<?php echo $CI->piero_jdate->jdate("Y/m/d", $detail_users[0]["date_create"]) ?>
    <?php echo _MODIFY  ?> :<?php echo $CI->piero_jdate->jdate("Y/m/d", $detail_users[0]["date_modify"]) ?></div>
    <div class="col-sm-6 well" style="min-height: 70px;">
    <?php echo $detail_users[0]["address"] ?> , <?php echo $detail_users[0]["tell"] ?> , <?php echo $detail_users[0]["mobile"] ?></div>

<?php foreach ($levelsar as $k => $v): ?>
    <div data-toggle="collapse" data-target="#<?php echo $v["id"] ?>" style="text-align: center" class="btn btn-default"  > <h3> <?php echo _LIST . $v["des"] ?> </h3></div>
    <div id="<?php echo $v["id"] ?>" class="collapse" >
<table  class=" table table-hover table-striped" >
    <thead>
<tr>
    <td><?php echo _ID ?></td>
    <td><?php echo _MABLAGH._R ?></td>
    <td><?php echo _DATE ?></td>
    <?php if($v["expirable"]) :?><td><?php echo _EXPIRE ?></td><?php
    endif; ?>
    <td <?php echo (!$this->system->get_setting("display_eemployer_on_print_client_detials"))?'class="dis_print"':''; ?> ><?php echo _KARSHENAS ?></td>
    <td class="dis_print" > </td>
</tr>
    </thead>
    <?php
    $tprice=0;
    $faer=$CI->factor->get_list_factor_from_user($detail_users[0]["id"], $v["id"]);

    if(count($faer)) : ?>
    <?php foreach ($faer as $key => $value):
        $value["price"]=$CI->factor->price($value["id"]);
        $id_factor=$value["id"];
        $tprice +=$value["price"];
        $show_link= site_url("MaLi/factor_sell/manage_factor/view_details");
        $op="<a class=' btn btn-default ' onclick=load_ajax_popup('$show_link','id=$id_factor','normal')> <i class='fa fa-eye' ></i> "  . _VIEW_FACTOR. ' </a>';
        ?>
        <tr>
            <td><?php echo $value["factor_id"] ?></td>
            <td><?php echo number_format($value["price"])?></td>
            <td><?php echo $CI->piero_jdate->jdate("Y/m/d", $value["date"])        ?></td>
            <?php if($v["expirable"]) :?> <td><?php echo $CI->piero_jdate->jdate("Y/m/d", $value["expire_date"])?></td> <?php
            endif; ?>
            <td <?php echo (!$this->system->get_setting("display_eemployer_on_print_client_detials"))?'class="dis_print"':''; ?> ><?php echo $this->system->get_user_admin_from_id($value["maker_id"]) ?></td>
            <td class="dis_print" ><?php echo $op ?></td>
        </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    <tfoot>
    <tr>
        <?php
        //mande
        $allprice+=$tprice ?>
        <td> <?php echo _TOTAL_PLUS ?></td>
        <td><?php echo number_format($tprice) ?></td>
    </tr>
    </tfoot>
</table>
    </div>
<?php endforeach; ?>
<!--//---------------------------------------------------pay-->
<h3 style="text-align: center"><?php echo _LIST.__._PAY._S ?></h3>
<table  class=" table table-hover table-striped" >

    <thead>
    <tr>
        <td><?php echo _ID ?></td>
        <td><?php echo _MABLAGH._R ?></td>
        <td><?php echo _DATE ?></td>
        <td><?php echo _DATE.__._SABT ?></td>
        <td><?php echo _DATE.__._CHECKOU ?></td>
        <td><?php echo _STATE ?></td>
        <td><?php echo _DES?></td>
        <td <?php echo (!$this->system->get_setting("display_eemployer_on_print_client_detials"))?'class="dis_print"':''; ?>  ><?php echo _EMPLOY ?></td>
        <td> </td>
    </tr>
    </thead>
    <?php  foreach ($CI->bed_beslib->get_list_bes_from_user($detail_users[0]["id"])as $key => $value):
        if($value["enable"]) {
            $ttprice +=$value["price"];
        }

        ?>

        <tr>
            <td><?php echo $value["id"] ?></td>
            <td><?php echo number_format($value["price"])?></td>
            <td><?php echo $CI->piero_jdate->jdate("Y/m/d", $value["date"])        ?></td>
            <td><?php echo $CI->piero_jdate->jdate("Y/m/d", $value["date_enter"])?></td>
            <td><?php echo (@json_decode($value["params"])->flagcheck)?$CI->piero_jdate->jdate("Y/m/d", json_decode($value["params"])->datecheck):null?></td>
            <td><?php echo (($value["enable"]))?_MALI_ENABLED:_MAILI_DISABLED?></td>

            <td><?php echo $this->element->edit_text($value["id"], $value["des"], "mali_bed_bes", "des", "text")  ?></td>

            <td <?php echo (!$this->system->get_setting("display_eemployer_on_print_client_detials"))?'class="dis_print"':''; ?> ><?php echo $this->system->get_user_admin_from_id($value["maker_id"]) ?></td>
            <?php if($this->permission->check("base_accounting")) : ?>
            <td><?php

                $edit_link= site_url("MaLi/Bed_bes/ajax_get/");
                echo "<a class=' btn btn-default ' onclick=load_ajax_popup('$edit_link','group_id=9&id=".$value["id"]."&user_id=".$detail_users[0]["id"]."')> <i class='fa fa-edit' ></i>  </a>";

                $dellink=site_url("MaLi/Bed_bes/del/".$value["id"]);
                echo "<a class='btn btn-default' onclick=areyousure('link','$dellink')>"  ."<i class='fa fa-close' ></i>".  '</a>';

                //check

            if($value["group_id"]==$this->system->get_setting("deafult_checku_group")) {
                if($value["enable"]) {
                    $dislink=site_url("MaLi/Bed_bes/en_dis/".$value["id"]);
                    echo "<a class='btn btn-danger'  onclick=areyousure('link','$dislink')>"  ."<i class='fa fa-level-up' ></i>"._MAILI_DISABLED .'</a>';
                }
                else{
                    $enlink=site_url("MaLi/Bed_bes/en_dis/".$value["id"]);
                    echo "<a class='btn btn-success' onclick=areyousure('link','$enlink')>"  ."<i class='fa fa-level-up' ></i>"._MALI_ENABLED .'</a>';

                }

            }
                //check
                ?></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    <tfoot>
    <tr>
        <?php
        //mande
        $allprice = $allprice -$ttprice   ?>
        <td> <?php echo _TOTAL_PLUS ?></td>
        <td><?php echo number_format($ttprice) ?></td>

    </tr>
    </tfoot>

</table>
<table  class=" table table-hover table-striped" >

    <thead>
    <tr>
        <td></td>
        <td><?php echo _REMIND ?></td>

        <td>  <?php echo number_format($allprice)._R ?></td>


    </tr>
    </thead>


</table>
