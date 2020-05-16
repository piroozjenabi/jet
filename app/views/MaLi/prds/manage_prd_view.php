<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
if($this->permision->check("prd_add")) : ?>
<a href="<?php echo site_url('MaLi/pprd/prd/add') ?>" class="btn btn-success"> <i class="fa fa-plus"></i>  <?php echo _ADD._PRODUCTS ?></a>
<a href="<?php echo site_url('/MaLi/pprd/prd/manage_group') ?>" class="btn btn-info"> <i class="fa fa-list"></i>  <?php echo _MANAGE.__._GROUP.__._PRODUCTS ?></a>
<?php endif; ?>
<table class="table table-hover table-striped dataTbl" >
   <thead>
    <tr>
        <td ><?php echo _ID ?></td>
        <td ><?php echo _STATE ?></td>
        <td ><?php echo _NAME ?></td>
        <td ><?php echo _GROUP ?></td>
        <td ><?php echo _OP ?></td>
    </tr>
   </thead>
    <tbody>
    <?php foreach ($res as $key => $value):?>
            <tr>
                <td ><?php echo $value["id"]?></td>
                <td> <?php echo $this->element->edit_select_bool($value["id"], $value["state"], "prd", "state", "text") ?></td>
                <td ><?php echo $this->element->edit_textarea($value["id"], $value["name"], "prd", "name", "text") ?></td>
                <td ><?php echo $this->element->list_db("prd_group", "name", null, "id=". $value["group_id"])[0]["name"] ?></td>
                <td> <?php
                    //edit
                if ($this->permision->check("prd_edit")) {
                    $edit_link=site_url("MaLi/pprd/prd/edit/".$value["id"]);
                    echo "<a class='btn btn-info' onclick=areyousure('link','$edit_link')>"  . _EDIT. '</a>';
                }
                    //delete
                if ($this->permision->check("prd_delete")) {
                    $dellink=site_url("MaLi/pprd/prd/manage_delete/".$value["id"]);
                    echo "<a class='btn btn-danger' onclick=areyousure('link','$dellink')>"  ._DELETE. '</a>';
                }
                    ?></td>
            </tr>
    <?php endforeach; ?>
    </tbody>
</table>
