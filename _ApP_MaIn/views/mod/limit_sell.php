<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
$num = range(0, 9);
$CI->load->library('Piero_jdate');
$curent_day=$CI->piero_jdate->jdate("d", time());
$curent_day=str_replace($persian, $num, $curent_day);
$last_day=$CI->piero_jdate->jdate("t", time());
$last_day=str_replace($persian, $num, $last_day);
?>
<div style="height: 200px;overflow: hidden" class="<?php echo $propertis->root_css ?>" >
<div  class="<?php echo $propertis->css ?>">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-6 text-right">
                <div  class="huge"  > <?php echo ($this->system->get_setting("salary_this_mount_percent")>0)? _SALARY_THIS_MOUNTH.":".number_format($db["user_selled"]*$this->system->get_setting("salary_this_mount_percent")):"<i class='fa fa-clock-o  fa-2x' > </i>" ?> </div>
            </div>
            <div class="col-xs-6 text-left">
                <div  class="huge"  >   <?php echo number_format($db["user_selled"] - $db["user_limit"])?>  </div>
                <div >   <?php echo $des ?> <b class="label label-danger"> <?php echo $last_day - $curent_day ?></b> <?php echo _DAY ._OTH ?>  </div>
            </div>
        </div>
    </div>
    <a href="<?php echo site_url($propertis->link) ?>">
        <div class="panel-footer">
            <span class="pull-left"><?php echo _VIEW_FACTOR_THIS_MOUNTH ?></span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
    </a>
</div>
</div>
