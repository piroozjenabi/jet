<?php defined('BASEPATH') or exit('No direct script access allowed');
$dir = config("def_upload_path");
?>
<div class="col-lg-2 col-md-2 card" onclick=load_ajax_popupfull('<?= site_url("media/show/$id") ?>')>
    <img class="img-thumbnail" src="<?=base_url($dir . $file)?>" >
    <div class="container">
        <p><?=$des?></p>
    </div>
</div>