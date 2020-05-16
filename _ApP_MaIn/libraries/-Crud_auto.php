<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 4/3/17
 * Time: 3:01 PM
 */

//crud library

// info for select_db ----------------------- start
//param 1 : define select_db type and not user
//param 2 : define database
//param 3 : name of col
//param 4 : where
//param 5 : order
//exam  $tmp_selectdb=array("select_db","tbl_usergroup_eemploy","name");
//$this->crud->column_type=array("input","bool",json_encode($tmp_selectdb));
// info for select_db ----------------------- end
class Crud_auto
{
    //database opttions
    var $table=null;//name of table
    var $column_order = array();//columns to load
    var $column_search = array("value");//for search
    var $order = null;//for sorting
    var $where ;//for where
    var $form_id=null;
    //    var  $join =array(0=>'auto_forms_value',1=>"auto_fields_value.form_value_id=auto_forms_value.id");
    var $join1 =null;
    var $join =null;
    var $limit=null;
    //general options
    var $title=null;//name of table
    var $column_title = array();//columns to load in header and footer
    //    var $column_title = array("#",_VALUE,"field_id","date","form_id","type","name","des");//columns to load in header and footer
    var $column_type = array();//columns type for add and edit and view
    //    var $column_type = array("input","input","input","input","input","input","input","input");//columns type for add and edit and view
    var $permision=array("add"=>false,"edit"=>false,"delete" =>false);//permisions
    var $datatable_options=null; // data table option for load in java script
    var $tableId=null;//table id for jquery
    var $actions=null;//other html for header
    var $color_row=null;//[[]] for row color from db
    //------------------------------------------database start
    //    render query

    public function __construct($form_id=null)
    {
        $CI=&get_instance();
        $CI->load->library("auto");
        $this->form_id=$form_id[0];
        $this->render_base();

    }
    //fetch all variable
    public function render_base()
    {
        $CI=&get_instance();
        $this->form_id=($this->form_id)?$this->form_id:$CI->input->post("form_id", true);
        $res=$CI->auto->list_field_from_id($this->form_id);

        $CI->load->model("AUTO/Auto_forge_model", "forge");
        $tmp_title=array();
        $tmp_name=array();
        $tmp_type=array();
        $tmp_params=array();
        foreach ($res as $key => $value)
        {
            if($CI->forge->elements[$value["type"]]) {

                $tmp_title[] = $value["des"];
                $tmp_name[] = $value["name"];
                $tmp_type[] = $value["type"];
            }
            //            $tmp_params[]=$value["params"];
        }
        $this->column_title=$tmp_title;
        $this->column_order=$tmp_name;
        $this->column_type=$tmp_type;

    }

    private function _get_datatables_query()
    {

        $CI=&get_instance();
        $CI->load->helper("form");
        if($this->table==null) { die("first select your db");
        }
        //add custom filter  end
        $CI->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $CI->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $CI->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $CI->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) { //last loop
                    $CI->db->group_end(); //close bracket
                }
            }
            $i++;
        }

        if(isset($this->form_id)) {
            $CI->db->where("form_id", $this->form_id);
        }

        if($this->limit) {
            $CI->db->limit($this->limit);
        }

        if($this->where) {
            $CI->db->where($this->where);
        }
        if($this->join1) {
            $CI->db->join($this->join1[0], $this->join1[1]);
        }
        if($this->join) {
            $CI->db->join($this->join[0], $this->join[1]);
        }
        if(isset($_POST['order'])) // here order processing
        {
            $CI->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order)) {
            $order = $this->order;
            $CI->db->order_by(key($order), $order[key($order)]);
        }
    }
    //for filterted value
    function count_filtered()
    {
        $CI=&get_instance();
        $this->_get_datatables_query();
        $CI->db->distinct();
        //        $CI->db->select("form_value_id");
        $query = $CI->db->get();
        return $query->num_rows();
    }
    //GET COOUNT OF AL
    public function count_all()
    {
        $CI=&get_instance();
        $CI->db->distinct();
        $CI->db->select("form_value_id");
        $CI->db->from($this->table);
        return $CI->db->count_all_results();
    }

    //render data FROM DATABASE
    function list_ajax()
    {
        $CI=&get_instance();
        $lenght=$_POST['length']*count($this->column_title);
        $start=$_POST['start']*count($this->column_title);
        $this->_get_datatables_query();
        if($_POST['length'] != -1) {
            $CI->db->limit($lenght, $start);
        }
        $res=$CI->db->get()->result();

        return $res;

    }
    public function get_by_id($id)
    {
        $CI=&get_instance();
        $CI->db->from($this->table);
        $CI->db->where('id', $id);
        $query = $CI->db->get();
        return $query->row();
    }

    public function save($data)
    {
        if($this->permision["add"]) {
            $data["id"]=null;
            $CI =& get_instance();
            $CI->db->insert($this->table, $data);
            return $CI->db->insert_id();
        }
    }

    public function update($where, $data)
    {
        if($this->permision["edit"]) {
            $CI =& get_instance();
            $CI->db->update($this->table, $data, $where);
            return $CI->db->affected_rows();


        }
    }

    public function delete_by_id($id)
    {
        if($this->permision["delete"]) {
            $CI=&get_instance();
            $CI->db->where('id', $id);
            $CI->db->delete($this->table);
        }
    }



    //------------------------------database end

    //------------------------------controll start

    //------------------------------controller end
    //------------------------------view start

    private function load_header()
    {
        echo "<hr>";
    }
    private function load_action()
    {
        ?>
        <div class="btn-group" style="padding: 5px;">
        <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> <?php echo _REFRESH ?> </button>
        <?php echo $this->actions?>
        </div>
        <?php
    }


    private function load_table()
    {
        $CI=&get_instance();
        $CI->load->helper("form");
        $c=0;
        ?>
        <?php echo form_open("#", array("id"=>"_filter")) ?>
        <table id="<?php echo $this->tableId ?>" class="display" cellspacing="0" width="100%">
            <thead>

            <tr  id="filter">

                <td> <span class="btn btn-default" onclick="reset_filter()" > <i class="fa fa-refresh"></i>  </span></td>
                <td></td>
                <?php foreach ($this->column_title as $k): ?>
                    <td >
                        <?php echo form_input("f__".$this->column_order[$c], null, array("id"=>"f__".$this->column_order[$c] ,"placeholder"=> $k,"class"=>"filtering form-control")) ?>
                    </td>
                    <?php
                    $c++;
                endforeach; ?>

            </tr>
            <tr>
                <th><i class="fa fa-sort-numeric-asc "></i> </th>
                <th>#</th>
                <?php foreach ($this->column_title as $k): ?>
                <th >
                    <?php echo $k?>
                </th>
                <?php endforeach; ?>
                <?php if ($this->permision["edit"] || $this->permision["delete"]) : ?>
                    <th><?php echo _OP ?></th>
                <?php endif; ?>
            </tr>

            </thead>
            <tbody>

            </tbody>
            <tfoot>
            <tr>
                <th><i class="fa fa-sort-numeric-asc "></i> </th>
                <?php foreach ($this->column_title as $k): ?>
                    <th><?php echo $k?></th>
                <?php endforeach; ?>
                <?php if ($this->permision["edit"] || $this->permision["delete"]) : ?>
                <th><?php echo _OP ?>
                </th>
                <?php endif; ?>
            </tr>
            </tfoot>
        </table>
        <?php echo form_close(); ?>
        <script type="text/javascript">
            var result = {};
        $(".filtering").on("keyup",function () {
            table.ajax.reload(null,false); //reload datatable ajax


        })
        function reset_filter() {
            $('#_filter')[0].reset();
            table.ajax.reload(null,false); //reload datatable ajax
        }

        </script>
    <?php
    }

    private function load_modal()
    {
    }


    private function load_datatable($url)
    {
    ?>

        <script type="text/javascript">
            var table;
            $(document).ready(function() {
                //datatables

                table = $('#<?php echo $this->tableId ?>').DataTable({
                    "scrollX": true,
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.
                    // Load data for the table's content from an Ajax source
                    "ajax": {

                        "url": "<?php echo $url?>",
                        "type": "POST",
                        "data": function ( data ) {
                            data.typeIn = 'json';
                            data.form_id = '<?php echo $this->form_id ?>';
                            <?php echo ($this->where) ? "data.where = '$this->where'" : null;?>
                            <?php // for detect filtering to send
                            $c=0;
                            foreach ($this->column_title as $k){
                                $tmp="f__".$this->column_order[$c];
                                echo " data.$tmp = $('#$tmp').val();" ;
                                $c++;
                            } ?>
                                    }


//                            Object.assign({'typeIn':'json'<?//=($this->where)?",'where':'$this->where'":null;?>//},$("#_filter").serializeArray())
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [ 0 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ], stateSave: true,
                    scrollY:'70vh'  ,

                    "lengthMenu": [[10, 25, 50,100,200,500, -1], [10, 25, 50, 100 , 200 , 500 ,"<?php echo _ALL ?>"]],
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-table" ></i>  <?php echo _VIEW.__._COLUMNS ?> '
                        },
                        {
                            extend: 'copy',
                            text: '<i class="fa fa-copy" > </i> <?php echo _COPY ?> '
                        },
                        {
                            extend: 'csv',
                            "filename":"<?php echo $this->title.rand(0, 100) ?>",
                            text: '<i class="fa fa-file-excel-o" ></i> EXCEL/CSV',
                            charset: 'UTF-16LE',

                            bom: true
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
                                $(win.document.body).find('h1').html("<?php echo $this->title ?>");
                                $(win.document.body).find('h1').css("text-align","center");
                                $(win.document.body).find('h1').css("font-size","18px");
                            }
                        }
                    ],
                    "language": {
                        "lengthMenu": "<?php echo _VIEW?> _MENU_ <?php echo _PER_PAGE ?>",
                        "zeroRecords": "<?php echo _NOT_FOUND?>",
                        "info": "<?php echo _VIEW_PAGE?> _PAGE_ <?php echo _OF?> _PAGES_",
                        "infoEmpty": "<?php echo _NOT_FOUND?>",
                        "infoFiltered": "(<?php echo _FILTERED_FROM ?> _MAX_ <?php echo _RECORD?>)",
                        "search": "<i class='fa fa-search '>",
                        "pagingType": "full_numbers",
                        "processing": "<div class='loading' > </div>",
                        "oPaginate": {
                            "sFirst":        "<?php echo _FIRST?> <i class='fa fa-fast-fa-backward '> </i>",
                            "sPrevious":     "<?php echo _PREVIOUS?> <i class='fa fa-chevron-left  '> </i>",
                            "sNext":         "<i class='fa fa-chevron-right '> </i> <?php echo _NEXT?> ",
                            "sLast":         "<i class='fa fa-fast-forward '> </i> <?php echo _LAST?> "
                        }
                    }
                });

                //set input/textarea/select event when change value, remove class error and remove text help block
                $("input").change(function(){
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("textarea").change(function(){
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("select").change(function(){
                    $(this).parent().parent().removeClass('has-error');
//                    $(this).next().empty();
                });
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
        return site_url($CI->router->directory.$CI->router->class.'/'.$def);
    }
    //out for table
    private function render_view()
    {
        ob_start();
        $this->load_header();
        $this->load_action();
        $this->load_table();
        $this->load_modal();
        $this->load_datatable($this->render_url());
        $output = ob_get_contents();
        ob_end_clean();
        return$output;
    }
    //generate filter array from post
    private function filter_array()
    {
        $CI=&get_instance();
        $tmp_post = $CI->input->post();
        $out=array();
        foreach ($tmp_post as $key => $value)
        {

            if (strpos(" ".$key, "f__") && $value)//for detect filter
            {
                $out[str_replace("f__", null, $key)] =$value ;
            }
        }
        return $out;
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
                    $row[] = number_format($k->$key);
                    break;
                case ("bool"):
                    //                    $row[] = ($k->$key)?_TRUE:_FALSE;
                    $row[] = ($k->$key)?_TRUE:_FALSE;
                    break;
                case ("input"):
                    $row[] = $k->$key;
                    break;
                case ("client"):
                    $row[] = $CI->system->get_user_from_id($k->$key);
                    break;
                case ("date"):
                    $CI->load->library('Piero_jdate');
                    $row[] = ($k->$key)?$CI->piero_jdate->jdate("Y/m/d",  rtrim($k->$key, '0000')):null ;
                    //                    $row[] =$k->$key;

                    break;
                case ("json"):
                    $CI->load->library('Piero_jdate');
                    $row[] =$CI->piero_jdate->jdate("Y/m/d", json_decode($k->$key)->datecheck);
                    break;
                default:
                    //mavared pichide keniaz ba tarkib json darad
                    if (strpos($this->column_type[$c], "array")) {
                        $tmp_array =(array) json_decode($this->column_type[$c]);
                        $tmp=(array) $tmp_array[1];
                        $row[]=$tmp[$k->$key];
                    }
                    else if (strpos($this->column_type[$c], "select_db")) {
                        if($k->$key) {
                            $tmp_array=json_decode($this->column_type[$c]);
                            $row[]=@$CI->db->select($tmp_array[2])->from($tmp_array[1])->where("id", $k->$key)->get()->result_array()[0][$tmp_array[2]];
                        }
                        else {
                            $row[] = $k->$key;
                        }

                    }
                    else {
                        $row[] = $k->$key;
                    }
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
    function render($view="Dtbl_List")
    {
        $CI            =& get_instance();
        $this->tableId = "taBle" . rand(0, 1000);
        if ($CI->input->post("where", true) ) {
            $this->where = $CI->input->post("where", true);
        }
        switch ( $CI->input->post("typeIn", true) ) {
        case "json":
            $this->render_ajax_list();
            break;
        default:
            $CI->template->load($view, array( "out" => $this->render_view() ));
        }
    }




}
