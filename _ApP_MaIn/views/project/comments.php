<?php defined('BASEPATH') or exit('No direct script access allowed');
if ($msg) : ?>
<script>
    $(function() {
        <?= ($msg[0]) ? "piero_message('{$msg[1]}')" : "piero_error('{$msg[1]}')" ?>;
        load_ajax_popup('<?= site_url("Project/comments") ?>', 'id=<?= $id ?>');
    })
</script>
<?php endif; ?>
<form class="col-sm-12 form-inline form-group" id=formcomments>
    <div class="row well">
        <textarea type="text" class="form-control " style="width:100%" name="comment" required placeholder="<?= _NAME_COMMENT ?> "></textarea>
        <input type="hidden" name="id" value="<?= $id ?>" />
        <button id="checkAll" class="btn btn-success btn-block"><i class='fa fa-plus'> </i> <?= _ADD ?></button>
    </div>
    <br />
    <ul class="col-sm-12" >
        <?php foreach ($db as $key => $value) : ?>
                <div class="row well"> <?= $value->comment ?></div>
        <?php endforeach; ?>
    </ul>
</form>

<?= $this->element->load_ajax_submit("#formcomments", "Project/comments") ?> 