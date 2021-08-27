<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class=" row  btn btn-group " >
    <a class="btn  btn-warning btn-lg" href="<?php echo site_url('Stock/Stock/manage') ?>" > <i class="fa fa-magnet" ></i> <?php echo _MANAGE.__._STOCK._S ?> </a>
    <a class="btn  btn-primary btn-lg" href="<?php echo site_url('Stock/Stock/Stock_check') ?>" > <i class="fa fa-refresh" ></i> <?php echo _STOCK_CHECK ?> </a>
    <a class="btn  btn-info btn-lg" href="<?php echo site_url('Stock/Stock_in/manage') ?>" > <i class="fa fa-compress" ></i> <?php echo _STOCK.__._IN ?> </a>
    <a class="btn  btn-danger btn-lg" href="<?php echo site_url('Stock/Stock_out/manage') ?>" > <i class="fa fa-expand" ></i> <?php echo _STOCK.__._OUT ?> </a>
    <a class="btn  btn-primary btn-lg" onclick=load_ajax_popup('<?php echo site_url('Stock/Stock/transfer') ?>')  > <i class="fa fa-arrow-circle-right" ></i> <?php echo _TRANSFER.__._STOCK ?> </a>
    <a class="btn  btn-default btn-lg" onclick="printp('acc_body')" type="button"   > <i class="fa fa-print"></i> <?php echo _PRINT ?> </a>
</div>
<div id="acc_body">
<?php if(config("disolay_stock_by_stock")) :?>
    <table class="table table-hover table-striped dataTbl" >
        <thead>
        <tr>
            <td><?php echo _NAME .__._PRD ?></td>
            <td><?php echo _IN ?> </td>
            <td><?php echo _OUT ?> </td>
            <td><?php echo _SUPPLY ?></td>
            <td><?php echo _STOCK_HANDING ?></td>
            <td><?php echo _SUPPLY.__._REAL ?></td>
            <td><?php echo _LACK ?></td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($db as $k => $v):?>
            <tr style="background-color: #4d4d4d;color: #fff" > <td ><?php echo $k ?></td>
            </tr>
            <?php foreach ($v as $key => $value):?>
            <tr>
                <td><?php echo $value["name"]  ?></td>
                <td><?php echo $value["stock_in"]  ?></td>
                <td><?php echo $value["stock_out"]  ?></td>
                <td><?php echo $value["remind"]  ?></td>
                <td><?php echo $value["stock_check"]  ?></td>
                <td> <p data-toggle="tooltip" title="<?php echo $value["num_out_after_stock_check"] ?>"><?php echo $value["real_supply"]   ?> </p></td>
                <td style="color: #ff0005;font-weight: bolder"  > <?php echo $value["real_supply"] - ( $value["remind"]) ?></p></td>
            </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
<?php else: ?>
<table class=" table table-hover table-striped" >
    <thead>
    <tr>
        <td><?php echo _NAME .__._PRD ?></td>
        <td><a class="btn  btn-default " href="<?php echo site_url('Stock/Stock_in/manage') ?>" > <i class="fa fa-compress" ></i><?php echo _IN ?> </a> </td>
        <td> <a class="btn  btn-default" href="<?php echo site_url('Stock/Stock_out/manage') ?>" > <i class="fa fa-expand" ></i> <?php echo _OUT ?> </a></td>
        <td><?php echo _SUPPLY ?></td>
        <td> <a class="btn  btn-default" href="<?php echo site_url('Stock/Stock/Stock_check') ?>" > <i class="fa fa-exchange" ></i> <?php echo _STOCK_HANDING ?> </a></td>
        <td><?php echo _SUPPLY.__._REAL ?></td>
        <td><?php echo _CARTON ?></td>
        <td><?php echo _LACK ?></td>
    </tr>
    </thead>
    <?php foreach ($db as $key => $value):?>
        <tr>
            <td><?php echo $value["name"]  ?></td>
            <td><?php echo $value["stock_in"]  ?></td>
            <td><?php echo $value["stock_out"]  ?></td>
            <td><?php echo $value["remind"]  ?></td>
            <td><?php echo $value["stock_check"]  ?></td>
            <td> <p data-toggle="tooltip" title="<?php echo $value["num_out_after_stock_check"] ?>"><?php echo $value["real_supply"]   ?> </p></td>
            <td style="color: #ff0005;font-weight: bolder"  > <?php echo $value["real_supply"] - ( $value["remind"]) ?></p></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
</div>
