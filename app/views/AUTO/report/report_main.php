<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$CI=&get_instance();
$CI->load->library('auto');
$list_tree=$CI->auto->list_tree();
?>
<!-- emkanat-->
<nav class="navbar navbar-default" >
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand"  > <i class="fa fa-gear"> </i></a>
        </div>

        <ul class="nav navbar-nav navbar-right  ">
            <li><a class="btn " onclick="$('#form_list').toggle(500)" ><i class="fa fa-list"> </i>  <?= _FORM_LISTS ?> </a></li>
            <li><a class="btn " onclick="$('#filter').toggle(500)" ><i class="fa fa-filter"> </i>  <?= _FILTER_VALUE ?></a></li>

        </ul>

        <ul class="nav navbar-nav navbar-left ">
            <li><a class="btn "href="<?= site_url("AUTO/report/report_main/index/$form_id/-1") ?>" ><i class="fa fa-th-list"> </i>  <?= _SHOW_ALL ?></a></li>
            <li><a class="btn "href="<?= site_url("AUTO/report/report_main/index/$form_id/0") ?>" ><i class="fa fa-eye-slash"> </i>  <?= _VIEW.__._UNREAD ?></a></li>
            <li><a class="btn "href="<?= site_url("AUTO/report/report_main/index/$form_id/1") ?>" ><i class="fa fa-check"> </i>  <?= _VIEW.__._ACCEPTED ?></a></li>
            <li><a class="btn "href="<?= site_url("AUTO/report/report_main/index/$form_id/2") ?>" ><i class="fa fa-arrow-circle-o-right"> </i>  <?= _VIEW.__._REJECTED ?></a></li>

        </ul>

    </div>
</nav>

<!--//list add-->
<div class="container col-lg-12 " id="form_list" >
    <ul class="nav nav-tabs">
        <?php
        $flag_active='class="active"';
        foreach ($list_tree as $key => $value): ?>
            <li <?= $flag_active ?> ><a data-toggle="tab"  href="#<?= $value["id"] ?>"><?= $value["name"] ?></a></li>
            <?php $flag_active=null; endforeach; ?>
    </ul>
    <div class="tab-content">
        <?php
        $flag_active='active';
        foreach ($list_tree as $key => $value): ?>
            <div id="<?= $value["id"] ?>" class="tab-pane fade in <?= $flag_active ?> ">
                <h3><?= $value["des"] ?></h3>
                <div class="btn-group">
                    <?php foreach ($CI->auto->list_forms($value["id"])  as $k => $v)
                    {
                        $tmp_btn=($v["id"]==$form_id)?"btn-info":"btn-default";
                        $link = site_url("AUTO/report/report_main/index/" . $v["id"]);
                        echo  "<a class='btn $tmp_btn' href='$link'> ".$v["name"]."</a>" ;
                    }
                    $flag_active=null;
                    ?>
                </div>
            </div>
        <?php  endforeach; ?>
    </div>
</div>
</div>
<!--//list add end-->
<?= isset($out)?$out:null;?>
<script type="text/javascript">
    $(document).ready(function () {
        <?php if(isset($out)): ?>
        $('#form_list').hide();
        $('#filter').hide();
        <?php endif; ?>

        $('tbody').on('dblclick', 'tr', function () {
            var data = table.row( this ).data();
//            alert( 'You clicked on '+data[1]+'\'s row' );
            load_ajax_popupfull('<?= site_url("AUTO/Manage/show_form") ?>','id='+data[1]) ;
        } );

    })


</script>
