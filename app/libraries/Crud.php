<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

// info for select_db ----------------------- start
//param 1 : define select_db type and not user
//param 2 : define database
//param 3 : name of col
//param 4 : where
//param 5 : order
//exam  $tmp_selectdb=array("select_db","usergroup_eemploy","name");
//$this->crud->column_type=array("input","bool","boolYN","text",json_encode($tmp_selectdb));
// info for select_db ----------------------- end
class Crud
{
    //database opttions
    public $table = null; //name of table
    public $column_order = array(); //columns to load
    public $column_search = array(); //for search
    public $column_filter = array(); //for search
    public $column_list = array(); // if setted list just show this columns
    public $order = array('id' => 'DESC'); //for sorting
    public $where; //for where
    public $join = null;
    public $limit = null;
    public $group_by = null;
    //general options
    public $title = null; //name of table
    public $column_title = array(); //columns to load in header and footer
    public $column_type = array(); //columns type for add and edit and view
    public $column_require = array(); //for search
    public $permission = array("add" => true, "edit" => true, "delete" => true, "copy" => null, "view" => true); 
    public $data = null; // data of table
    public $datatable_options = null; // data table option for load in java script
    public $tableId = null; //table id for jquery
    public $actions = null; //other html for header
    public $actions_row = null; //other buttons for rows replace [[id]]
    public $color_row = null; //[[]] for row color from db
    public $form_add = []; //add this codes to add form

    private $select = null;
    // do some work after bellow operations
    public $add_action = null; // array("model"=>"","function"=>)
    public $edit_action = null; // array("model"=>"","function"=>)
    public $delete_action = null; // array("model"=>"","function"=>)
    //------------------------------------------database start
    //    render query
    private function _get_datatables_query()
    {
        $CI = &get_instance();
        if ($this->table == null) {
            die("first select your db");
        }

        $CI->db
            ->select($this->select)
            ->from($this->table);
        $i = 0;
        //filter_start

        foreach ($CI->input->post() as $key => $value) {

            if (strpos(" " . $key, "f__") && $value) //for detect filter
            {
                $tmp_f = str_replace("f__", null, $key);
                $CI->db->like($tmp_f, "$value");
            } elseif (strpos(" " . $key, "from__") && $value) {
                $tmp_f = str_replace("from__", null, $key);
                $CI->db->where(" $tmp_f > '$value'");
            } elseif (strpos(" " . $key, "to__") && $value) {
                $tmp_f = str_replace("to__", null, $key);
                $CI->db->where(" $tmp_f < '$value'");
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

                if (count($this->column_search) - 1 == $i) { //last loop
                    $CI->db->group_end(); //close bracket
                }
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
            foreach ($this->join as $key => $value) {
                $value[2] = (isset($value[2]) && $value[2]) ? $value[2] : null;
                $CI->db->join($value[0], $value[1], $value[2]);
            }
        }
        // add group by
        if ($this->group_by) {
            $CI->db->group_by($this->group_by);
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
    public function count_filtered()
    {
        $CI = &get_instance();
        $this->_get_datatables_query();
        $query = $CI->db->get();
        return $query->num_rows();
    }
    //GET COOUNT OF AL
    public function count_all()
    {
        $CI = &get_instance();
        $CI->db->from($this->table);
        return $CI->db->count_all_results();
    }

    //render data FROM DATABASE
    public function list_ajax()
    {
        $CI = &get_instance();
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $CI->db->limit($_POST['length'], $_POST['start']);
        }
        return $CI->db->get()->result();
    }

    public function get_by_id($id)
    {
        $CI = &get_instance();
        $CI->db->from($this->table);
        $CI->db->where('id', $id);
        $query = $CI->db->get();
        return $query->row();
    }

    public function save($data)
    {
        if ($this->permission["add"]) {
            $data["id"] = null;

            $CI = &get_instance();
            $CI->db->insert($this->table, $data);
            return $CI->db->insert_id();
        }
    }

    public function update($where, $data)
    {
        if ($this->permission["edit"]) {
            //            for delete updates in form add
            foreach ($this->form_add as $key => $value) {
                unset($data[$key]);
            }
            $CI = &get_instance();
            $CI->db->update($this->table, $data, $where);
            return $CI->db->affected_rows();
        }
    }

    public function delete_by_id($id)
    {
        if ($this->permission["delete"]) {
            $CI = &get_instance();
            $CI->db->where('id', $id);
            return $CI->db->delete($this->table);
        }
    }

    public function delete_group_by_id($ids)
    {
        if ($this->permission["delete"]) {
            $CI = &get_instance();
            $CI->db->where_in('id', $ids);
            return $CI->db->delete($this->table);
        }
    }

    //------------------------------database end

    //------------------------------controll start

    public function _validate()
    {
        $CI = &get_instance();
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;
        $c = 0;
        foreach ($this->column_order as $k) {

            if ($CI->input->post($k) == '' && $this->column_require[$c] == 1) {
                $data['inputerror'][] = $k;
                $data['error_string'][] = $this->column_title[$c] . __ . _IS_REQUIRED . '<br>';
                $data['status'] = false;
            }

            $c++;
        }
        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function ajax_edit()
    {
        $CI = &get_instance();
        $id = $CI->input->post("id", true);
        $data = $this->get_by_id($id);
        //        $data->price = number_format($data->price);
        echo json_encode($data);
    }
    public function ajax_view()
    {
        $CI = &get_instance();
        $id = $CI->input->post("id", true);
        $data = $this->get_by_id($id);
        foreach ($data as $key => &$value) {
            $value = $this->render_element_view($key, $value);
        }
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $CI = &get_instance();
        $this->_validate();
        $data = array();
        foreach ($CI->input->post() as $k => $v) {
            if ($k != 'typeIn') {
                $data[$k] = $v;
            }
            if ($v == "") {
                $data[$k] = null; //for select db if not selected any value returned null that not errored in db
            }
        }
        $insert = $this->save($data);
        if ($insert && isset($this->add_action["model"])) {
            $CI->load->model($this->add_action["model"], "tmp_add_model");
            $CI->tmp_add_model->{$this->add_action["function"]}();
        }

        echo json_encode(array("status" => $insert));
    }
    public function ajax_filter()
    {
        $CI = &get_instance();
        $data = array();
        // foreach ($CI->input->post() as $k => $v)
        // {if ($k!='typeIn') { $data[$k]=$v;
        // }
        // if($v=="") { $data[$k]=null;//for select db if not selected any value returned null that not errored in db
        // }
        // }
        // $insert =  $this->save($data);
        // if($insert && isset($this->add_action["model"])) {
        //     $CI->load->model($this->add_action["model"], "tmp_add_model");
        //     $CI->tmp_add_model->{$this->add_action["function"]}();
        // }

        echo json_encode(array("status" => true));
    }

    public function ajax_update()
    {
        $CI = &get_instance();
        $this->_validate();
        $data = array();
        foreach ($CI->input->post() as $k => $v) {
            if ($k != 'typeIn') {
                $data[$k] = $v;
            }
        }
        $upd = $this->update(array('id' => $CI->input->post('id')), $data);
        if (isset($this->edit_action["model"])) {
            $CI->load->model($this->edit_action["model"], "tmp_edit_model");
            $CI->tmp_edit_model->{$this->edit_action["function"]}($CI->input->post('id'));
        }
        echo json_encode(array("status" => $upd));
    }

    public function ajax_delete()
    {
        $CI = &get_instance();
        $id = $CI->input->post("id", true);
        if (isset($this->delete_action["model"])) {
            $CI->load->model($this->delete_action["model"], "tmp_delete_model");
            $CI->tmp_delete_model->{$this->delete_action["function"]}($id);
        }

        $this->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_delete_group()
    {
        $CI = &get_instance();
        $values = array();
        $id = $CI->input->post("id", true);
        parse_str($id, $values);

        $tmp = array_keys($values["select"]);

        if (isset($this->delete_action["model"])) {
            foreach ($tmp as $key) {
                $CI->load->model($this->delete_action["model"], "tmp_delete_model");
                $CI->tmp_delete_model->{$this->delete_action["function"]}($key);
            }
        }
        $this->delete_group_by_id($tmp);
        echo json_encode(array("status" => true));
    }

    //------------------------------controller end
    //------------------------------view start

    private function load_header()
    {
        // echo "<h2 class='page-header'> {$this->title}  </h2>";
    }

    private function load_action()
    {
         ?>
        <title> <?php echo $this->title ?> </title>
        <div class="btn-group" style="padding: 5px;">
            <?php if (isset($this->permission["add"]) && $this->permission["add"]) : ?>

                <button class="btn btn-success" onclick="_add_()"><i class="fa fa-plus"></i> <?php echo _ADD ?> </button>
            <?php endif; ?>
            <?php if ($this->column_filter) : ?>
                <button class="btn btn-default" onclick="_filter_()"><i class="fa fa-filter"></i> <?php echo _FILTER ?> </button>
            <?php endif; ?>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> <?php echo _REFRESH ?> </button>
            <button class="btn btn-info" id="select-btn"><i class="fa fa-check"></i> <?php echo _SELECT ?> </button>

            <?php if (isset($this->permission["delete"]) && $this->permission["delete"]) : ?>
                <button class="btn btn-warning" id="delete_group" onclick="_delete_group()"><i class="fa fa-close"></i> <?php echo _DELETE ?> </button>
            <?php endif; ?>
            <?php if (0) : ?>
                <button class="btn btn-info" id="copy_group" onclick="_copy_group()"><i class="fa fa-copy"></i> <?php echo _COPY ?> </button>
            <?php endif; ?>
        </div>
        <div class="btn-group" style="padding: 5px;">
            <?php echo $this->actions ?>
        </div>
    <?php
    }

    private function load_table()
    {
    ?>
        <table id="<?php echo $this->tableId ?>" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="select"> <input type="checkbox" id="globalCheckbox"> </th>
                    <th><i class="fa fa-sort-numeric-asc "></i> </th>
                    <?php foreach ($this->column_title as $k) : if ($this->checkList($k, 'title')) : ?>
                            <th><?php echo $k ?></th>
                    <?php endif;
                    endforeach; ?>
                    <?php if (@$this->permission["edit"] || @$this->permission["delete"]) : ?>
                        <th><?php echo _OP ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th class="select"> </th>
                    <th><i class="fa fa-sort-numeric-asc "></i> </th>
                    <?php foreach ($this->column_title as $k) : if ($this->checkList($k, 'title')) : ?>
                            <th><?php echo $k ?></th>
                    <?php endif;
                    endforeach; ?>
                    <?php if (@$this->permission["edit"] || @$this->permission["delete"]) : ?>
                        <th><?php echo _OP ?>
                        </th>
                    <?php endif; ?>
                </tr>
            </tfoot>
        </table>
    <?php
    }

    private function load_modal()
    {
    ?>

        <!-- Bootstrap modal  add -->
        <div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title"><?php echo $this->title ?></h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="id" />
                            <div class="form-body">
                                <?php for ($i = 0; $i < count($this->column_order); $i++) : ?>
                                    <?php if ($this->column_require[$i] != 2 && $this->column_require[$i] != 3) : ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $this->column_title[$i] ?></label>
                                            <div class=" col-md-9">
                                                <?php echo $this->render_element($i) ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <?php $this->render_form_add() ?>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><?php echo _SAVE ?></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _CANCEL ?></button>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal add -->

        <!-- ======================================================================== -->
        <!-- Bootstrap modal filter -->
        <div class="modal fade" id="modal_form_filter" role="dialog" data-backdrop="static">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title"><?php echo $this->title ?></h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="formFilter" class="form-horizontal">
                            <input type="hidden" value="" name="id" />
                            <div class="form-body">
                                <?php for ($i = 0; $i < count($this->column_filter); $i++) : ?>
                                    <?php if ($this->column_filter[$i]) : ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $this->column_title[$i] ?></label>
                                            <div class=" col-md-9">
                                                <?php echo $this->render_element_filter($i) ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnFilter" onclick="doFilter()" class="btn btn-primary"><?php echo _FILTER ?></button>
                        <button type="button" onclick="clearFilter()" class="btn btn-primary"><?php echo _CLEAR_FILTER ?></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _CANCEL ?></button>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal filter-->
        <!-- ======================================================================== -->
        <!-- Bootstrap modal view -->
        <div class="modal fade" id="modal_form_view" role="dialog" data-backdrop="static">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title"><?php echo $this->title ?></h3>
                    </div>
                    <div class="modal-body">
                        <table class=" table table-hover table-striped">
                            <?php for ($i = 0; $i < count($this->column_filter); $i++) : ?>
                                <tr>
                                    <td><?php echo $this->column_title[$i] ?></td>
                                    <td><b>
                                            <p id='v__<?= $this->column_order[$i] ?>'> </p>
                                        </b></td>
                                </tr>
                            <?php endfor; ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _CLOSE2 ?></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal filter-->

    <?php
    }

    private function load_datatable($url)
    {
    ?>
        <script type="text/javascript">
            var table;
            var _selected = [];
            $(document).ready(function() {
                //datatables
                table = $('#<?php echo $this->tableId ?>').DataTable({
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.
                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo $url ?>",
                        "type": "POST",
                        "data": function(data) {
                            data.typeIn = 'json';
                            <?= ($this->where) ? "data.where = '$this->where' ;" : null; ?>
                            <?php // for detect filtering to send
                            $i = 0;
                            foreach ($this->column_order as $k) {
                                if ($this->column_type[$i] == "date" || $this->column_type[$i] == "number") {
                                    $tmp = "from__" . $k;
                                    echo " data.$tmp = $('#$tmp').val();";
                                    $tmp = "to__" . $k;
                                    echo " data.$tmp = $('#$tmp').val();";
                                } else {
                                    $tmp = "f__" . $k;
                                    echo " data.$tmp = $('#$tmp').val();";
                                }
                                $i++;
                            } ?>

                        }
                    },
                    "rowCallback": function(row, data) {
                        if ($.inArray(data.DT_RowId, _selected) !== -1) {
                            $(row).addClass('selected');

                        }
                    },
                    //Set column definition initialisation properties.
                    "columnDefs": [{
                        "targets": [0], //first column / numbering column
                        "orderable": false, //set not orderable
                    }, ],
                    stateSave: true,
                    scrollY: '50vh',
                    scrollX: true,
                    scrollCollapse: true,
                    fixedColumns: true,
                    "lengthMenu": [
                        [10, 25, 50, 100, 200, 500, -1],
                        [10, 25, 50, 100, 200, 500, "<?php echo _ALL ?>"]
                    ],
                    dom: 'Blfrtip',
                    buttons: [{
                            extend: 'colvis',
                            text: '<i class="fa fa-table" ></i>  <?php echo _VIEW . __ . _COLUMNS ?> '
                        },
                        {
                            extend: 'copy',
                            text: '<i class="fa fa-copy" > </i> <?php echo _COPY ?> '
                        },
                        {
                            extend: 'csv',
                            "filename": "<?php echo $this->title . rand(0, 100) ?>",
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
                            customize: function(win) {
                                $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                                $(win.document.body).find('tr:nth-child(odd) td').each(function(index) {
                                    $(this).css('background-color', '#D0D0D0');
                                });
                                $(win.document.body).find('h1').html("<?php echo $this->title ?>");
                                $(win.document.body).find('h1').css("text-align", "center");
                                $(win.document.body).find('h1').css("font-size", "18px");
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
                        "processing": "<div class='loading' > </div>",
                        "oPaginate": {
                            "sFirst": "<?php echo _FIRST ?> <i class='fa fa-fast-fa-backward '> </i>",
                            "sPrevious": "<?php echo _PREVIOUS ?> <i class='fa fa-chevron-left  '> </i>",
                            "sNext": "<i class='fa fa-chevron-right '> </i> <?php echo _NEXT ?> ",
                            "sLast": "<i class='fa fa-fast-forward '> </i> <?php echo _LAST ?> "
                        }
                    }
                });
                //                ------------------------for select start
                //select all check box
                $('#globalCheckbox').click(function() {
                    if ($(this).prop("checked")) {
                        $(".checkBox").prop("checked", true);
                    } else {
                        $(".checkBox").prop("checked", false);
                    }
                });



                var column = table.column(0);
                $("#delete_group").hide();
                $("#copy_group").hide();
                column.visible(false);
                $('#select-btn').on('click', function(e) {
                    e.preventDefault();

                    if (column.visible()) {
                        $("#delete_group").hide();
                        $("#copy_group").hide();
                        column.visible(false);
                        $('#select-btn').attr("class", "btn btn-info");
                    } else {
                        $("#delete_group").show();
                        $("#copy_group").show();
                        column.visible(true);
                        $('#select-btn').attr("class", "btn btn-default");
                    }
                });
                //                ------------------------for select end
                $('#<?php echo $this->tableId ?> tbody').on('click', 'tr', function() {
                    var id = this.id;
                    var index = $.inArray(id, _selected);
                    if (index === -1) {
                        _selected.push(id);
                    } else {
                        _selected.splice(index, 1);
                    }

                    $(this).toggleClass('selected');
                });

                //set input/textarea/select event when change value, remove class error and remove text help block
                $("input").change(function() {
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("textarea").change(function() {
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("select").change(function() {
                    $(this).parent().parent().removeClass('has-error');
                    //                    $(this).next().empty();
                });
            });

            function _add_() {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                $('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('<?php echo _ADD ?>'); // Set Title to Bootstrap modal title
            }

            function _filter_() {
                save_method = 'filter';
                $('#modal_form_filter').modal('show'); // show bootstrap modal
                $('.modal-title_filter').text('<?php echo _FILTER ?>'); // Set Title to Bootstrap modal title
            }

            function _edit_(id) {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string

                //Ajax Load data from ajax
                $.ajax({
                    url: "<?php echo $url ?>",
                    type: "POST",
                    dataType: "JSON",
                    "data": {
                        'typeIn': 'edit',
                        'id': id
                    },
                    success: function(data) {
                        $('[name="id"]').val(data.id);

                        <?php foreach ($this->column_order as $k) : ?>
                            $('[name="<?php echo $k ?>"]').val(data.<?php echo $k ?>);
                        <?php endforeach; ?>
                        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('<?php echo _EDIT ?>'); // Set title to Bootstrap modal title
                        $('select').trigger('change');


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        piero_alert("<?php echo _ERROR ?>", "<?php echo _ERROR_AJAX ?>");
                    }
                });


            }

            function _copy_(id) {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string

                //Ajax Load data from ajax
                $.ajax({
                    url: "<?php echo $url ?>",
                    type: "POST",
                    dataType: "JSON",
                    "data": {
                        'typeIn': 'edit',
                        'id': id
                    },
                    success: function(data) {
                        $('[name="id"]').val(0);

                        <?php foreach ($this->column_order as $k) : ?>
                            $('[name="<?php echo $k ?>"]').val(data.<?php echo $k ?>);
                        <?php endforeach; ?>
                        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('<?php echo _COPY ?>'); // Set title to Bootstrap modal title
                        $('select').trigger('change');


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        piero_alert("<?php echo _ERROR ?>", "<?php echo _ERROR_AJAX ?>");
                    }
                });


            }

            function _view_(id) {
                save_method = 'view';

                //Ajax Load data from ajax
                $.ajax({
                    url: "<?php echo $url ?>",
                    type: "POST",
                    dataType: "JSON",
                    "data": {
                        'typeIn': 'view',
                        'id': id
                    },
                    success: function(data) {
                        $('[name="id"]').val(0);

                        <?php foreach ($this->column_order as $k) : ?>
                            $('[id="v__<?php echo $k ?>"]').text(data.<?php echo $k ?>);
                        <?php endforeach; ?>
                        $('#modal_form_view').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('<?php echo _VIEW ?>'); // Set title to Bootstrap modal title
                        $('select').trigger('change');


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        piero_alert("<?php echo _ERROR ?>", "<?php echo _ERROR_AJAX ?>");
                    }
                });


            }

            function reload_table() {
                table.ajax.reload(null, false); //reload datatable ajax
            }

            $('input').keypress(function(e) {
                if (e.which == 13) {
                    save();
                    return false;
                }
            });

            function save() {

                $('#btnSave').text('<?php echo _SAVE2 ?>...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable
                var _dt;
                var _tmp_serialize;
                if (save_method == 'add') {
                    _dt = "add";
                } else {
                    _dt = "update";
                }
                _tmp_serialize = $('#form').serialize() + "&typeIn=" + _dt;
                // ajax adding data to database
                $.ajax({
                    url: "<?php echo $url ?>",
                    type: "POST",
                    data: _tmp_serialize,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) //if success close modal and reload ajax table
                        {
                            $('#modal_form').modal('hide');
                            reload_table();
                        } else {
                            for (var i = 0; i < data.inputerror.length; i++) {
                                $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                //                                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string

                            }
                            piero_alert('<?php echo _ERROR ?>', data.error_string)
                        }
                        $('#btnSave').text("<?php echo _SAVE2 ?>"); //change button text
                        $('#btnSave').attr('disabled', false); //set button enable


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        piero_alert("<?php echo _ERROR ?>", "<?php echo _ERROR_UPDATE ?>");
                        $('#btnSave').text('<?php echo _SAVE2 ?>...'); //change button text
                        $('#btnSave').attr('disabled', false); //set button enable

                    }
                });
            }

            function doFilter() {
                table.ajax.reload(null, false); //reload datatable ajax
                $('#modal_form_filter').modal('hide');

            }

            function clearFilter() {
                $("#formFilter")[0].reset();
                table.ajax.reload(null, false); //reload datatable ajax
                $('#modal_form_filter').modal('hide');

            }

            function _delete_group() {
                var _sel = $('input[class="checkBox"]:checked').serialize();
                if (_sel) {
                    (new PNotify({
                        title: '<?php echo _MESSAGE ?>',
                        text: '<?php echo _ASK_DELETE ?>',
                        icon: 'fa fa-close fa-5x ',
                        hide: false,
                        confirm: {
                            confirm: true,
                            buttons: [{
                                    text: '<?php echo _YES ?>',
                                    addClass: 'btn-primary',
                                    click: function(notice) {
                                        // ajax delete data to database
                                        $.ajax({
                                            url: "<?php echo $url ?>",
                                            type: "POST",
                                            dataType: "JSON",
                                            data: {
                                                "typeIn": "delete_group",
                                                "id": _sel
                                            },
                                            success: function(data) {
                                                piero_message();
                                                reload_table();
                                                notice.remove();
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                piero_alert("<?php echo _ERROR ?>", "<?php echo _ERROR_DELETE ?>");
                                            }
                                        });

                                    }
                                },
                                {
                                    text: '<?php echo _CANCEL ?>',
                                    addClass: 'btn',
                                    click: function(notice) {
                                        notice.remove();
                                    }

                                }
                            ]
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
                    }));
                } else {
                    piero_alert("<?php echo _ERROR ?>", "<?php echo _NO_SELECTED ?>");
                }
            }

            function _delete_(id) {
                (new PNotify({
                    title: '<?php echo _MESSAGE ?>',
                    text: '<?php echo _ASK_DELETE ?>',
                    icon: 'fa fa-close fa-5x ',
                    hide: false,
                    confirm: {
                        confirm: true,
                        buttons: [{
                                text: '<?php echo _YES ?>',
                                addClass: 'btn-primary',
                                click: function(notice) {
                                    // ajax delete data to database
                                    $.ajax({
                                        url: "<?php echo $url ?>",
                                        type: "POST",
                                        dataType: "JSON",
                                        data: {
                                            "typeIn": "delete",
                                            "id": id
                                        },
                                        success: function(data) {
                                            piero_message();
                                            reload_table();
                                            notice.remove();
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            piero_alert("<?php echo _ERROR ?>", "<?php echo _ERROR_DELETE ?>");
                                        }
                                    });

                                }
                            },
                            {
                                text: '<?php echo _CANCEL ?>',
                                addClass: 'btn',
                                click: function(notice) {
                                    notice.remove();
                                }

                            }
                        ]
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
                }));

            }
        </script>
        <?php
    }

    //------------------------------view end
    //------------------------------render start
    public function checkList($key, $mode = 'order')
    {
        if (empty($this->column_list)) {
            return true;
        }

        if ($mode == "title") {
            $i = array_search($key, $this->column_title);
            if (in_array($this->column_order[$i], $this->column_list)) {
                return true;
            } else {
                return false;
            }
        } else {
            if (in_array($key, $this->column_list)) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function render_url($def = null)
    {
        $CI = &get_instance();
        $def = ($def) ? $def : $CI->router->method;
        return site_url($CI->router->directory . $CI->router->class . '/' . $def);
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
        return $output;
    }

    public function render_form_add()
    {
        $CI = &get_instance();
        $CI->load->helper("form");
        if (isset($this->form_add)) {
            foreach ($this->form_add as $key => $value) {
                echo form_hidden($key, $value);
            }
        }
    }
    //out for ajax out in datatable
    public function render_ajax_list()
    {
        $CI = &get_instance();
        $list = $this->list_ajax();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $k) {
            $no++;
            $row = array();

            $row[] = '<input type="checkbox" class="checkBox" name="select[' . $k->id . ']">';
            $row[] = $no;

            $c = 0;
            foreach ($this->column_order as $key) {
                if (!$this->checkList($key)) {
                    $c++;
                    continue;
                }
                switch ($this->column_type[$c]) {
                    case ("number"):
                        $row[] = price($k->$key, false);
                        break;
                    case ("bool"):
                        //                    $row[] = ($k->$key)?_TRUE:_FALSE;
                        $row[] = ($k->$key) ? _TRUE : _FALSE;
                        break;
                    case ("boolYN"):
                        //                    $row[] = ($k->$key)?_TRUE:_FALSE;
                        $row[] = ($k->$key) ? _YES : _NO;
                        break;
                    case ("input"):
                        $row[] = $k->$key;
                        break;
                    case ("text"):
                        $row[] = $k->$key;
                        break;
                    case ("client"):
                        $row[] = $CI->system->get_user_from_id($k->$key);
                        break;
                    case ("date"):
                        $CI->load->library('Piero_jdate');
                        $row[] = ($k->$key) ? $CI->piero_jdate->jdate("Y/m/d", strtotime($k->$key)) : null;
                        //  $row[] =$k->$key;

                        break;

                    case ("json"):
                        $CI->load->library('Piero_jdate');
                        $row[] = $CI->piero_jdate->jdate("Y/m/d", json_decode($k->$key)->datecheck);
                        break;
                    default:
                        //mavared pichide keniaz ba tarkib json darad
                        if (strpos($this->column_type[$c], "array")) {
                            $tmp_array = (array) json_decode($this->column_type[$c]);
                            $tmp = (array) $tmp_array[1];
                            $row[] = $tmp[$k->$key];
                        } else if (strpos($this->column_type[$c], "select_db")) {
                            if ($k->$key) {
                                $tmp_array = json_decode($this->column_type[$c]);
                                $row[] = @$CI->db->select($tmp_array[2])->from($tmp_array[1])->where("id", $k->$key)->get()->result_array()[0][$tmp_array[2]];
                            } else {
                                $row[] = $k->$key;
                            }
                        } else {
                            $row[] = $k->$key;
                        }
                }
                $c++;
            }
            $tmp = '<div class="btn-group">';
            $tmp .= (isset($this->permission["view"]) && $this->permission["view"]) ? '<a class="btn  btn-default" href="javascript:void(0)"   data-toggle="tooltip" title=' . _VIEW . '   onclick="_view_(' . "'" . $k->id . "'" . ')"><i class="fa fa-eye"></i> </a>' : null;
            $tmp .= (isset($this->permission["copy"]) && $this->permission["copy"]) ? '<a class="btn  btn-warning" href="javascript:void(0)"   data-toggle="tooltip" title=' . _COPY . '   onclick="_copy_(' . "'" . $k->id . "'" . ')"><i class="fa fa-copy"></i> </a>' : null;
            $tmp .= (isset($this->permission["edit"]) && $this->permission["edit"]) ? '<a class="btn btn-primary" href="javascript:void(0)"   data-toggle="tooltip" title=' . _EDIT . '   onclick="_edit_(' . "'" . $k->id . "'" . ')"><i class="fa fa-edit"></i> </a>' : null;
            $tmp .= (isset($this->permission["delete"]) && $this->permission["delete"]) ? '<a class="btn  btn-danger" href="javascript:void(0)" data-toggle="tooltip" title=' . _DELETE . ' onclick="_delete_(' . "'" . $k->id . "'" . ')"><i class="fa fa-close"></i> </a>' : null;
            $tmp .= (str_replace("[[id]]", $k->id, $this->actions_row));
            $tmp .= "</div>";
            $row[] = $tmp;
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
    public function render($view = "Dtbl_List")
    {
        $CI = &get_instance();
        //make select
        $this->select = $this->column_order;
        $this->select[] = "{$this->table}.id";

        //delete un usable char from select
        foreach ($this->column_order as $key => &$value) {
            $value = str_replace(array('(', ')', '+', '-', '*', '\r', '\n', ' ', '.'), '_', $value);
            $this->select[$key] .= " AS $value";
        }

        //render default permission
        $this->permission["copy"] = isset($this->permission["copy"]) && $this->permission["copy"] ?? $this->permission["add"];
        $this->permission["view"] = isset($this->permission["view"]) && $this->permission["view"] ?? !empty($this->column_list);

        $this->tableId = "taBle" . rand(0, 1000);
        if ($CI->input->post("where", true)) {
            $this->where = $CI->input->post("where", true);
        }
        switch ($CI->input->post("typeIn", true)) {
            case "json":
                $this->render_ajax_list();
                break;
            case "edit":
                $this->ajax_edit();
                break;
            case "view":
                $this->ajax_view();
                break;
            case "update":
                $this->ajax_update();
                break;
            case "add":
                $this->ajax_add();
                break;
            case "filter":
                $this->ajax_filter();
                break;
            case "delete":
                $this->ajax_delete();
                break;
            case "delete_group":
                $this->ajax_delete_group();
                break;
            default:
                $CI->template->load($view, array("out" => $this->render_view()), array("title" => $this->title));
        }
    }

    //render element for edit adn add
    private function render_element($i)
    {
        $CI = &get_instance();
        $CI->load->helper('form');
        switch ($this->column_type[$i]) {
            case "input": ?>
                <input name="<?php echo $this->column_order[$i] ?>" placeholder="<?php echo $this->column_title[$i] ?>" class="form-control" type="text">
            <?php break;
            case "text": ?>
                <textarea name="<?php echo $this->column_order[$i] ?>" placeholder="<?php echo $this->column_title[$i] ?>" class="form-control"> </textarea>
            <?php break;
            case "email": ?>
                <input name="<?php echo $this->column_order[$i] ?>" placeholder="<?php echo $this->column_title[$i] ?>" class="form-control" type="email">
            <?php break;
            case "number": ?>
                <input name="<?php echo $this->column_order[$i] ?>" class="form-control" type="number">
                <?php break;
            case "bool":
                echo form_dropdown($this->column_order[$i], array(1 => _TRUE, 0 => _FALSE));
                break;
            case "boolYN":
                echo form_dropdown($this->column_order[$i], array(1 => _YES, 0 => _NO));
                break;
            case ("hide"):

                $row[] = null;
                break;
            case "date":
                echo $CI->element->input_date($this->column_order[$i], "form-control");
                break;
            default:
                if (strpos($this->column_type[$i], "array")) {
                    $tmp_array = json_decode($this->column_type[$i]);
                    echo form_dropdown($this->column_order[$i], (array) $tmp_array[1]);
                } else if (strpos($this->column_type[$i], "select_db")) {
                    $tmp_array = json_decode($this->column_type[$i]);
                    echo @form_dropdown($this->column_order[$i], $CI->element->pselect($tmp_array[1], ($tmp_array[2]) ? $tmp_array[2] : null, ($tmp_array[3]) ? $tmp_array[3] : null, _DEF_ELEMENT, ($tmp_array[4]) ? $tmp_array[4] : null, ($tmp_array[5]) ? $tmp_array[5] : null, null, 0), ["id" => $this->column_order[$i]]);
                } else {
                ?>
                    <input name="<?php echo $this->column_order[$i] ?>" placeholder="<?php echo $this->column_title[$i] ?>" class="form-control" type="text">
                <?php
                }
        }
    }
    //render element for filter
    private function render_element_filter($i)
    {
        $CI = &get_instance();
        $CI->load->helper('form');
        switch ($this->column_type[$i]) {
            case "input": ?>
                <input id="f__<?php echo $this->column_order[$i] ?>" name="f__<?php echo $this->column_order[$i] ?>" placeholder="<?php echo $this->column_title[$i] ?>" class="form-control" type="text">
            <?php break;
            case "text": ?>
                <textarea id="f__<?php echo $this->column_order[$i] ?>" name="f__<?php echo $this->column_order[$i] ?>" placeholder="<?php echo $this->column_title[$i] ?>" class="form-control"></textarea>
            <?php break;
            case "email": ?>
                <input id="f__<?php echo $this->column_order[$i] ?>" name="f__<?php echo $this->column_order[$i] ?>" placeholder="<?php echo $this->column_title[$i] ?>" class="form-control" type="email">
            <?php break;
            case "number": ?>
                <input id="from__<?php echo $this->column_order[$i] ?>" name="from__<?php echo $this->column_order[$i] ?>" placeholder="<?= _FROM ?>" class="form-control" type="number">
                <input id="to__<?php echo $this->column_order[$i] ?>" name="to__<?php echo $this->column_order[$i] ?>" placeholder="<?= _TO ?>" class="form-control" type="number">
<?php break;
            case "bool":
                echo form_dropdown("f__" . $this->column_order[$i], array(0 => _FALSE, 1 => _TRUE), null, ['id' => "f__" . $this->column_order[$i]]);
                break;
            case "boolYN":
                echo form_dropdown("f__" . $this->column_order[$i], array(0 => _NO, 1 => _YES), null, ['id' => "f__" . $this->column_order[$i]]);
                break;
            case ("hide"):
                $row[] = null;
                break;
            case "date":
                echo $CI->element->input_date("from__" . $this->column_order[$i], "form-control", null, "00");
                echo $CI->element->input_date("to__" . $this->column_order[$i], "form-control", null, "00");
                break;
            default:
                if (strpos($this->column_type[$i], "array")) {
                    $tmp_array = json_decode($this->column_type[$i]);
                    echo form_multiselect("f__" . $this->column_order[$i], (array) $tmp_array[1], null, ["id" => "f__" . $this->column_order[$i]]);
                } else if (strpos($this->column_type[$i], "select_db")) {
                    $tmp_array = json_decode($this->column_type[$i]);
                    echo @form_dropdown("f__" . $this->column_order[$i], $CI->element->pselect($tmp_array[1], ($tmp_array[2]) ? $tmp_array[2] : null, ($tmp_array[3]) ? $tmp_array[3] : null, _DEF_ELEMENT, ($tmp_array[4]) ? $tmp_array[4] : null, ($tmp_array[5]) ? $tmp_array[5] : null, null, 0), null, ["id" => "f__" . $this->column_order[$i]]);
                } else {

                    //notthing fo null
                }
        }
    }

    public function render_element_view($key, $value)
    {
        $CI = get_instance();
        $i = array_search($key, $this->column_order);
        $type = $this->column_type[$i];
        if ($type == "date") {
            $CI->load->library('Piero_jdate');
            return $CI->piero_jdate->jdate("Y/m/d", strtotime($value));
        } elseif (strpos($type, "array")) {
            $tmp_array = (array) json_decode($this->column_type[$i]);
            $tmp = (array) $tmp_array[1];
            return ($tmp[$value]) ? $tmp[$value] : '';
        } elseif (strpos($type, "select_db")) {
            $tmp_array = json_decode($this->column_type[$i]);
            $tmp = @$CI->db->select($tmp_array[2])->from($tmp_array[1])->where("id", $value)->get()->result_array()[0][$tmp_array[2]];
            return ($tmp) ? $tmp : '';
        } else {
            return $value;
        }
    }
    //---------------------------------------------------------------------oth statr
    //generate array for crud permison
    public function render_permsion_crud($per)
    {
        $CI = get_instance();
        return array("add" => ($CI->permission->check($per . "_add")) ? 1 : 0, "edit" => ($CI->permission->check($per . "_edit")) ? 1 : 0, "delete" => ($CI->permission->check($per . "_delete")) ? 1 : 0);
    }

    //---------------------------------------------------------------------oth end
}
