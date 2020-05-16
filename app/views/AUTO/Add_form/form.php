<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
 ?>
<div class="row">
    <a href="<?= site_url("AUTO/add_form") ?>" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i>  <?=_RETURN_TO_ADD_FORM ?> </a>
</div>
<?php
if ($title) {
    echo " <h2>$title </h2>";
}
echo $out;
$form=site_url('AUTO/add_form/padd/');
?>
<script type="text/javascript">
//    enable auto refer mode and submit
    function submit_and_auto_refer() {
        $("#auto_refer").val(1);
        submit_auto();
    }

    //do submit opration and  for submit button
    function submit_auto() {
        $(".submit").hide();
        $(".submitloading").show();
        //get the action-url of the form
        $.ajax({
            url: "<?php echo $form?>" ,
            type: "POST",
            dataType: "JSON",
            "data": $('form').serialize(),
            success: function (data) {
                if (data.status)
                {
                    piero_message(null,'<?php echo _SUC_AUTO_ADD ?>');
                    $("form")[0].reset();

                    action_new(data.id,data.form_id);
                }
                else
                {
//                    for (var i = 0; i < data.inputerror.length; i++)
//                    {
//                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
////                                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
//
//                    }
                    piero_alert('<?php echo _ERROR ?>',data.error_string)

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                piero_alert("<?php echo _ERROR ?>", "<?php echo _ERROR_AJAX ?>");

            }
        });
        $(".submit").show();
        $(".submitloading").hide();

    }

    function action_new(_id,_form_id) {
        (new PNotify({
            title: '',
            text: '<?php echo _AUTO_NEW_OP?>',
            icon: 'fa fa-check-square-o fa-5x ',
            hide: false,
            confirm: {
                confirm: true,
                buttons: [{
                    text: '<?php echo _AUTO_NEW_ADD?>',
                    addClass: 'btn-primary',
                    click: function(notice) {
                        notice.remove();
                    }},
                    {
                        text: '<?php echo _AUTO_EDIT_SAME?>',
                        addClass: 'btn',
                        click: function(notice) {
                            $(location).attr('href', '<?php echo site_url("AUTO/add_form/edit/")?>'+_form_id+'/'+_id);
                        }

                    }]
            },
            buttons: {
                closer: false,
                sticker: false
            },
            history: {
                history: false
            },
            addclass: 'stack-modal',
            stack: {
                'dir1': 'down',
                'dir2': 'right',
                'modal': true
            }
        })).get().on('pnotify.confirm', function() {

        }).on('pnotify.cancel', function() {

        });
    }

</script>
