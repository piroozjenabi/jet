<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
echo $out ?>
<script type="text/javascript">

    function del_cr_forms(_id)
    {
        Pace.restart();
        Pace.track(function () {
        $.ajax({
            url : "<?php echo site_url("AUTO/manage_form/manage/del_cr_forms") ?>",
            type: "POST",
            dataType: "JSON",
            "data": "id="+_id,
            success: function(data)
            {
                if(data.status)
                {
                    piero_message();
                }
                else
                {
                    piero_alert();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                piero_alert("<?php echo _ERROR ?>","<?php echo _ERROR_AJAX ?>");
            }
        });
        });

    }

</script>
