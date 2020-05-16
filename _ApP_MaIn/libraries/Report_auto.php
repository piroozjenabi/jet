<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

// info for select_db ----------------------- end
class Report_auto{
    //database opttions
    var $table = null;//name of table
    var $column_order = array();//columns to load
    var $column_search = array();//for search
    var $column_params = array();//for get params data
    var $order = null;//for sorting
    var $where;//for where
    var $join = null;
    var $join2 = null;
    var $limit = null;
    //general options
    var $title = null;//name of table
    var $column_title = array();//columns to load in header and footer
    var $column_type = array();//columns type for add and edit and view
    var $column_require = array();//for search
    var $data = null;// data of table
    var $datatable_options = null; // data table option for load in java script
    var $tableId = null;//table id for jquery
    var $actions = null;//other html for header
    var $actions_row = null;//other buttons for rows replace [[id]]
    var $form_id = null;
//------------------------------------------database start

    public function __construct($form_id = null)
    {
        $this->form_id = $form_id[0];
    }


//    render query
    private function _get_datatables_query()
    {
        $CI =& get_instance();
        if ($this->table == null) die("first select your db");
        $CI->db->from($this->table);
        $i = 0;

        //filter_start

        foreach ($CI->input->post() as $key => $value) {

            if (strpos(" " . $key, "f__") && $value)//for detect filter
            {
                $tmp_f = str_replace("f__", null, $key);
                $CI->db->like($tmp_f, "$value");
            }
        }
        //filter end

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $CI->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $CI->db->like($item, $_POST['search']['value']);
                } else {
                    $CI->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $CI->db->group_end(); //close bracket
            }
            $i++;
        }

        if ($this->limit) {
            $CI->db->limit($this->limit);
        }

        if ($this->where) {
            $CI->db->where($this->where);
        }
        if ($this->join) {
            $CI->db->join($this->join[0], $this->join[1]);
        }
        if ($this->join2) {
            $CI->db->join($this->join2[0], $this->join2[1]);
        }

        if (isset($_POST['order'])) // here order processing
        {
            $CI->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $CI->db->order_by(key($order), $order[key($order)]);
        }
    }
    //for filterted value
    function count_filtered()
    {
        $CI =& get_instance();
        $this->_get_datatables_query();
        $query = $CI->db->get();
        return $query->num_rows();
    }
    //GET COOUNT OF AL
    public function count_all()
    {
        $CI =& get_instance();
        $CI->db->from($this->table);
        return $CI->db->count_all_results();
    }

    //render data FROM DATABASE
    function list_ajax()
    {
        $CI =& get_instance();
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $CI->db->limit($_POST['length'], $_POST['start']);
        return $CI->db->get()->result();

    }


    public function get_by_id($id)
    {
        $CI =& get_instance();
        $CI->db->from($this->table);
        $CI->db->where('id', $id);
        $query = $CI->db->get();
        return $query->row();
    }




//------------------------------database end

//------------------------------view start

    private function load_header()
    {
        ?>

        <?php
    }
    private function load_action()
    {
        ?>
        <div class="btn-group" style="padding: 5px;">
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> <?= _REFRESH ?>
            </button>
            <?= $this->actions ?>
        </div>
        <?php
    }


private function load_table()
{
    $CI =& get_instance();
    $CI->load->library("Auto");
    $CI->load->helper("form");
    $c = 0;
    ?>
    <?= form_open("#", array("id" => "_filter")) ?>

    <table id="<?= $this->tableId ?>" class="display" cellspacing="0" width="100%">
        <thead>

        <tr id="filter">

            <td><span class="btn btn-default" onclick="reset_filter()"> <i class="fa fa-refresh"></i>  </span></td>


            <?php foreach ($this->column_search as $k){
                echo "<td>";
                switch ($this->column_type[$c]){

                    case "input" :
                        echo form_input("f__".$this->column_order[$c],null,array("id"=>"f__".$k ,"class"=>"filtering form-control")) ;
                        break;
                        case "date":
//                            echo $CI->element->date_input("f__".$this->column_order[$c] ,0);
                        echo form_input("f__".$this->column_order[$c],null,array("id"=>"f__".$k ,"class"=>"filtering form-control")) ;
                        break;

                        case "select_field_data":
                            $data=$CI->element->pselect("auto_forms_field_data","name",null,_DEF_ELEMENT,"group_id=".json_decode($this->column_params[$c])->data_group);
                            echo form_dropdown("f__".$this->column_order[$c],$data,null,array("class"=>"filtering form-control","id"=>"f__".$this->column_order[$c]));
                        break;

                        case "select_field_data_group":
                            $CI =& get_instance();
                            $CI->load->helper('form');
                            $CI->load->library('Element');
                            $tmp=$CI->db->select("*")
                                ->where("parent",json_decode($this->column_params[$c])->data_parent)
                                ->from("auto_forms_field_data_group")
                                ->get()->result_array();
                            $data=array();
                            $data[""]="";

                            foreach ($tmp as $k => $v)
                            {
                                $data[$v["name"]]=$CI->element->pselect("auto_forms_field_data","name",null,"no","group_id=".$v["id"]);

                            }
                            echo form_dropdown("f__".$this->column_order[$c],$data,null,array("class"=>"filtering form-control","id"=>"f__".$this->column_order[$c]));
                        break;

                        case "select_db":
                            $tmp=json_decode($this->column_params[$c]);
                            $data=$CI->element->pselect($tmp->table,(isset($tmp->name))?$tmp->name:"name" , (isset($tmp->postfix))?$tmp->postfix:"",(isset($tmp->def))?$tmp->def:_DEF_ELEMENT,(isset($tmp->where))?$tmp->where:"");
                            echo form_dropdown("f__".$this->column_order[$c],$data,null,array("class"=>"filtering form-control","id"=>"f__".$this->column_order[$c]));
                        break;

                        case "select_bool":
                            echo form_dropdown("f__".$this->column_order[$c],array(0=>_FALSE,1=>_TRUE),null,array("class"=>"filtering form-control","id"=>"f__".$this->column_order[$c]));
                        break;

                        case "select_json":
                            echo form_dropdown("f__".$this->column_order[$c],json_decode($this->column_params[$c])->data,null,array("class"=>"filtering form-control","id"=>"f__".$this->column_order[$c]));
                        break;
                    default:


                }

                echo "</td>";
                $c++;
            } ?>
            </tr>
            <tr>
                <th><i class="fa fa-sort-numeric-asc "></i> </th>
                <?php foreach ($this->column_title as $k): ?>
                    <th><?=$k?></th>
                <?php endforeach; ?>

            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <th><?= _TOTAL_PLUS ?> </th>
                <?php foreach ($this->column_title as $k): ?>
                    <th><?=$k?></th>
                <?php endforeach; ?>

            </tr>
            </tfoot>
        </table>

        <?= form_close(); ?>
        <script type="text/javascript">
            var result = {};
            $(".filtering").on("keyup",function () {
                table.ajax.reload(null,false); //reload datatable ajax


            });
            $(".filtering").on("change",function () {
                table.ajax.reload(null,false); //reload datatable ajax


            });
            function reset_filter() {
                $('#_filter')[0].reset();
                table.ajax.reload(null,false); //reload datatable ajax
            }

        </script>
        <?php
    }

    private function load_datatable($url)
    {
        ?>
        <script type="text/javascript">
            var table;
            $(document).ready(function() {
                //datatables
                table = $('#<?=$this->tableId ?>').DataTable({
                    "sScrollX": "100%",
                    "sScrollXInner": "110%",
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        <?php
                        $c=1;
                        foreach ($this->column_type as $key){
                            if($key=="input"){
                            ?>
                        // Total over all pages
                        total = api
                            .column( <?=$c ?> )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        // Update footer
                        $( api.column( <?=$c ?> ).footer() ).html(
                             total
                        );
                        <?php }$c++; } ?>
                        $( api.column(1 ).footer() ).html(
                            "--"
                        );
                    },



                    // Total over this page
//                        pageTotal = api
//                            .column( 4, { page: 'current'} )
//                            .data()
//                            .reduce( function (a, b) {
//                                return intVal(a) + intVal(b);
//                            }, 0 );

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.
                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?= $url ."/".$this->form_id?>",
                        "type": "POST",
                        "data": function ( data ) {
                            data.typeIn = 'json';
                            data.form_id = '<?= $this->form_id ?>';
                            <?=($this->where) ? "data.where = '$this->where' ;" : null ;?>
                            <?php // for detect filtering to send
                            foreach ($this->column_search as $k){
                                $tmp="f__".$k;
                                echo " data.$tmp = $('#$tmp').val();" ;
                            } ?>
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [ 0 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ], stateSave: true,
                    scrollY:'50vh'  ,

                    "lengthMenu": [[10, 25, 50,100,200,500, -1], [10, 25, 50, 100 , 200 , 500 ,"<?=_ALL ?>"]],
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-table" ></i>  <?=_VIEW.__._COLUMNS ?> '
                        },
                        {
                            extend: 'copy',
                            text: '<i class="fa fa-copy" > </i> <?=_COPY ?> '
                        },
                        {
                            extend: 'csv',
                            "filename":"<?=$this->title.rand(0,100) ?>",
                            text: '<i class="fa fa-file-excel-o" ></i> EXCEL/CSV',
                            charset: 'UTF-16LE',

                            bom: true
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print" > </i> <?= _PRINT ?> ',
                            autoPrint: false,
                            exportOptions: {
                                columns: ':visible',
                            },
                            customize: function (win) {
                                $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                                $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                                    $(this).css('background-color','#D0D0D0');
                                });
                                $(win.document.body).find('h1').html("<?=$this->title ?>");
                                $(win.document.body).find('h1').css("text-align","center");
                                $(win.document.body).find('h1').css("font-size","18px");
                            }
                        }
                    ],
                    "language": {
                        "lengthMenu": "<?=_VIEW?> _MENU_ <?= _PER_PAGE ?>",
                        "zeroRecords": "<?=_NOT_FOUND?>",
                        "info": "<?= _VIEW_PAGE?> _PAGE_ <?=_OF?> _PAGES_",
                        "infoEmpty": "<?=_NOT_FOUND?>",
                        "infoFiltered": "(<?= _FILTERED_FROM ?> _MAX_ <?=_RECORD?>)",
                        "search": "<i class='fa fa-search '>",
                        "pagingType": "full_numbers",
                        "processing": "<div class='loading' > </div>",
                        "oPaginate": {
                            "sFirst":    	"<?= _FIRST?> <i class='fa fa-fast-fa-backward '> </i>",
                            "sPrevious": 	"<?= _PREVIOUS?> <i class='fa fa-chevron-left  '> </i>",
                            "sNext":     	"<i class='fa fa-chevron-right '> </i> <?= _NEXT?> ",
                            "sLast":     	"<i class='fa fa-fast-forward '> </i> <?= _LAST?> "
                        }
                    }
                });

                //set input/textarea/select event when change value, remove class error and remove text help block

            });



            function reload_table()
            {
                table.ajax.reload(null,false); //reload datatable ajax
            }



        </script>
        <?php
    }

//------------------------------view end
//------------------------------render start
    function render_url($def=null)
    {
        $CI=&get_instance();
        $def=($def)?$def:$CI->router->method;
        return site_url($CI->router->directory.$CI->router->class.'/'.$def) ;
    }
    //out for table
    private function render_view()
    {
        ob_start();
        $this->load_header();
        $this->load_action();
        $this->load_table();
        $this->load_datatable($this->render_url());
        $output = ob_get_contents();
        ob_end_clean();
        return$output;
    }

    //out for ajax out in datatable
    function render_ajax_list()
    {
        $CI=&get_instance();
        $list = $this->list_ajax();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $k) {
            $no++;
            $row = array();
            $row[] = $no;
            $c=0;
            foreach ($this->column_order as $key)
            {
                switch ($this->column_type[$c]){
                    case ("number"):
                        $row[] = number_format($k->$key) ;
                        break;

                        case ("word"):
                        $row[] = $k->$key ;
                        break;
                    case ("bool"):
//                    $row[] = ($k->$key)?_TRUE:_FALSE;
                        $row[] = ($k->$key)?_TRUE:_FALSE;
                        break;
                    case ("input"):
                        $row[] = $k->$key;
                        break;
                        case ("id")://for write id
                        $row[] = $k->$key;
                        break;
                    case ("select_field_data"):
                        $tmp=$CI->db->get_where("auto_forms_field_data","id=".$k->$key)->row();
                        if(isset($tmp))
                        $row[] = $tmp->value ;
                        else
                        $row[]=null;
                        break;
                        case ("select_field_data_group"):
                        $tmp=$CI->db->get_where("auto_forms_field_data","id=".$k->$key)->row();
                        if(isset($tmp))
                        $row[] = $tmp->value ;
                        else
                        $row[]=null;
                        break;
                    case ("date"):
                        $CI->load->library('Piero_jdate');
                        $row[] = ($k->$key)?$CI->piero_jdate->jdate("Y/m/d", $k->$key):null ;
                        break;
                    default:
                        //mavared pichide keniaz ba tarkib json darad
                        if (strpos($this->column_type[$c],"array")){
                            $tmp_array =(array) json_decode( $this->column_type[$c] );
                            $tmp=(array) $tmp_array[1];
                            $row[]=$tmp[$k->$key];
                        }
                        else if (strpos($this->column_type[$c],"select_db"))
                        {
                            if($k->$key){
                                $tmp_array=json_decode($this->column_type[$c]);
                                $row[]=@$CI->db->select($tmp_array[2])->from($tmp_array[1])->where("id",$k->$key)->get()->result_array()[0][$tmp_array[2]];
                            }
                            else
                                $row[] = $k->$key;

                        }
                        else
                            $row[] = $this->column_type[$c];
                }
                $c++;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    //total render
    function render($view="Dtbl_List") {
        $CI            =& get_instance();
        $this->tableId = "taBle" . rand( 0, 1000 );
        if ( $CI->input->post( "where", true ) ) {
            $this->where = $CI->input->post( "where", true );
        }
        switch ( $CI->input->post( "typeIn", true ) ) {
            case "json":
                $this->render_ajax_list();
                break;

            default:
                $CI->template->load( $view, array( "out" => $this->render_view() ,"form_id"=>$this->form_id) );
        }
    }




}
