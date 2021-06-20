<?php defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$CI->load->library('Piero_jdate');
$user_id = $this->system->get_user();
$alertsList = $this->alerts_lib->type_list();
$titleNav = isset($title) && $title ? " | <b style='color:#fff'>$title</b>" : "";
$title = (isset($title) && $title) ? $title : $this->system->get_setting('login_title');
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo _TITLE . " - " . strip_tags(str_replace("<small>", " | ", $title)) ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $bsjas ?>
    <?php echo $bscss ?>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <span onclick="side_menu_toggle()" class="piero_nav piero_slide_mobile"> <i class="fa fa-2x fa-bars"></i> </span>
            <a class="piero_nav" href="<?php echo site_url($this->system->get_setting("home")) ?>"> <i class="fa fa-2x fa-home"></i> </a>

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" target="_blank" href="<?= $this->system->get_setting("company_url") ?>">
                    <span class="full">JET <?= $titleNav ?></span>
                    <span class="min" style="display: none">JET <?= $titleNav ?></span>
                </a>
                <span class="menu_mobile piero_nav" style="display: none "><a onclick=areyousure('link','<?php echo site_url("login/logout") ?>')> <i style="color: #fff" class="fa fa-close fa-2x"></i> </a> </span>
                <span class="menu_mobile piero_nav" id="nav_left_mobile" style="display: none"><i class="fa fa-th fa-2x"></i> </span>
            </div>

            <!--        top menu  start   -->
            <div class="container-fluid">

                <ul class="nav navbar-nav left-nav">
                    <!--                add-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus"></i> <b class="caret"></b></a>
                        <ul class="dropdown-menu alert-dropdown">
                            <?php if ($this->permission->check("factor_add")) : ?>
                                <li>
                                    <a href="<?php echo site_url('MaLi/factor/add') ?>" accesskey="n" target="_blank"> <i class="fa fa-money"></i> <?php echo _ADD . __ . _FACTOR ?></a>
                                </li>
                            <?php endif; ?>
                            <?php
                            //for auto add form
                            if ($this->permission->check("auto_form_add")) {
                                $CI->load->library("Auto");
                                echo count($CI->auto->list_forms())?"<li> <hr/> </li>":" ";
                                foreach ($CI->auto->list_forms() as $k => $v) {
                                    $add_link = site_url("/AUTO/add_form/add/" . $v["id"]);
                                    echo "<li><a href='$add_link'  accesskey='n' target='_blank' > <i class='fa fa-plus-square' ></i> " . $v["name"] . " </a> </li>";
                                }
                            }
                            ?>

                        </ul>
                    </li>
                    <!--            setting-->
                    <?php if ($this->permission->check("base_setting")) : ?>
                        <li class="dropdown ">
                            <a href="<?php echo site_url("Setting") ?>" class="dropdown-toggle"> <i class="fa fa-gears"> </i> </a>
                        </li>
                    <?php endif; ?>

                    <!--                backup-->
                    <?php if ($this->permission->check("base_backup")) : ?>
                        <li class="dropdown ">
                            <a href="<?php echo site_url("Backup_main") ?>" class="dropdown-toggle"> <i class="fa fa-database "> </i> </a>
                        </li>
                    <?php endif; ?>

                    <!--            alarm-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                        <ul class="dropdown-menu alert-dropdown">

                            <?php
                            $flag_alert = 0;
                            foreach ($alertsList as $key => $value) :
                                $count_alert = $this->alerts_lib->count_alert($value["id"]);
                                if ($count_alert) :
                                    $flag_alert = 1;
                            ?>
                                    <li>
                                        <a href="<?php echo site_url('CRM/alerts/index/' . $value["id"]) ?>"><?php echo $value["des"] ?> <span class="label " style="background-color:<?php echo $value["color"] ?> "><?php echo $count_alert; ?></span></a>
                                    </li>
                            <?php
                                endif;
                            endforeach; ?>
                            <?php echo ($flag_alert) ? null : '<li><p style="text-align: center" > <i class="fa fa-warning"></i>' . _NOT_FOUND . '</p></li>' ?>
                            <hr>
                            <li style="font-weight: bolder;text-align: center">
                                <a href="<?php echo site_url('CRM/alerts') ?>"> <i class="fa fa-th-list"></i> <?php echo _VIEW . " " . _ALL ?></a>
                            </li>
                        </ul>
                    </li>

                    <!--            my profile -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= $CI->system->get_user("name") ?> <b class="caret"></b> </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" onclick=load_ajax_popup("<?php echo site_url("Dashboard/change_pass_view") ?>")><i class="fa fa-fw fa-key"></i> <?php echo _CHANGE_PASSWORD ?></a>
                            </li>
                            <li>
                                <a href="#" onclick=load_ajax_popup("<?php echo site_url("Dashboard/fill_profile") ?>")><i class="fa fa-fw fa-user"></i> <?php echo _FILL_PROFILE ?></a>
                            </li>
                            <li>
                                <a href="#" onclick=areyousure('link','<?php echo site_url("login/logout") ?>')> <i class="fa fa-close"></i> <?php echo _LOGOUT ?> </li> </a>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse piero-menu">
                    <ul class="nav navbar-nav side-nav">

                        <!--                 load for menus-->
                        <?php foreach ($CI->permission->list_main_permision() as $k => $v) :
                            $tmp = $CI->permission->list_menu_permision($v["id"]);
                            
                            if (count($tmp)) :
                                $flgActive=0;     
                                foreach ($tmp as $key => $value)
                                    if(uri_string() == $value["menu_link"])
                                        $flgActive = 1;
                            ?>
                                <li class="<?= $flgActive?"active":"" ?>">
                                    <a href="javascript:;" data-toggle="collapse" data-target="#PIERO_MNU<?php echo $v["id"] ?>"> <i class="<?php echo $v["icon"] ?> "> </i> <?php echo $v["des"] ?><span class="caret"></span></a>
                                    <!--                    sub menus-->
                                    <ul id="PIERO_MNU<?php echo $v["id"] ?>" class="collapse">
                                        <?php foreach ($tmp as $key => $value) : ?>
                                            <li><a class="<?= uri_string() == $value["menu_link"]?'active':''?>" href="<?=site_url($value["menu_link"]) ?>"> <i class="<?php echo ($value["menu_icon"]) ? $value["menu_icon"] : $v["icon"] ?>"></i> <?php echo ($value["menu_text"]) ? $value["menu_text"] : $value["des"] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <!-- /.navbar-collapse -->
                </div>
            </div>
        </nav>

        <!-- bottom navigation -->
        <div class="btm-nav">
            <?php
            if ($this->system->get_setting("shpw_ci_render_time")) : ?>
                <a> <i class="fa fa-bar-chart "> </i> <em style="text-align: center"> <strong>{elapsed_time}</strong> <?php echo _SECEND ?></em> </a>
            <?php endif; ?>
            <a> <i class="fa fa-calendar"></i> <?= _TODAY . " : " . $CI->piero_jdate->jdate("Y/m/d H:i", time()) ?></a>

        </div>

        <div id="page-wrapper">
            <div class="container-fluid">

        <?php if (@$message) : ?>
            <div class="alert alert-warning fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong><?php echo _MESSAGE ?></strong> <?php echo $message ?></div>
        <?php endif ?>