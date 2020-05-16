<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */?>
</div></div>
<?php
// ci render element
if ($this->system->get_setting("shpw_ci_render_time")): ?>
<div class="ci_render_time">
<i class="fa fa-bar-chart " > </i> <em style="text-align: center">  <strong>{elapsed_time}</strong> <?php echo _SECEND ?></em>
</div>
<?php endif;?>
<!-- ajax Modal full-->
<div id="myModalfull" class="modal fade" role="dialog" data-backdrop="static"  >
    <div class="modal-dialog mdlfull">
        <!-- Modal content-->
        <div class="modal-content">
            <div id="ajax_bodyfull" >
            </div>
            <div class="modal-footer">
                <div onclick="printp('ajax_bodyfull')" class="btn btn-link"  > <i class="fa fa-print"></i> </div>
                <button type="button" class="btn btn-link" data-dismiss="modal"><i class="fa fa-close"></i></button>
                </div>
        </div>
    </div>
</div>
<!-- ajax Modal -->
<div id="myModal" class="modal fade" role="dialog" data-backdrop="static"  >
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
                <div id="ajax_body" >
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i></button>
                <div onclick="printp('ajax_body')" class="btn btn-default"  > <i class="fa fa-print"></i> </div>
            </div>
        </div>
    </div>
</div>
<!-- popup select Modal -->
<div id="popup_modal" class="modal fade" role="dialog" data-backdrop="static"  >
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
                <div id="ajax_bodypopup" >
                </div>
            <div class="modal-footer">
                <div onclick="printp('ajax_body')" class="btn btn-link  > <i class="fa fa-print"></i> </div>
                 <button type="button" class="btn btn-link" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
        </div>

    </div>
</div>
        </body>
        <script type="text/javascript">
//            define var in js from language
            var MESSAGE='<?php echo _MESSAGE ?>';
            var ERROR='<?php echo _ERROR ?>';
            var AREYOUSURE='<?php echo _ARE_YOU_SURE ?>';
            var ERRORININPUTPARAMS='<?php echo _ERROR_IN_INPUT_PARAMS ?>';
            var YES='<?php echo _YES ?>';
            var CANCEL='<?php echo _CANCEL ?>'
            var SUCOP='<?php echo _SUC_OP ?>';
            var __='<?php echo __ ?>';
//              print page on popup
            var PRINTCSS="<?php echo $this->template->load_print_css() ?> ";
            var PRINTLOGO="<?php echo $this->template->load_print_logo() ?> ";
        </script>
        <?php echo $this->template->load_custom_js("cando.min") ?>
        <?php echo $this->template->load_static_datatable_js(); ?>
        <script type="text/javascript">
        $(document).ready(function(){
//            $(".loadp").click(function(){
//                $(this).button('loading');
//            });

        });
//        function input_price(_this,_name)
//        {
//            _tmp=_this.value;
//            _tmp=_tmp.replace(/,/gi,'');
//            document.getElementById(_name).value=_tmp;
//        }
            //paganintion
//        function paging(_pg) {
//
//            document.getElementById("page").value=_pg;
//            document.getElementById("form_pg").submit();
//        }
        </script>
</html>
