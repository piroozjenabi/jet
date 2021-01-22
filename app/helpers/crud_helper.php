<?php defined('BASEPATH') OR exit('No direct script access allowed');

//get url and render url for load ajax data table
//if no url return sam controller with list_ajax method
function render_url($def=null)
{
    $CI=&get_instance();
    $def=($def)?$def:"list_ajax";
    return  $CI->router->directory.$CI->router->class.'/'.$def;
}

//db=database table
//$header= colomns
//$type=type of columns
function crud_load($db,$header,$body,$type=null,$ajax_url=null)
{
    $CI=&get_instance();
    ?>
<!--    --><?//= current_url()."/index/true";?><!--"-->
    <table class="table table-hover table-striped dataTbl" >
        <thead>
        <tr>
            <td ># </td>
        <?php foreach ($header as $key => $value): ?>
        <td> <?php echo $value?></td>
        <?php endforeach; ?>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($body as $key => $value):?>
            <tr>
                <?php foreach ($value as $k => $v ) : ?>
                    <td>
                    <?php switch ($k) {
                    case "id":
                        echo $v;
                        break;
                    case "main":
                        echo $CI->element->edit_select_bool($value["id"], $v, "karkoshte_job", $k, "text");
                        break;
                    case "parent":
                        echo $CI->element->edit_select_db($value["id"], $v, "karkoshte_job_group", $k, "text", array("db"=>"karkoshte_job_group"));
                        break;
                    default:
                        echo $CI->element->edit_text($value["id"], $v, $db, $k, "text");
                        break;
}?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}

function crud_load2($db,$header,$body,$type=null,$ajax_url=null)
{
    $ajax_url=site_url(render_url($ajax_url));

?>
    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Person </button>
    <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload </button>

    <table id="table1" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>id</th>
            <th>serial</th>
            <th>name</th>
            <th>name-en</th>
            <th>des</th>
            <th>parent</th>
            <th style="width:125px;">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>

        <tfoot>
        <tr>
            <th>#</th>
            <th>id</th>
            <th>serial</th>
            <th>name</th>
            <th>name-en</th>
            <th>des</th>
            <th>parent</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>



    <script type="text/javascript">

        var table;

        $(document).ready(function() {

            //datatables
            table = $('#table1').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo $ajax_url?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [ 0 ], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ], stateSave: true,
                scrollY:'50vh',

                "lengthMenu": [[10, 25, 50,100,200,500, -1], [10, 25, 50, 100 , 200 , 500 ,"<?php echo _ALL ?>"]],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-table" ></i>  <?php echo _VIEW.__._COLUMNS ?> '
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-copy" > </i> <?php echo _COPY ?> '
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-excel-o" ></i> EXCEL/CSV'
                    },
//                    'pdfFlash',
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o" ></i> PDF ',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        },
                        header: true,
                        title: 'My Table Title',
                        orientation: 'landscape',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 16; //<-- set fontsize to 16 instead of 10
                        }
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
                            $(win.document.body).find('h1').html("صورتحساب مشتریان");
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
                $(this).next().empty();
            });


        });


        function add_person()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
        }

        function edit_person(id)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('Karkoshte/job/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    $('[name="id"]').val(data.id);
                    $('[name="name"]').val(data.name);
                    $('[name="serial_id"]').val(data.serial_id);
                    $('[name="des"]').val(data.des);
                    $('[name="name_en"]').val(data.name_en);
                    $('[name="parent"]').val(data.parent);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }

        function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax
        }

        function save()
        {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable
            var url;

            if(save_method == 'add') {
                url = "<?php echo site_url('Karkoshte/job/ajax_add')?>";
            } else {
                url = "<?php echo site_url('Karkoshte/job/ajax_update')?>";
            }

            // ajax adding data to database
            $.ajax({
                url : url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {

                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    }
                    else
                    {
                        for (var i = 0; i < data.inputerror.length; i++)
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable

                }
            });
        }

        function delete_person(id)
        {
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('Karkoshte/job/ajax_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });

            }
        }

    </script>


    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Person Form</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="id"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">name</label>
                                <div class="col-md-9">
                                    <input name="name" placeholder="name" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">name_en</label>
                                <div class="col-md-9">
                                    <input name="name_en" placeholder="name en" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">serial id</label>
                                <div class="col-md-9">
                                    <input name="serial_id" placeholder="serial_id" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">des</label>
                                <div class="col-md-9">
                                    <textarea name="des" placeholder="des" class="form-control"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">parent</label>
                                <div class="col-md-9">
                                    <input name="parent" placeholder="parent" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
    <?php
}


// render body of table
//return from db
function crud_list($db,$select="*",$where=null)
{
    $CI=&get_instance();
    $CI->db->select($select)
        ->from($db);
    if($where) {   $CI->db->where($where);
    }
    return $CI->db->get()->result_array();
}
