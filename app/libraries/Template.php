<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Template
{
    //variable for out put baja cript and css in header
    public $javascriptlib = '';
    public $css_lib = '';
    //------------------------------------------define bootstrap and style start
    public $col_bt = array(
        "col-sm-12" => _COL_12,
        "col-sm-6" => _COL_6,
        "col-sm-4" => _COL_4,
        "col-sm-3" => _COL_3,
        "col-sm-2" => _COL_2);

    public $form_elements = array(
        "form-control" => _FORM_CONTROL, "btnbtn_successbtn-block" => _SAVE_BTN);

    //------------------------------------------define bootstrap and style end
    //load for all admin panel
    public function load($path, $datam = null, $datah = null, $dataf = null)
    {
        //checklogin
        $CI = &get_instance();
        if (!$CI->system->checklogin()) {
            redirect("login");
        }
        $CI->system->lis();
        $this->load_header_html();
        $this->load_js("pace.min");
        $this->load_bootstrapcss();
        $this->load_bootstrapjs();
        //select2
        $this->load_select2();
        //for material style
        $this->load_css("material");
        $this->load_js("jquery.jeditable");
        $this->load_js("cleave.min");
        $this->load_data_table();
        //        notification system
        $this->load_pnotify();
        //load css and js
        $datah['bsjas'] = $this->javascriptlib;
        $datah['bscss'] = $this->css_lib;

        if (@$CI->input->post("noheader")) {
            $CI->load->view("layout/header2", $datah);
            $CI->load->view($path, $datam);
            $CI->load->view("layout/footer", $dataf);
        } else {
            $CI->load->view("layout/header", $datah);
            $CI->load->view($path, $datam);
            $CI->load->view("layout/footer", $dataf);
        }
    }

    //    load bootstarp fast
    public function load_min_bt()
    {
        $CI = &get_instance();
        $CI->system->lis();
        $this->load_bootstrapjs();
        $this->load_bootstrapcss();
        return $this->javascriptlib . $this->css_lib;
    }

    //load without menu
    public function load2($path, $datam = null, $datah = null, $dataf = null, $title = null)
    {
        $CI = &get_instance();
        $CI->system->lis();
        $this->load_bootstrapcss();
        $this->load_bootstrapjs();
        $this->load_select2();
        $this->load_css("material");
        $this->load_js("jquery.jeditable");
        $this->load_js("cleave.min");
        $this->load_data_table();
        $this->load_pnotify();
        $bsjas = $this->javascriptlib;
        $bscss = $this->css_lib;
        $datah = array('bsjas' => $bsjas, 'bscss' => $bscss, "title" => $title);

        $CI->load->view("layout/header2", $datah);
        $CI->load->view($path, $datam);
        $CI->load->view("layout/footer", $dataf);
    }
    //load without menu
    public function load_login($path, $datam = null, $datah = null, $dataf = null)
    {
        $CI = &get_instance();
        $CI->system->lis();
        $this->load_css("bootstrap.min");
        if (_DIRECTION == "rtl") {$this->load_css("bootstrap-rtl.min");
        }
        $this->load_css("login");
        $this->load_js("jquery.min");
        $this->load_js("bootstrap.min");
        $bsjas = $this->javascriptlib;
        $bscss = $this->css_lib;
        $datah = array('bsjas' => $bsjas, 'bscss' => $bscss, "title" => _LOGIN . "-" . $CI->system->get_setting('login_title') . "-CANDO");
        $CI->load->view("layout/header2", $datah);
        $CI->load->view($path, $datam);
    }
    //load for ajax popup
    public function load_popup($view, $title = "", $data = array(),$return =false)
    {
        $this->load_select2();
        echo $this->javascriptlib . "\n" . $this->css_lib;
        $header = '<div class="modal-header"><button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button> <h4 class="modal-title"> <i class="fa fa-th-list "></i>  ' . $title . '</h4></div> <div class="modal-body">';
        $foother = '';
        $CI = &get_instance();
        $body = $header . $CI->load->view($view, $data, true) . $foother;
        if ($return) return $body;
        echo $body;

    }
    //load for simple ajax ajax
    public function load_ajax($view, $data = array())
    {
        $CI = &get_instance();
        $CI->system->lis();
        $this->load_select2();
        $body = $CI->load->view($view, $data, true);
        echo $body;
    }

    //standardad load js  automatic load javascript in header tag
    public function load_js($name, $folder = "assets/js", $base = "")
    {
        $this->javascriptlib .= "<script type='text/javascript' src='" . base_url() . "$base/$folder/$name.js'" . "> </script> \n";
    }

    //automatic load cc in header tag
    public function load_css($name, $folder = "assets/css", $base = "")
    {
        $CI = &get_instance();
        if ($CI->system->chk_chk == 2) {return null;
        }

        $this->css_lib .= "<link rel='stylesheet' type='text/css' href='" . base_url() . "$base/$folder/$name.css'" . "/> \n";
    }

    //load print css
    public function load_print_css()
    {
        echo "<link rel='stylesheet' type='text/css' href='" . base_url() . "/assets/css/print.css'" . "/>";
    }

    public function load_angular()
    {
        return "<script type='text/javascript' src='" . base_url() . "/assets/js/angular.min.js'" . "> </script>";
    }

    //load print logo
    public function load_print_logo()
    {
        $CI = &get_instance();
        return $CI->system->get_setting("print_logo");
    }

    //    load select2 library java scrip for replace drop down form element
    public function load_select2()
    {
        $this->load_js("select2.min");
        $this->load_js("select2.def");
        $this->load_css("select2.min");
    }
    // load data table css and java script use for crud
    public function load_data_table()
    {
        $this->load_js("datatables.min");
        $this->load_css("datatables.min");
    }

    // deafult bootstrap java script library
    public function load_bootstrapjs()
    {
        $this->load_js("jquery.min");
        $this->load_js("bootstrap.min");
    }
    //load bootstrap css and css of piero admin
    public function load_bootstrapcss()
    {
        $this->load_css("bootstrap.min");
        $this->load_css("piero-admin");
        $this->load_css("font-awesome/css/font-awesome.min");

        // if set direction rtl مخصوص زبانهای فارسی و عربی
        // باید در زبان direction=rtl
        if (_DIRECTION == "rtl") {
            $this->load_css("bootstrap-rtl.min");
            $this->load_css("piero-admin-rtl");
        }

        //for other css options
        $this->load_css("custom");
        $this->load_css("responsive");
    }

    //for load java script library directly
    public function load_custom_js($name, $folder = "assets/js", $base = "")
    {
        return "<script type='text/javascript' src='" . base_url() . "$base/$folder/$name.js'" . "> </script> ";
    }

    //for load java script library directly
    public function load_custom_css($name, $folder = "assets/css", $base = "")
    {
        return "<link rel='stylesheet' type='text/css' href='" . base_url() . "$base/$folder/$name.css'" . "/> ";
    }

    public function load_header_html()
    {
        ?>
<!--        ----------------   power by : pirooz jenabi     --------------------->
<!--        ----------------   Copyright : piero group      --------------------->
<!--        ----------------   Email:info@piero.ir          --------------------->
<!--        ----------------   Support:+983136519040        --------------------->
        <meta name="description" content="Best ERP , CRM , BPM , SELL SYSTEM &  ... by piero group | join in www.piero.ir">
        <?php

    }
    //load pnotify library
    public function load_pnotify()
    {
        $this->load_js("pnotify.custom.min");
        $this->load_css("pnotify.custom.min");
    }

    public function load_static_datatable_js()
    {
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.dataTbl').DataTable( {
                    stateSave: true,
                    scrollY:'50vh',
                    scrollCollapse: true,
                "lengthMenu": [[10, 25, 50,100,200,500, -1], [10, 25, 50, 100 , 200 , 500 ,"<?php echo _ALL ?>"]],
                    dom: 'Blfrtip',
                buttons: [
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-table" ></i>  <?php echo _VIEW . __ . _COLUMNS ?> '
                },
                {
                    extend: 'copy',
                    text: '<i class="fa fa-copy" > </i> <?php echo _COPY ?> '
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-excel-o" ></i> <?php echo _EXCEL_CSV ?>'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print" > </i> <?php echo _PRINT ?> ',
                    autoPrint: false,
                    exportOptions: {
                    columns: ':visible',
                },
                customize: function (win) {
                    $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                    $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                    $(this).css('background-color','#D0D0D0');
                });
                    $(win.document.body).find('h1').html("<?php echo _PRINT ?>");
                    $(win.document.body).find('h1').css("text-align","center");
                    $(win.document.body).find('h1').css("font-size","18px");
                }
                }
                ],
                "language": {
                "lengthMenu": "<?php echo _VIEW ?> _MENU_ <?php echo _PER_PAGE ?>",
                "zeroRecords": "<?php echo _NOT_FOUND ?>",
                "info": "<?php echo _VIEW_PAGE ?> _PAGE_ <?php echo _OF ?> _PAGES_",
                "infoEmpty": "<?php echo _NOT_FOUND ?>",
                "infoFiltered": "(<?php echo _FILTERED_FROM ?> _MAX_ <?php echo _RECORD ?>)",
                "search": "<i class='fa fa-search '>",
                "pagingType": "full_numbers",
                "oPaginate": {
                "sFirst":        "<?php echo _FIRST ?> <i class='fa fa-fast-fa-backward '> </i>",
                "sPrevious":     "<?php echo _PREVIOUS ?> <i class='fa fa-chevron-left  '> </i>",
                "sNext":         "<i class='fa fa-chevron-right '> </i> <?php echo _NEXT ?> ",
                "sLast":         "<i class='fa fa-fast-forward '> </i> <?php echo _LAST ?> "
                }
                },
                "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                    i : 0;
                };
                // Total over this page
                pageTotal5 = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                pageTotal4 = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                return intVal(a) + intVal(b);
                }, 0 );
                pageTotal3 = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                pageTotal5=pageTotal5.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                pageTotal4=pageTotal4.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                pageTotal3=pageTotal3.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                // Update footer
                $( api.column( 5 ).footer() ).html(
                pageTotal5
                );
                $( api.column( 4 ).footer() ).html(
                pageTotal4
                );
                $( api.column( 3 ).footer() ).html(
                pageTotal3
                );
                }
            } );
        } );
        </script>
        <?php
}

}
?>
