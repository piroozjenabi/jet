<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
?>
<h3 class="panel-heading"><?php echo _MANAGE.__._BELGHOVE ?></h3>
<div class="btn-group btn-group-lg well ">

<a class="btn btn-success" href="<?php echo site_url("CRM/Tmp_users/add") ?>" > <i class="fa fa-plus"></i> <?php echo _ADD._BELGHOVE ?> </a>
<?php foreach ($state as $key => $value):?>
    <a class="btn  <?php echo $value["css"] ?> " href="<?php echo site_url("CRM/Tmp_users/manage/$my_id/".$value["id"]) ?>" > <i class="fa fa-th-list"></i> <?php echo _LIST.__. $value["name"] ._S ?></a>

<?php endforeach; ?>

</div>
<br>
<h3 class="panel-heading"><?php echo _CLIENT_LIST ?></h3>
<div class="row well">
<?php foreach ($user_details as $key => $value) : ?>

    <div class="col-lg-2 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">

                    <div class="col-xs-12 text-center">
                        <div class="huge"></div>
                        <div><?php echo $value['name']  ?></div>
                    </div>
                </div>
            </div>
            <a href="<?php echo site_url("CRM/Tmp_users/tracks/".$value['id']) ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo _VIEW_TRACKS  ?> </span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

<?php endforeach; ?>
</div>
