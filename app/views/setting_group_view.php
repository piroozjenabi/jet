<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->library("element");
?>
<table class=" table table-hover table-striped" id="datatable" >
    <thead >
    <tr >
        <td><?php echo _NAME?></td>
        <td><?php echo _OP ?> </td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($db as $key => $value):?>
        <tr>
            <td >
                    <?php echo  $value["name"] ?>
            </td>
            <td>
                <?php 
                $show_link= site_url("Setting/manage/{$value['id']}");
                echo "<a class=' btn btn-danger ' onclick=load_ajax_popupfull('$show_link','')> <i class='fa fa-table' ></i> "  ._EDIT.__._ADVANCED_SETTING. ' </a>';
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
        <tr>
            <td colspan="2">              
                <?php
                $show_link = site_url("Setting/manage/");
                echo "<a class='btn btn-info center-block ' onclick=load_ajax_popupfull('$show_link','')> <i class='fa fa-table' ></i> " . _EDIT_ALL_SETTING. ' </a>';
                ?></td>
        </tr>
  </tbody>
</table>
