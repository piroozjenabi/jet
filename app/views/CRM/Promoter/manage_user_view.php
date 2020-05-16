<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
?>
<a class="btn btn-lg btn-success" href="<?php echo site_url("CRM/Promoter/add") ?>" > <i class="fa fa-plus"></i> <?php echo _ADD._PROMOTER ?> </a>
<div class="row  well">
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
            <a href="<?php echo site_url("CRM/Promoter/tracks/".$value['id']) ?>">
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
