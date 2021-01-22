<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$this->load->helper("form");
$def_css_class="form-control col-sm-12 selectrefer p100p";
$CI=& get_instance();
//-----------------------list user alowed refer
$CI->load->library("auto");
$ret=array();
foreach ( $CI->auto->list_user_refer() as $key => $value ) {
        $ret[ $value["id"] ] = $value[ "name" ];
}
//-----------------------list user alowed refer
$user=form_dropdown('refer[]', $ret, null, array('class' => $def_css_class, 'multiple'=>"multiple","required"=>"required"));
$subject=form_dropdown('subject_id', $this->element->pselect("auto_refer_subject", "name", null), null, array('class' => $def_css_class,"required"=>"required"));
$des= form_textarea(array('name' => "des",'class'=>$def_css_class,"style"=>"height:80px",'paceholder'=>_DES,"required"=>"required"));
$refer=form_button(array('id' => "submit",'class'=>'btn-success btn-block btn  '), "<i class='fa fa-arrow-circle-o-right'> </i>"._REFER);
$form_id=form_hidden("form_id", post("form_id", true));
?>
<form id="refer_form">
    <?php echo $form_id ?>
<div class="col-sm-12">
    <label><?php echo _RECIVERS ?></label> <?php echo $user?>
</div>

<div class="col-sm-12">
    <label><?php echo _SUBJECT_REFER ?></label> <?php echo $subject?>
</div>

<div class="col-sm-12">
    <label><?php echo _DES ?></label> <?php echo $des?>
</div>

<div class="col-sm-12">
    <br>
    <?php echo $refer ?>
    <br>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
    $("#submit").click(function () {
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url("AUTO/Refer/padd_refer") ?>",
            type: "POST",
            dataType: "JSON",
            "data": $('#refer_form').serialize(),
            success: function(data)
            {
            if(data.status)
            {
                piero_message();
                $("#refer_form")[0].reset();
                $(".selectrefer").val(null).trigger("change")
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

    })

    })

</script>
