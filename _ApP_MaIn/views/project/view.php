<?php defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper("form");
$user_select = form_dropdown('user', $this->element->pselect("user", "name"));
$prd_select = form_dropdown('prd', $this->element->pselect("prd", "name"));
$company_select = form_dropdown('company', $this->element->pselect("crm_company", "name"));

?>
<div class="col-sm-12 row well" style="text-align:center" >
    <span> <?= _PROJECT_OP ?> : </span>
        <?php if($db["project"]->status=="done"):?> <button class='btn btn-info  btn-lg'   onclick="setStatus('todo')" > <i class="fa fa-arrow-circle-o-right"> </i> <?= _TODO ?>  </button><?php endif;?>
        <?php if($db["project"]->status=="todo"):?> <button class='btn btn-info  btn-lg'   onclick="setStatus('doing')" > <i class="fa fa-arrow-circle-o-right"> </i> <?= _DOING ?> </button><?php endif;?>
        <?php if($db["project"]->status=="doing"):?> <button class='btn btn-danger btn-lg' onclick="setStatus('done')" > <i class="fa fa-arrow-circle-o-right"> </i> <?= _DONE ?>  </button><?php endif;?>
</div>
<div class="col-sm-12 row well">
    <div class="col-sm-4"> <?= _NAME . __ . _PROJECT . " : <b> " . $db["project"]->name ?> </b> </div>
    <div class="col-sm-4"> <?= _DATE . __ . _PROJECT . " : <b> " . printDate($db["project"]->date) ?> </b> </div>
    <div class="col-sm-4"> <?= _STATE . __ . _PROJECT . ": <b class='alert alert-info'> " . $this->project_lib->status_array[$db["project"]->status] ?> </b> </div>
    <br> <br>
    <div class="col-sm-3"> <?= _POINT_DATE . " : <b> " . printDate($db["project"]->point_date) ?> </b> </div>
    <div class="col-sm-3"> <?= _DATE . __ . _TODO . " : <b> " . printDate($db["project"]->todo_date) ?> </b> </div>
    <div class="col-sm-3"> <?= _DATE . __ . _DOING . " : <b> " . printDate($db["project"]->doing_date) ?> </b> </div>
    <div class="col-sm-3"> <?= _DATE . __ . _DONE . " : <b> " . printDate($db["project"]->done_date) ?> </b> </div>
</div>

<div class="col-sm-12 row well">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#user"><?= _USER . __ . _S ?></a></li>
        <li><a data-toggle="tab" href="#prd"><?= _PRD . __ . _S ?></a></li>
        <li><a data-toggle="tab" href="#company"><?= _COMPANY . __ . _S ?></a></li>
    </ul>


    <div class="tab-content">
        <div id="user" class="tab-pane fade in active">
            <h3 class="page-header"><?= _ADD_USER_TO_PROJECT ?></h3>
            <form id="project-add-user">
                <table class="table-striped table-bordered table-hover" style="width:100%">
                    <thead>
                        <td><?= _NAME ?> </td>
                        <td> <?= _DATE ?></td>
                    </thead>
                    <tr>
                        <td><?= $user_select ?></td>
                        <td><button type="submit" class='btn btn-success btn-sm btn-block'><i class="fa fa-plus"> </i> <?= _ADD ?> </button> </td>
                    </tr>
                    <?php foreach ($db["user"] as $key => $value) : ?>
                    <tr>
                        <td> <?= $value->name ?></td>
                        <td> <?= printDate($value->date) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </form>

        </div>
        <div id="prd" class="tab-pane fade in">
            <h3 class="page-header"><?= _ADD_PRD_TO_PROJECT ?></h3>
            <form id="project-add-prd">
                <table class="table-striped table-bordered table-hover" style="width:100%">
                    <thead>
                        <td><?= _PRD ?> </td>
                        <td> <?= _DATE ?></td>
                    </thead>
                    <tr>
                        <td><?= $prd_select ?></td>
                        <td><button type="submit" class='btn btn-success btn-sm btn-block'><i class="fa fa-plus"> </i> <?= _ADD ?> </button> </td>
                    </tr>
                    <?php foreach ($db["prd"] as $key => $value) : ?>
                    <tr>
                        <td> <?= $value->name ?></td>
                        <td> <?= printDate($value->date) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </form>
        </div>
        <div id="company" class="tab-pane fade in">
            <h3 class="page-header"><?= _ADD_COMPANY_TO_PROJECT ?></h3>
            <form id="project-add-company">
                <table class="table-striped table-bordered table-hover" style="width:100%">
                    <thead>
                        <td><?= _COMPANY ?> </td>
                        <td> <?= _DATE ?></td>
                    </thead>
                    <tr>
                        <td><?= $company_select ?></td>
                        <td><button type="submit" class='btn btn-success btn-sm btn-block'><i class="fa fa-plus"> </i> <?= _ADD ?> </button> </td>
                    </tr>
                    <?php foreach ($db["company"] as $key => $value) : ?>
                    <tr>
                        <td> <?= $value->name ?></td>
                        <td> <?= printDate($value->date) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </form>
        </div>
    </div>

</div>

<?= $this->element->load_ajax_submit("#project-add-user", "Project/op_project/add_user/{$db['project']->id}") ?>
<?= $this->element->load_ajax_submit("#project-add-company", "Project/op_project/add_company/{$db['project']->id}") ?> 
<?= $this->element->load_ajax_submit("#project-add-prd", "Project/op_project/add_prd/{$db['project']->id}") ?>

<script type="text/javascript">
    function setStatus(status){
        $.ajax({
            url: "<?=site_url("project/op_project/set_status/{$db['project']->id}")?>",
                type: "POST",
                data : {"status":status},
                dataType: "JSON",
                success: function(data) {
                     if (data.status == true) {
                        if (data.mes) piero_message("", data.mes)
                        else piero_message();
                        load_ajax_popupfull('<?=site_url("Project/view")?>','id=<?= $db['project']->id ?>');

                    } else {
                        if (data.error) piero_message("", data.error)
                        else piero_alert();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    piero_alert("<?=_ERROR?>", "<?=_ERROR_AJAX?>");
                }
            });
    }

</script>