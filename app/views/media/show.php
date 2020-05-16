<?php defined('BASEPATH') or exit('No direct script access allowed');
$dir = $this->system->get_setting("def_upload_path");
$this->load->helper("form");
?>
<div class="col-md-8"> <img style="width:100%"  src="<?=base_url($dir . $data->file)?>" > </div> 
<div class="col-md-4"> 
    <form id="form_media">
        <table class="table">
        <tr>
            <h3 class="page-header"> <?= _INFO_MEDIA ?> </h3>    
        </tr>
        <tr>
            <td><p style="overflow:auto;"><?= $data->file ?></p></td>
        </tr>
        <tr>
            <td><p style="overflow:auto;"><?= _TYPE ." : ". $rel["name"] ?></p></td>
        </tr>
        <?php if(isset($rel["name"]) && $rel["name"] ): ?>
        <tr>
            <td><p style="overflow:auto;"><?= _DES." : ". $rel["value"] ."</br>" . $rel["des"] ?></p></td>
        </tr>
        <?php endif;?>
        <tr>
            <td><p style="overflow:auto;"> <?= _DATE.__.":". printDate($data->date) ?></p></td>
        </tr>
        <tr>
            <td><?= form_dropdown("group", $this->element->pselect("media_group"), $data->group_id, ["class" => "form_controll"]) ?></td>
        </tr>
        <tr>
            <td><textarea class="form-control" name="des" placeholder="<?= _DES ?>"><?= $data->des ?></textarea></td>
        </tr>
        <tr>
            <td><button class='btn btn-success btn-block' type="submit"> <?= _SAVE ?> </button></td>
        </tr>
        </table>
    </form>
</div> 
<?= $this->element->load_ajax_submit("#form_media", "media/show/{$data->id}/edit","  ") ?>
