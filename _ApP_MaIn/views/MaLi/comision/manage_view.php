<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$CI =& get_instance();
$CI->load->library("element");
echo  $CI->element->quick_add("/MaLi/comision/Manage_comision/padd", array("0"=>array("name"=>"name","placeholder"=>_NAME.__._GROUP.__._COMMISSION , "type" => "input"))); ?>
<table class=" table table-hover table-striped"  >
    <thead>
    <tr>
        <td><?php echo _ID?></td>
        <td><?php echo _NAME?></td>
        <td></td>
    </tr>
    </thead>
    <?php foreach ($db as $key => $value):?>
    <tr>
    <td><?php echo $value["id"] ?></td>
    <td>
        <?php echo $this->element->edit_text($value["id"], $value["name"], "mali_commision_group", "name", "text") ?>
    </td>
        <td>
            <?php
            $per_link=site_url("/MaLi/comision/Manage_comision/add_comision");
            echo "<a class=' btn btn-warning  ' onclick=load_ajax_popupfull('$per_link','id=".$value["id"]."')> <i class='fa fa-lock' ></i> "  . _COMMISSION._S. ' </a>';
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
