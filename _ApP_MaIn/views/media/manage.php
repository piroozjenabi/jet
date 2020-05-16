<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if($permision["add"]) $this->load->view("media/add.php", array("id"=>$id ,"type"=>$type ));?>
<h2 class='page-header'> <?= _MANAGE_MEDIA ?></h2>
<div id="loadMedia"> </div>

<script type="text/javascript">
    $(document).ready(function() { loadUploads();  });
    function loadUploads(){ load_ajax('<?= site_url("media/load/$maker/$type/$id") ?>', "#loadMedia"); }
</script>
