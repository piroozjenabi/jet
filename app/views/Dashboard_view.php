<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI=&get_instance();
$alertslist=$this->alerts_lib->type_list();
echo $html;
?>
<?php if(config('dashboard_bg') ) :?>
<style type="text/css">
    #page-wrapper{
        height: 700px !important;
        background-image: url("<?php echo base_url(config('dashboard_bg')) ?>") !important;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

</style>
<?php endif; ?>
    <!-- Modal -->
    <div class="modal fade" id="alerts" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo _ALERT ?></h4>
                </div>
                <div class="modal-body">
                    <table>
                        <?php foreach ($alertslist as $key => $value):?>
                            <?php if($this->alerts_lib->count_alert($value["id"])) :?>
                            <a href="<?php echo site_url('CRM/alerts/index/'.$value["id"]) ?>">
                                <div class="row well alert-first" style="background-color:<?php echo $value["color"] ?> ;" >
                                    <?php echo $value["des"] ?> <span class="label " style="background-color:#000 "><?php echo $this->alerts_lib->count_alert($value["id"]); ?></span>
                                </div>
                            </a>
                        <?php
                            endif;
                        endforeach; ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn-info btn-block btn-lg" data-dismiss="modal" ><?php echo _CLOSE ?></
                </div>
            </div>

        </div>
    </div>
<?php if($this->alerts_lib->count_alert()) : ?>)
<script type="text/javascript" >
    $(document).ready(function(){

        <?php
        $a=session("A");
        if($a) {
            session("A", 0);
        ?>
        $("#alerts").modal("show");
        <?php } ?>

    });

</script>

<?php endif; ?>
