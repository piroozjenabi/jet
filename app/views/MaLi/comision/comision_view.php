<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$CI =& get_instance();
$CI->load->library("plotly");
$chartsell=array('x'=>array(),'y'=>array());
$chartcom=array('x'=>array(),'y'=>array());

$charteemploy_com=array('x'=>array(),'y'=>array());
$charteemploy_sell=array('x'=>array(),'y'=>array());
?>
<table class="table table-hover table-striped dataTbl" >
    <thead>
    <tr>
        <td><?php echo _NAME .__._MOUNTH?></td>
        <td><?php echo _TOTAL_PLUS.__._FOROOSH ?> </td>
        <td><?php echo _COMMISSION ?></td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($res as $k => $v):
        $k=($k==-1)?0:$k;

        $chartsell['y'][]=$v["tot_sell"];
        $chartsell['x'][]=$v["month_name"];

        $chartcom['y'][]=$v["tot_com"];
        $chartcom['x'][]=$v["month_name"];

        $charteemploy_com=array('x'=>array(),'y'=>array());
        $charteemploy_sell=array('x'=>array(),'y'=>array());
        ?>
    <tr>
    <td><button class="btn btn-info" style="min-width: 200px" data-toggle="collapse" data-target="#<?php echo $k?>"> <i class="fa fa-eye-slash"></i> <?php echo $v["month_name"] ?> </button></td>
    <td> <?= price($v["tot_sell"]) ?></td>
    <td> <?= price($v["tot_com"]) ?></td>

        <td colspan="3" >
        <div id="<?php echo $k?>" class="collapse"  dir="<?php echo _DIRECTION ?>" >
                <?php foreach ($v["res"] as $key => $value) :
                    $charteemploy_com['y'][]=$value['commission_thismonth'];
                    $charteemploy_com['x'][]=$value['name'];

                    $charteemploy_sell['y'][]=$value['totsell'];
                    $charteemploy_sell['x'][]=$value['name'];

                    ?>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">

                                    <div class="col-xs-12 text-center">
                                        <div class="huge"></div>
                                        <a target="_blank" href="<?php echo site_url('MaLi/factor_sell/manage_factor/this_month/'.$value['id']."/".$k); ?>">
                                        <div style="color:#fff">
                                            <h4>  <i class="fa fa-arrow-circle-right"></i> <?php echo $value['name']  ?></h4>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                                <div class="panel-footer">
                                    <span class="pull-left"> </span>
                                    <span class="pull-right"></span>
                                    <div class="clearfix"></div>
                                    <div >
                                        <?php echo _COMMISSION.__.$v["month_name"] ?> :<?= price($value['commission_thismonth'], true)   ?><br>
                                        <?php echo _SELL.__.$v["month_name"] ?> :<?= price($value['totsell'], true)   ?><br>
                                    </div>
                                </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <div class="col-sm-6">
            <?php echo $CI->plotly->simple($charteemploy_com['x'], $charteemploy_com['y'], _CHART.__._COMMISSION, "bar"); ?>
            </div>
            <div class="col-sm-6">
            <?php echo $CI->plotly->simple($charteemploy_sell['x'], $charteemploy_sell['y'], _CHART.__._SELL, "bar"); ?>
            </div>
        </div>
        </td>
        </tr>

    <?php endforeach; ?>


<?php


?>
</table>
<br>
<div class="row well col-lg-6"><?php echo $CI->plotly->simple($chartsell['x'], $chartsell['y'], _CHART_SELL); ?></div>
<div class="row well col-lg-6"><?php echo $CI->plotly->simple($chartcom['x'], $chartcom['y'], _CHART_COMMISSION); ?></div>
