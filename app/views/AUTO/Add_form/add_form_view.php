<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$this->load->helper('form');
$this->load->library('Piero_jdate');
$this->load->library('auto');
$list_tree=$this->auto->list_tree();
$def_css_class="form-control";
$data = array('class' => $def_css_class,"ng-change"=>"make_forms()" , "id" => "form_id" ,"ng-model"=>"formId");
$form=form_dropdown('form_id',$this->element->pselect("auto_forms","name","des",null,"enable=1"), -1,$data);
?>
<!--//drop down enter form-->
<div ng-app="formApp" style="display: none" id="searchabe_input"  ng-controller="formController">
    <div class="row well"  >
        <label> <?= _ADD_FORM_SEARCHABLE?> </label>
        <div class="col-sm-12 modal-body" >
            <?= $form ?>
        </div>
    </div>
</div>

<!--//list add-->
<div class=" row  " >
    <ul class="nav nav-tabs">
        <?php
        $flag_active='class="active"';
        foreach ($list_tree as $key => $value): ?>

            <li <?= $flag_active ?> ><a data-toggle="tab"  href="#<?= $value["id"] ?>"><?= $value["name"] ?></a></li>
            <?php $flag_active=null; endforeach; ?>

        <li ><a onclick="$('#searchabe_input').toggle(200)" > <i class="fa fa-search-plus"></i> </a></li>
    </ul>
    <div class="tab-content">
        <?php
        $flag_active='active';
        foreach ($list_tree as $key => $value): ?>
            <div id="<?= $value["id"] ?>" class="tab-pane fade in <?= $flag_active ?> ">
                <h3><?= $value["des"] ?></h3>
                <div class="btn-group">
                    <?php foreach ($this->auto->list_forms($value["id"])  as $k => $v)
                    {
                        $add_link = site_url("/AUTO/add_form/add/" . $v["id"]);
                        echo  "<a href='$add_link' class='btn btn-default'> <i class='fa fa-plus-square' ></i> ". $v["name"]." </a>";
//                        echo  anchor_popup($edit_link, " <i class='fa fa-plus-square' ></i> " . $v["name"], $atts) ;
                    }
                    $flag_active=null;
                    ?>
                </div>
            </div>
        <?php  endforeach; ?>
    </div>
</div>
<br/>
<!--//list add end-->


<!--//list tmp form-->
<h3 class="page-header"><?= _َAUTO_LAST_MINE ?></h3>
<div class="row ">

    <table class="table table-hover table-striped dataTbl"  >
        <thead>
        <tr>
            <td>#</td>
            <td><?=_ID?></td>
            <td><?=_NUMBER.__._letter?></td>
            <td><?=_MORE_INFO?></td>
            <td><?=_DATE.__._SABT?></td>
            <td><?=_TYPE.__._FORM?></td>
            <td><?=_MAKER.__._FORM?></td>
        </tr>
        </thead>
        <tbody>
        <?php $c=1;
        $atts["class"]='btn btn-link';
        foreach ($forms as $key => $value): ?>
            <tr ondblclick="load_ajax_popupfull('<?= site_url("AUTO/Manage/show_form") ?>','id=<?= $value["mainid"] ?>')" id="row_<?= $value["mainid"] ?>">
                    <?php
                    $op=array();
                    $form_id=$value["form_id"];
                    $main_id=$value["mainid"];

                    //is mine refer
                    //as accepted refer
                    $flag_accept=(count($this->auto->list_refer_accepted($main_id))>0)?true:false;
                    //edit link
                    if((!$flag_accept) || $this->permission->check("auto_edit_after_accepted") )
                    {
                        $edit_link=site_url("/AUTO/add_form/edit/$form_id/$main_id");
//                        $op[]= anchor_popup($edit_link, "<i class='fa fa-edit' ></i> ". _EDIT, $atts);
                        $op[]= "<a class='btn btn-link' href='$edit_link' > <i class='fa fa-edit' ></i> "._EDIT. '</a>';

                        //delete link
                        $dellink=site_url("/AUTO/add_form/delete/$main_id");
                        $op[]= "<a class='btn btn-link' onclick='piero_confirm(del,$main_id)' > <i class='fa fa-close' ></i> "._DELETE. '</a>';

                    }
                    //ajax show
                    $show_link= site_url("AUTO/Manage/show_form") ;
                    $op[]="<a class='btn btn-link' onclick=load_ajax_popupfull('$show_link','id=$main_id')> <i class='fa fa-eye' ></i> "  . _VIEW. ' </a>';

                    //ajax show
                    if($this->permission->check("auto_refer")){
                        $refer_link= site_url("AUTO/Refer/add_refer") ;
                        $op[]="<a class='btn btn-link' onclick=load_ajax_popup('$refer_link','form_id=$main_id')> <i class='fa fa-link' ></i> "  . _REFER. ' </a>';
                    } ?>

                <td><?= $c; ?></td>
                <td><?= $value["mainid"] ?></td>
                <td><?= $value["number"] ?></td>
                <td><?= $this->auto->show_list ($value["mainid"]) ?>
                    <div class="btn-group hover_show col-sm-12">
                        <?php foreach ($op as $key2): ?>
                            <a role="menuitem" tabindex="-1" href="#"> <?=$key2 ?></a>
                        <?php endforeach; ?>
                    </div>

                </td>
                <td><?= $this->piero_jdate->jdate("Y/m/d",$value["date"])  ?></td>
                <td><?= $value["name"]  ?></td>
                <td><?= @$this->system->get_user_admin_from_id($value["maker_id"]) ?></td>
            </tr>
            <?php $c++; endforeach; ?>
        </tbody>
    </table>
</div>
<script type="text/javascript" >
    //delete aleret
    function del(_id) {
        $.ajax({
            url: "<?= $dellink ?>",
            type: "POST",
            dataType: "JSON",
            "data": "id=" + _id,
            success: function (data) {
                if (data.status) {
                    piero_message();
                    $("#row_" + _id).hide(500);
                }
                else {
                    piero_alert();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                piero_alert("<?=_ERROR ?>", "<?=_ERROR_AJAX ?>");
            }
        });
    }
</script>
