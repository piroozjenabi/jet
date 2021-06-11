<?php defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$CI->load->library("Factor");
$CI->load->library('Page');

//make startup ajax list
$def_level = ($level) ? $level : $CI->system->get_setting("main_factor_level");
$ajax_array = array("level" => $def_level);
if ($user_id) $ajax_array['user_id'] = $user_id;


@$ajax_array['type'] = ($type) ? $type : "private";
if ($month_ago)  $ajax_array['month_ago'] = $month_ago;
if ($type_in)    $ajax_array['type_in'] = $type_in;
if ($type_date)  $ajax_array['type_date'] = $type_date;

$startup = $this->system->array_post($ajax_array);
$levels = $this->factor->get_level_list();
?>
<div class="row well">
    <div class="btn-group">
        <?php if ($month_ago) : ?>
            <?php if ($type_date == "date") : ?>
                <a class="btn btn-lg btn-primary" href="<?php echo site_url("MaLi/factor_sell/manage_factor/this_month/" . $user_id . "/" . $month_ago) ?>"> <?php echo _VIEW . __ . _FACTOR . __ . _LAST_MOUNTH ?> <i class="fa fa-step-backward"></i></a>
            <?php elseif ($type_date == "expire_date") : ?>
                <a class="btn btn-lg btn-primary" href="<?php echo site_url("MaLi/factor_sell/manage_factor/this_month_expire/" . $user_id . "/" . $month_ago) ?>"> <?php echo _VIEW . __ . _FACTOR . __ . _LAST_MOUNTH ?> <i class="fa fa-step-backward"></i></a>
            <?php endif; ?>
        <?php endif; ?>

        <a class="btn  btn-lg  btn-success" href="<?php echo site_url("MaLi/Factor/add/") ?>" target="_blank"> <i class="fa fa-plus"></i> <?php echo _ADD . _FACTOR  ?></a>
        <?php foreach ($levels as $key => $value) : $ajax_array['level'] = $value["id"]; ?>
            <a class="btn btn-lg  btn-default" onclick="load_ajax('<?php echo site_url("MaLi/factor_sell/manage_factor/ajax_list") ?>','#ajax_load','<?php echo $this->system->array_post($ajax_array); ?>')"> <i class="fa fa-list-alt"></i> <?php echo $value["name"] ?></a>
        <?php endforeach; ?>

    </div>
</div>

<div id="ajax_load"> </div>
<script type="text/javascript">
    $(document).ready(function() {
        load_ajax('<?php echo site_url("MaLi/factor_sell/manage_factor/ajax_list") ?>', "#ajax_load", '<?php echo $startup ?>');
    });
</script>