<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$user_id=($user_id!=0)?$user_id:"";
//make array for where
$where=["state"=>1];
if ($user_id) { $where["maker_id"]=$user_id;
}

$num_belgove= getCountQuick("tmp_client", $where);
$num_belfel= getCountQuick("user", $where);
?>
<!-- BELGHOVE -->
<div class="col-lg-6 col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-user fa-4x"></i>
                </div>
                <div class="col-xs-9 text-left">
                    <div>
                        <a class="btn btn-default" href="<?php echo site_url("CRM/my_client/belfel/".$user_id) ?>" >
                           <h4><?php echo _VIEW.__._BELFEL ?>
                             <span class="label label-danger"><?php echo $num_belfel  ?></span>
                           </h4>
                         </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- BELFEL -->
<div class="col-lg-6 col-md-6">
    <div class="panel panel-green">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-user fa-4x"></i>
                </div>
                <div class="col-xs-9 text-left">
                    <div>
                        <a class="btn btn-default" href="<?php echo site_url("CRM/Tmp_users/manage/".$user_id) ?>" >
                           <h4><?php echo _VIEW.__. _BELGHOVE ?>
                             <span class="label label-danger"><?php echo $num_belgove ?></span>
                           </h4>
                         </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
