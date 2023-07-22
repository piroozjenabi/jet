<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * load all thing about html element
 * power by pirooz jenabi
 * jenabi.pirooz@gmail.com -- info@piero.ir
 */
class Element
{

    public function pselect($tblsel, $rowname = "name", $postfix = "", $def = _DEF_ELEMENT, $where = "", $order = "name", $params = array(), $def_num = null)
    {

        $CI = &get_instance();
        $select = "id , $rowname ";
        if ($postfix) {
            $select .= ", $postfix";
        }
        $CI->db->select($select);
        $CI->load->helper('form');
        $CI->db->from($tblsel);
        $CI->db->order_by($order, "ASC");
        if ($where) {
            $CI->db->where($where);
        }
        $res = $CI->db->get()->result_array();
        $ret = array();
        //        if no dont add def select for option group use
        if ($def != "no") {
            $ret[""] = "";
        }
        foreach ($res as $key => $value) {
            if (@$value[$postfix]) {
                $ret[$value["id"]] = $value[$rowname] . "--" . $value[$postfix];
            } else {
                $ret[$value["id"]] = $value[$rowname];
            }
        }
        return $ret;
    }

    //drop down for sex mail or femail
    public function select_sex($name = 'sex', $def = null, $id = 'sex', $data = array('class' => "form-control"))
    {
        $CI = &get_instance();
        $CI->load->helper("form");
        $data["id"] = $id;
        $sex_type = array(null => null, '1' => _MAIL, '2' => _FEMAIL);
        return form_dropdown('sex', $sex_type, $def, $data);
    }

    //price input
    public function input_price($array)
    {
        $name = $array["name"];
        $array["class"] = @($array["class"]) ? $array["class"] . " input-numeral$name" : " form-control input-numeral$name";
        $array["onkeyup"] = "input_price(this,'$name')";

        return form_input($array)
        . form_input(
            array(
                'name' => $name,
                'id' => $name,
                'value' => $array["value"],
                "style" => "display:none",
            )
        )
            . "<script type='text/javascript'>
			var cleave1 = new Cleave('.input-numeral$name', {
				numeral: true,
				numeralThousandsGroupStyle: 'thousand'
			});
		</script>";
    }

    //price select
    public function price_select($id, $name, $css, $def = 1)
    {
        $CI = &get_instance();
        $select = "id, name, price1";

        $res = $CI->db->select($select)
                ->where("state", 1)
                ->from("prd")
                ->order_by("order_by", "ASC")
                ->get()->result_array();

        $ret = '<select id="' . $id . '" name="' . $name . '" class="' . $css . '" onchange="setPrice(this)"  >';
        $ret .= '<option name="" value="-1" >' . _DEF_ELEMENT . "</option>";

        foreach ($res as $key => $value) {
            {
                $def_element = "";
                if ($value["id"] == $def) {
                    $def_element = 'selected="selected"';
                }
                $ret .= '<option ' . $def_element . ' id="'.$value["price1"].'" value="' . $value["id"] . '" >' . $value["name"] . '</option>';
            }
        }
        $ret .= "</select>";

        return $ret;
    }

    //        select day of week
    public function select_day($name, $css, $def = 1)
    {
        $arr = array(0 => _SELECT, 1 => _SAT, 2 => _SUN, 3 => _MON, 4 => _TUS, 5 => _WEN, 6 => _THU, 7 => _FRI);
        $CI = &get_instance();
        $CI->load->helper("form");

        return form_dropdown($name, $arr, $def, $css);
    }

    public function input_file($in)
    {
        return "<input type='file' name='" . $in["name"] . "' style='" . $in["style"] . "' id='" . $in["id"] . "' class='" . $in["class"] . "'  />";
    }

    public function do_upload($file_name)
    {

        $CI = &get_instance();
        $config = array();
        $config['upload_path'] = $CI->system->get_setting("def_upload_path");
        $config['allowed_types'] = $CI->system->get_setting("def_upload_type");
        $config['max_size'] = $CI->system->get_setting("def_upload_max_size");
        $config['max_width'] = $CI->system->get_setting("def_upload_max_width");
        $config['max_height'] = $CI->system->get_setting("def_upload_max_height");
        $config['encrypt_name'] = true;
        $CI->load->library('upload', $config);

        if (!$CI->upload->do_upload($file_name)) {
            $data = array('op' => 0, 'error' => $CI->upload->display_errors());
            echo "<script type='text/javascript' > alert('" . $CI->upload->display_errors() . "') </script>";
        } else {
            $data = array('op' => 1, 'upload_data' => $CI->upload->data());
        }

        return $data;
    }

    public function userSelectAjax($id, $name, $css, $def = 1, $op = ""){
        return "
        <select 
            id='{$id}' 
            name='{$name}' 
            style='width:100%' 
            class='{$css}' {$op} 
            required
            >
            <option> </option>
            <option>12 </option>
            <option>2 </option>
        </select>
        
        <script type='text/javascript'> 
        document.getElementById('{$id}').addEventListener('select2.select', function(){
            alert(123);
        }) </script>
        ";

    }

    //price select
    public function user_select($id, $name, $css, $def = 1, $op = "")
    {
        $CI = &get_instance();
        $userid = $CI->system->get_user();
        $def_element = "";
        $flagper = $CI->permission->check("user_view_all");
        $select = "id , name , agent , tell , mobile ,address ";

        $CI->db->select($select);
        $CI->load->helper('form');

        $CI->db->from("user");
        $CI->db->order_by("name", "ASC");
        if (!$flagper) {
            $CI->db->where("maker_id", $userid);
        }

        $res = $CI->db->get()->result_array();
        $ret = '<select id="' . $id . '" name="' . $name . '" style="width:100%" class="' . $css . '"  ' . $op . ' required >';

        $ret .= "<option> </option>";

        foreach ($res as $key => $value) {

            {

                $agent = ($value["agent"]) ? " - " . $value["agent"] : "";
                $str = _TELL . " : " . $value["tell"] . " | " . _MOBILE . " : " . $value["mobile"] . "  |  " . _ADDRESS . " : " . $value["address"];

                $def_element = ($value["id"] == $def) ? 'selected="selected"' : "";
                $ret .= '<option ' . $def_element . ' id="' . $str . '" value="' . $value["id"] . '" >' . $value["name"] . " " . $agent . '</option>';
            }
        }
        $ret .= "</select>";

        return $ret;
    }

    //delete all end line and enter
    public function deln($string)
    {
        return preg_replace("~[\r\n]+~", "", $string);
    }

    // edit text element
    //type number , text
    public function edit_text($id, $value, $pg, $field, $type = "text", $params = array())
    {
        if ($type == "number") {
            @$value = number_format($value);
        }
        //encode $pg
        $rnd = rand(1, 100);
        $params = str_rot13(json_encode(array("id" => $id, "pg" => $pg, "field" => $field)));
        $save_url = site_url("ajax/save_edit_text");
        ?>
<div class="edit-text">
    <i class="fa fa-paint-brush  "></i>
    <div class="edit_text_lbl edit<?php echo $id . $rnd ?> " id='<?php echo $params ?>' for="name"> <?php echo $value ?> </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.edit<?php echo $id, $rnd ?>').editable('<?php echo $save_url ?>', {
                event: "dblclick",
                submit: " <i class='fa fa-check-square-o  ' style='opacity:1;color: #fff'></i> ",
                indicator: '<?php echo _WAITING ?>',
                tooltip: '<?php echo _DBLCLICK_TO_EDIT ?>'
            });
        });
    </script>

    <?php

    }
    public function edit_label($id, $value, $pg, $field, $type = "text", $params = array())
    {
        if ($type == "number") {
            @$value = number_format($value);
        }
        //encode $pg

        ?>
    <div class="edit-text">
        <i class="fa fa-lock  "></i>
        <div class="edit_text_lbl  "> <?php echo $value ?> </div>
    </div>
    <?php

    }

//editable text area
    public function edit_textarea($id, $value, $pg, $field, $type = "text", $params = array())
    {
        if ($type == "number") {
            @$value = number_format($value);
        }
        //encode $pg
        $rnd = rand(1, 1004156);
        $params = str_rot13(json_encode(array("id" => $id, "pg" => $pg, "field" => $field)));
        $save_url = site_url("ajax/save_edit_text");
        ?>
    <div class="edit-text">
        <i class="fa fa-paint-brush  "></i>
        <div class="edit_text_lbl edit<?php echo $id . $rnd ?> " id='<?php echo $params ?>' for="name"> <?php echo $value ?> </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.edit<?php echo $id, $rnd ?>').editable('<?php echo $save_url ?>', {
                    event: "dblclick",
                    type: 'textarea',
                    submit: " <i class='fa fa-check-square-o  ' style='opacity:1;color: #fff'></i> ",
                    indicator: '<?php echo _WAITING ?>',
                    tooltip: '<?php echo _DBLCLICK_TO_EDIT ?>',

                });
            });
        </script>

        <?php

    }

    // true or false edit
    public function edit_select_bool($id, $value, $pg, $field, $type = "text", $params = array())
    {
        $rnd = rand(1, 100100);
        $params = str_rot13(json_encode(array("id" => $id, "pg" => $pg, "field" => $field)));
        $save_url = site_url("ajax/save_edit_text");
        ?>
        <div class="edit-text">
            <i class="fa fa-paint-brush  "></i>
            <div class="edit_text_lbl edit<?php echo $id . $rnd ?> " id='<?php echo $params ?>' for="name"> <?php echo ($value) ? _TRUE : _FALSE; ?> </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('.edit<?php echo $id, $rnd ?>').editable('<?php echo $save_url ?>', {
                        data: " {'1':'<?php echo _TRUE ?>','0':'<?php echo _FALSE ?>','selected':<?php echo $value ?>}",
                        type: 'select',
                        event: "dblclick",
                        submit: " <i class='fa fa-check-square-o  ' style='opacity:1;color: #fff'></i> ",
                        indicator: '<?php echo _WAITING ?>',
                        tooltip: '<?php echo _DBLCLICK_TO_EDIT ?>'
                    });
                });
            </script>
            <?php

    }

    // true or false edit
    public function edit_select_db($id, $value = null, $pg, $field, $type = "text", $params = array())
    {
        $value = ($value) ? $value : -1;
        //encode $pg
        $where = @($params["where"]) ? $params["where"] : null;
        $data = $this->pselect($params["db"], "name", "", _DEF_ELEMENT, $where);
        $datajson = json_encode($data);
        $rnd = rand(1, 1045640);
        $params = str_rot13(json_encode(array("id" => $id, "pg" => $pg, "field" => $field)));
        $save_url = site_url("ajax/save_edit_text");
        ?>
            <div class="edit-text">
                <i class="fa fa-paint-brush  "></i>
                <div class="edit_text_lbl edit<?php echo $id . $rnd ?> " id='<?php echo $params ?>' for="name"> <?php echo @$data[$value] ?> </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.edit<?php echo $id, $rnd ?>').editable('<?php echo $save_url ?>', {
                            data: <?php echo $datajson ?>,
                            type: 'select',
                            event: "dblclick",
                            submit: " <i class='fa fa-check-square-o  ' style='opacity:1;color: #fff'></i> ",
                            indicator: '<?php echo _WAITING ?>',
                            tooltip: '<?php echo _DBLCLICK_TO_EDIT ?>'
                        });
                    });
                </script>
                <?php

    }
    public function edit_text_db()
    {}

    //replace in element and delete end line
    public function rep_ele($elem, $old, $new)
    {
        $elem = $this->deln($elem);
        $ret = str_replace("[$old]", "[$new]", $elem);
        $ret = str_replace("($old)", "($new)", $ret);

        return $ret;
    }

    //list database
    public function list_db($table, $select = "*", $order_by = "id", $where = null)
    {

        $CI = &get_instance();
        $CI->db->select($select);
        $CI->db->from($table);
        $CI->db->where($where);
        $CI->db->order_by($order_by, "ASC");
        $res = $CI->db->get()->result_array();

        return $res;
    }

    //quick add
    public function quick_add($act, $params)
    {

        $CI = &get_instance();
        $CI->load->helper('form');
        $out = form_open($act, array("class" => "form-inline"));
        foreach ($params as $key => $value) {

            if ($value["type"] == "dropdown") {
                $keytmp = "form_" . $value["type"];
                $value["class"] = "form-control";
                $value["style"] = "width:auto;";
                $data = $value["data"];
                $value["data"] = null;
                $out .= $keytmp($value["name"], $data, 1, $value);
            } else {
                $keytmp = "form_" . $value["type"];
                @$value["class"] .= " form-control";
                @$value["style"] .= ";width:auto;";

                $out .= $keytmp($value);
            }
        }
        $out .= form_button(
            array(
                'type' => "submit",
                'id' => 'submit',
                'class' => 'btn btn-success',
            ),
            _ADD
        );
        $out .= form_close();
        echo $out;
    }

    //quick padd
    public function quick_padd($db, $other = null)
    {
        $CI = &get_instance();
        $post = $CI->input->post(null, true);
        if ($other) {
            $post = $post + $other;
        }

        return $CI->db->insert($db, $post);
    }

    //popup select
    public function popup_select($name)
    {
        $CI = &get_instance();
        $CI->load->helper('form');
        ?>
                <span class="btn btn-default" onclick="popup_select()">
                    <?php echo _SELECT ?>
                    <?php echo form_input(array("name" => $name, "id" => $name)) ?>
                </span>

                <script type="text/javascript">
                    function popup_select() {

                        $("#popup_modal").modal("show");


                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            //                    alert(xhttp.readyState );
                            if (xhttp.readyState == 4) {
                                $("#ajax_bodypopup").html(xhttp.responseText)
                            }
                        };
                        xhttp.open("POST", <?php echo site_url("") ?>, true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(_data);


                    }
                </script>
                <?php

    }

    //load editor
    public function load_editor($id)
    {
        echo "<script  src='" . base_url() . "_ApP_MaIn/views/assets/js/tinymce/tinymce.min.js'" . "> </script>";
        echo "<script  src='" . base_url() . "_ApP_MaIn/views/assets/js/tinymce/jquery.tinymce.min.js'" . "> </script>";
        echo "<script  > tinymce.init({
  selector: '#$id',
  setup: function (editor) {
        editor.on('keyup', function () {
        $('#$id').html( tinymce.get('$id').getContent() );
        });
    },
  height: 500,
  theme: 'modern',
  language: 'fa_IR',
  directionality :'rtl',

  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc directionality'
  ],
  toolbar1: 'ltr rtl  | print preview media | forecolor backcolor emoticons  | undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],

  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });</script>";
    }

    public function input_date($name, $def_date = 0,$def_css_class = "form-control", $style = null)
    {
        $CI = &get_instance();
        $rnd=rand(1,50);
        $out = null;
        $CI->load->helper('form');
        $out .= $CI->template->load_custom_css("js-persian-cal");
        $date = form_input(['id' => "$name-$rnd",'class' => $def_css_class . " pdate","style" => $style]);
        $date_hidden = form_input(["name" => "$name", "id" => "$name", "type" => "hidden"]);
        $out .= $CI->template->load_custom_js("js-persian-cal.min");
        $def=($def_date)?" , initialDate:'".printDate($def_date)."'":"";
        $out .= $date . $date_hidden .
        "<script>var objCal1 = new AMIB.persianCalendar( '$name-$rnd' ,{extraInputID: '$name',extraInputFormat: 'YYYY/MM/DD' {$def}});</script>";
        return $out;
    }

    //load date pro

    public function date_input($name, $value = 1)
    {
        $CI = &get_instance();
        $rnd=rand(1,100);
        $value = ($value) ? "value='$value'" : null;
        $out = $CI->template->load_custom_css("persian-datepicker-0.4.5.min")
        . $CI->template->load_custom_js("persian-date")
        . $CI->template->load_custom_js("persian-datepicker-0.4.5.min")
        . "<input id='tmpDate$rnd' name='$name' type='input' $value /> <input id='$name'   type='hidden' />"
        . '<script type="text/javascript" >
                $(document).ready(function () {
                $("#' . $name . '").pDatepicker({
                    format : "DD / MM / YYYY",
                    observer : true,
                    altField :' . "'#tmpDate$rnd'" . ',
                    altformat : "YYYY/mMM/DD",
                    formatter : function(unix){
                    var day = persianDate(unix);
                    return day.format("DD / MM / YYYY");},
                });
                });
                </script>';
        return $out;
    }

    //load slide show bootstrap
    public function slideshow($arr)
    {
        ?>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php
$c = 1;
        $active1 = "active";
        $active2 = "active";
        foreach ($arr as $k => $v): ?>
                        <li data-target="#myCarousel" class="<?php echo $active1;
        $active1 = null ?>" data-slide-to="<?php echo $c++ ?>"></li>
                        <?php endforeach;?>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <?php
foreach ($arr as $k => $v): ?>

                        <div class="item <?php echo $active2;
        $active2 = null ?>">
                            <img src="<?php echo base_url($v[0]) ?>" alt="<?php echo $v[1] ?>">
                            <div class="carousel-caption">
                                <h3><?php echo $v[1] ?></h3>
                                <p><?php echo $v[2] ?></p>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <i class="fa fa-chevron-left" style="margin-top: 100px"></i>

                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <i class="fa fa-chevron-right" style="margin-top: 100px"></i>

                        </a>

                    </div>
                </div>
                <?php

    }

    public function view_file($value, $height = null)
    {
        $CI = &get_instance();
        $loc = base_url($CI->system->get_setting("def_upload_path") . $value);
        $height = ($height) ? "style='height:$height'" : null;

        return " <a href='$loc' target='_blank'  ><img class='img-thumbnail' $height   src='$loc' /></a> ";
    }

    public function load_ajax_submit($form = "form", $url , $after=null)
    {
        $r = rand(1, 100);
        if($after === null)
            $after= "$('$form')[0].reset(); $('.modal').modal('hide');";
        ?>
                <div id="loading<?=$r?>" class="loading" style="display:none;position:fixed;top:30%;left:45%"></div>
                <script type="text/javascript">
                        $("<?=$form?>").submit(function(event) {
                            _f = this;
                            //loading style
                            _serilize = $(_f).serialize();
                            $(_f).fadeTo("slow", 0.4);
                            $("<?=$form?> *").prop("disabled", true);
                            $("#loading<?=$r?>").show();
                            //----
                            event.preventDefault();
                            $.ajax({
                                url: "<?=site_url($url)?>",
                                type: "POST",
                                dataType: "JSON",
                                "data": _serilize,
                                success: function(data) {
                                    if (data.status == 2 && data.body != '') {
                                        $(_f).html('');
                                        $(_f).html(b64DecodeUnicode(data.body));
                                        $(_f).fadeTo("slow", 1);
                                        $("<?=$form?> *").prop("disabled", false);
                                        $("#loading<?=$r?>").hide(200);
                                    } else if (data.status == true) {
                                        if (data.mes) piero_message("", data.mes)
                                        else piero_message();
                                        <?=  $after ?>
                                    } else {
                                        if (data.error) piero_message("", data.error)
                                        else piero_alert();
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    piero_alert("<?=_ERROR?>", "<?=_ERROR_AJAX?>");
                                }
                            });
                            table.ajax.reload(null, false); //reload datatable ajax
                            //loading style disabled
                            $(_f).fadeTo("slow", 1);
                            $("<?=$form?> *").prop("disabled", false);
                            $("#loading<?=$r?>").hide(200);
                            //----
                       
                    })
                </script>
                <?php

    }

    // for ajax send and easy way to post via jquery
    public function load_ajax_submit2($form = "form", $target)
    {
        $target = site_url($target);?>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#submit").on("click", function() {
                            $("#submit").text('<?php echo _WAITING ?>');
                            $("#submit").attr("class", "btn btn-info btn-block disabled");
                            //get the action-url of the form
                            $.ajax({
                                url: "<?php echo $target ?>",
                                type: "POST",
                                dataType: "JSON",
                                "data": $('<?php echo $form ?>').serialize(),
                                success: function(data) {
                                    if (data.status) {
                                        piero_message();
                                        $("<?php echo $form ?>")[0].reset();
                                        $('.modal').modal('hide');
                                    } else {
                                        piero_alert();
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    piero_alert("<?php echo _ERROR ?>", "<?php echo _ERROR_AJAX ?>");
                                }
                            });
                            table.ajax.reload(null, false); //reload datatable ajax
                            $("#submit").html("<?php echo _SAVE ?>");
                            $("#submit").attr("class", "btn btn-success btn-block");
                        })

                    })
                </script>
                <?php

    }

    //get op as array and make drop down menu
    public function drop_down_menu($op)
    {
        ?>
                <div class="dropdown">
                    <button class="btn btn-default btn-lg dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation" class="dropdown-header"><?php echo _OP ?></li>
                        <?php foreach ($op as $key2): ?>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"> <?php echo $key2 ?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <?php

    }
}
?>