<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?=$this->template->load_custom_css("dropzone")?>
<?=$this->template->load_custom_js("dropzone")?>
<button class="btn btn-default" onclick="$('#dropzone').toggle(100)"> <i class='fa fa-plus'> </i>
    <?=_ADD_MEDIA_CLICK_HERE?> </button>
<br /><br />
<div id=dropzone style="display:none">
    <form action="<?=site_url("media/upload/$type/$id")?>" method="post" class="dropzone" enctype="multipart/form-data">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form>
</div>

<script>
Dropzone.autoDiscover = false;
$(function() {
  var myDropzone = new Dropzone(".dropzone");
  myDropzone.on("success", function(file,res) {
        if(res.status == true){
            piero_message("","<?= _FILE_UPLOAD_SUCESSFUL?>");
            loadUploads();
        }else{
            piero_alert(null,"<?= _ERROR_IN_UPLOAD ?>"+res.data.error)
        }
  });
});
</script>