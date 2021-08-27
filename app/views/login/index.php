<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
//login page
$CI = &get_instance();
$this->load->helper('form');
//elements
$user_name = form_input(array('name' => 'username', "class" => "form-control", "required" => "required"));
$password = form_password(array('name' => 'password', "class" => "form-control", "required" => "required"));
$submit = form_button(array('type' => "button", 'class' => 'btn btn-deep-green', "id" => "submit"), _LOGIN);
$tmp_random = json_decode(config("login_random_texts"));
$tmp_slide = json_decode(config("login_slide_show"));
$tmp_html_footer = config("login_html_footer");
$this->template->load_css("login");
// $this->template->load_js("login");
?>
<div class="container">
    <div class="col-sm-8 col-sm-offset-2 main">
        <div class="col-sm-6 right-side">
            <?php if (_LOGO_LOGIN == ""): ?>
            <svg width="350" height="150" xmlns="http://www.w3.org/2000/svg" style="vector-effect: non-scaling-stroke;">
                <g><metadata style="vector-effect: non-scaling-stroke;" id="svg_41">image/svg+xml</metadata>
                    <metadata style="vector-effect: non-scaling-stroke;" id="svg_82">image/svg+xml</metadata>
                    <g id="svg_84">
                        <g transform="matrix(0.43384, 0, 0, 0.43384, -856.665, -311.577)" id="svg_73">
                            <path fill="#ffa000" fill-rule="nonzero" id="svg_81" d="m2486.81812,931.69586l72.4873,41.85034l72.4873,-41.85034l0,-83.69604l-72.4873,-41.8457l-72.4873,41.8457l0,83.69604zm72.4873,60.99792l-89.06665,-51.42188l0,-102.84814l89.06665,-51.41724l89.07129,51.41724l0,102.84814l-89.07129,51.42188"/>
                            <path fill="#ffa000" fill-rule="nonzero" id="svg_80" d="m2615.75708,862.48431l-57.08691,-33.03687l-50.20557,28.78442l-4.75757,-8.30371l54.98657,-31.51636l61.85864,35.79224l-4.79517,8.28027"/>
                            <path fill="#ffa000" fill-rule="nonzero" id="svg_79" d="m2373.94727,930.26691l-0.26489,42.78894l72.48682,-41.85095l0,-83.69592l-72.48682,-41.84497l0.10791,70.00793l0.15698,54.59497zm-0.26489,61.93604l-20.896,-0.05896l0.04395,-205.10498l19.74487,-0.08008l90.17798,50.974l0,102.849l-89.0708,51.42102"/>
                            <path fill="#ffa000" fill-rule="nonzero" id="svg_78" d="m2095.93433,787.01801l-88.83765,51.34094l0,102.849l88.87671,51.14502c-0.25317,-5.99207 0.08789,-12.5271 -0.03906,-18.95313l-72.25134,-41.76794l0,-83.6969l72.2533,-41.73315c-0.01099,-1.45288 0.00098,-18.43286 -0.00195,-19.18384l0,0z"/>
                            <rect opacity="0" fill="#ffa000" fill-rule="evenodd" stroke="#000000" y="981.84368" x="2136.99332" height="5.51339" width="0.06696" id="svg_77"/>
                            <path fill="#ffa000" fill-rule="nonzero" id="svg_76" d="m2243.22339,931.00287c37.91602,-57.53003 67.54883,23.37012 90.63989,51.49902l-1.44604,-175.72998l-17.61182,-0.18799l0.58301,110.03101l-72.16504,-69.30798l0,83.69592zm72.48682,60.99805l-89.06689,-51.422l0,-102.84802l89.06689,-51.41699l26.25513,1.12109l2.63306,204.47693l-28.88818,0.08899"/>
                            <path fill="#ffa000" fill-rule="nonzero" id="svg_75" d="m2125.76343,931.03583l-0.26514,42.78906c10.1499,-75.17505 37.64893,-74.8479 72.48706,-41.84998l-41.59692,-65.995l-30.89014,-59.547l0.10791,70.00793l0.15723,54.59497zm-0.26514,61.93701l-20.896,-0.05994l0.04395,-205.10498l19.74512,-0.07996l90.17798,50.97498l0,102.84802l-89.07104,51.42188"/>
                        </g>
                    </g>
                </g>
            </svg>
            <?php else: ?>

            <div style="text-align: center"><div  style="background: url("<?php echo _LOGO_LOGIN ?>") no-repeat center ;background-size: contain; ;width: 60%;height:150px;margin-left: auto;margin-right: auto;margin-top: 10px}" > </div></div>

                            <div style="text-align: center"><div  style="background: url("<?php echo _LOGO_LOGIN ?>") no-repeat center ;background-size: contain; ;width: 60%;height:150px;margin-left: auto;margin-right: auto;margin-top: 10px}" > </div></div>
            <?php endif;?>
            <p style="text-align: center;color: #990000" id="mes">
                <?php echo $tmp_random[rand(0, count($tmp_random) - 1)]; ?>
                </p>
            <!--Form with header-->
            <div class="form">
                <?php echo form_open(''); ?>
                <div class="form-group">
                    <label for="form2"><?php echo _USERNAME ?></label>
                    <?php echo $user_name ?>
                </div>
                <div class="form-group">
                    <label for="form4"><?php echo _PASSWORD ?></label>
                    <?php echo $password ?>
                </div>
                <div class="text-xs-center">
                    <?php echo $submit ?>
                </div>
                <?php echo form_close(); ?>
                <div id="load-coonect" style="margin: 10px;text-align: center" > <?php echo _LOAD_WAITING ?> </div>
            </div>
            <!--/Form with header-->
        </div><!--col-sm-6-->

        <div class="col-sm-6 left-side">
            <h1><?php echo config('login_title') ?></h1>
            <p>
<!--                            slide show-->
            <?php $this->element->slideshow($tmp_slide)?>
<!--                            slide show end-->
            </p >
            <br>
                     <div style="text-align: center">

            <?php echo $tmp_html_footer ?>
            <?php if (_MARQUEE_LOGIN == ""): ?>
                        <marquee xss="removed" direction="right" behavior="scroll" scrolldelay="200">
                        <i class="fa fa-line-chart"> </i>                                نرم افزار کندو
                        <i class="fa fa-sitemap"> </i>                         طراحی و توسعه مدرن ترین سیستمهای یکپارچه (ERP , CRM , BPM , ... )
                        <i class="fa fa-mobile"> </i>                  تلفن تماس :        03136519040
                        <i class="fa fa-envelope"> </i>              ایمیل پشتیبانی :           Info@piero.ir
                        <i class="fa fa-link"> </i>                        آدرس وب سایت: www.piero.ir
                        </marquee>
            <?php else: ?>
                        <marquee xss="removed" direction="right" behavior="scroll" scrolldelay="200"> <?php echo _MARQUEE_LOGIN ?> </marquee>
            <?php endif;?>
            </div>
        </div><!--col-sm-6-->
    </div><!--col-sm-8-->

</div><!--container-->

  <body>
      <div class="wrapper">
  <div class="container">

    <br>
    </div>
</div>
</body>
<script type="text/javascript">
$("#load-coonect").hide();

$("#submit").on("click",function () {
    submit();
});

$('input').keypress(function (e) {
if (e.which == 13) {
    submit();
    return false;
}
});
function submit() {
    $("#submit").text('<?php echo _WAITING ?>');
    $("#submit").attr("class","btn btn-info btn-block disabled");
    $("#load-coonect").show(200);
    //get the action-url of the form
    $.ajax({
        url: "<?php echo site_url("login/auth") ?>" ,
        type: "POST",
        dataType: "JSON",
        "data": $('form').serialize(),
        success: function (data) {
            if (data.status)
            {
                $("form")[0].reset();
                window.location="<?php echo site_url(config("home")) ?>";
            }
            else
            {
                $("#mes").hide();
                $("#mes").show(50);
                $("#mes").html("<?php echo _LOGIN_INVALID ?>");
                $("#submit").html("<?php echo _LOGIN ?>");
                $("#submit").attr("class","btn btn-success btn-block");
                $("#load-coonect").hide(2000);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
           alert("<?php echo _ERROR ?>", "<?php echo _ERROR_AJAX ?>");
        }
    });
}
</script>
</html>
