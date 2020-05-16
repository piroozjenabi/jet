<?php defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('form');
//* @todo add user and prd and add to database and close this form perform edit *//

//type product
$data = array('class' => "form-control");
$name = form_input(array('value' => @$detail[0]["name"], 'id' => 'name', 'placeholder' => _NAME, 'required' => 'required', 'name' => 'name', 'class' => "form-control"));
$state = form_dropdown('status', $this->project_lib->status_array, @$detail["status"], $data);
$des = form_textarea(array('name' => "des", 'class' => 'form-control', "style" => "height:80px", 'paceholder' => _DES, "value" => @$detail["des"]));
$user = form_dropdown('user[]', $this->element->pselect("user"), @$detail["status"], $data);
$prd = form_dropdown('prd[]', $this->element->pselect("prd"), @$detail["status"], $data);
?>
<form id="formProj">
    <div class="row well">
        <div class="col-sm-12 "><label for="name"><?php echo _NAME . __ . _PROJECT ?></label><?php echo $name ?></div>
        <div class="col-sm-12 "><label for="state"><?php echo _STATE ?></label><?php echo $state ?></div>
        <div class="col-sm-12 "><label for="company_maker"><?php echo _DES ?></label><?php echo $des ?></div>
        <div class="col-sm-12 " style="padding:20px"><button class="btn btn-success btn-block" type="submit"> <?= _SAVE ?> </button></div>
    </div>
</form>
<?= $this->element->load_ajax_submit("#formProj","Project/addp") ?>
