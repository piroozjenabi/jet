<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Manage extends CI_Controller
{

    public function index()
    {
        //load for data table
        $this->load->library("Crud");
        $this->crud->table = "auto_forms";
        $this->crud->title = _MANAGE . _FORM . _S;
        $this->crud->column_order = array("enable", "name", "name_en", "des", "tree_id");
        $this->crud->column_title = array(_STATE, _NAME, _NAME . __ . "[EN]", _DES, _TREE);
        $this->crud->column_require = array(1, 1, 1, 1, 1);
        $tmp_selectdb = array("select_db", "auto_forms_tree", "name");
        $this->crud->column_type = array("bool", "input", "input", "input", json_encode($tmp_selectdb));
        $this->crud->column_search = array("name", "name_en", "des");
        $this->crud->permision = $this->crud->render_permsion_crud("auto_form");
        $tmp_url = site_url("/AUTO/manage_form/manage/manage_fields/" . '[[id]]');
        $this->crud->actions_row = "<a class='btn btn-default' data-toggle='tooltip' title='{_FIELD._S}' target='_blank' href='$tmp_url' > <i class='fa fa-lock' ></i> </a>" .
            '<a onclick="piero_confirm(del_cr_forms,[[id]])" data-toggle="tooltip" title="{_DELETE_CREATE_TABLES}" class=" btn btn-warning"  > <i class="fa fa-refresh "></i> </a> <hr>';
        $this->crud->actions = '<a href="' . site_url("/AUTO/manage_form/manage/Manage_tree") . '" class=" btn btn-primary" > <i class="fa fa-sitemap "></i> ' . _MANAGE_FORM_TREES . ' </a> ' .
        '<a href="' . site_url("/AUTO/manage_form/manage/Manage_field_data") . '" class=" btn btn-primary" > <i class="fa fa-list "></i> ' . _MANAGE_FIELD_DATA . ' </a> ' .
        '<a href="' . site_url("/AUTO/manage_form/manage/manage_auto_refer") . '" class=" btn btn-success" > <i class="fa fa-list "></i> ' . _MANAGE_AUTO_AUTO_REFER_USER . ' </a> ';

        $this->crud->add_action = array("model" => "AUTO/Auto_forge_model", "function" => "add_form");
        $this->crud->delete_action = array("model" => "AUTO/Auto_forge_model", "function" => "delete_form");
        $this->crud->edit_action = array("model" => "AUTO/Auto_forge_model", "function" => "edit_form");
        $this->crud->render("AUTO/manage_form/manage");
    }

    //manage tree ------------------------------------- start

    public function manage_tree()
    {
        //load for data table
        $this->load->library("Crud");
        $this->crud->table = "auto_forms_tree";
        $this->crud->title = _MANAGE_FORM_TREES;
        $this->crud->column_order = array("name", "des", "parent_id");
        $this->crud->column_title = array(_NAME, _DES, _VALED);
        $this->crud->column_require = array(1, 1, 0);
        $tmp_selectdb = array("select_db", "auto_forms_tree", "name");
        $this->crud->column_type = array("input", "input", json_encode($tmp_selectdb));
        $this->crud->column_search = array("name", "des");
        $this->crud->actions = '<a href="' . site_url("/AUTO/manage_form/manage/") . '" class=" btn btn-primary" > <i class="fa fa-sitemap "></i> ' . _MANAGE . _FORM . _S . ' </a> ' .
        '<a href="' . site_url("/AUTO/manage_form/manage/Manage_field_data") . '" class=" btn btn-primary" > <i class="fa fa-list "></i> ' . _MANAGE . __ . _FIELD_DATA . ' </a> <hr>';
        $this->crud->render();
    }

    //manage tree ------------------------------------- end
    //
    //   //manage field data ------------------------------------- start

    public function manage_field_data()
    {
        //load for data table
        $this->load->library("Crud");
        $this->crud->table = "auto_forms_field_data_group";
        $this->crud->title = _MANAGE_FIELD_DATA;
        $this->crud->column_order = array("parent", "name");
        $this->crud->column_title = array(_VALED, _NAME);
        $this->crud->column_require = array(0, 1);
        $tmp_selectdb = array("select_db", "auto_forms_field_data_group", "name");
        $this->crud->column_type = array(json_encode($tmp_selectdb), "input");
        $this->crud->column_search = array("name");
        $this->crud->actions = '<a href="' . site_url("/AUTO/manage_form/manage/") . '" class=" btn btn-primary" > <i class="fa fa-sitemap "></i> ' . _MANAGE . _FORM . _S . ' </a> ';
        $get_link = site_url("AUTO/manage_form/Manage/add_field_data");
        $this->crud->actions_row = "<a class=' btn btn-info ' data-toggle='tooltip' title='{_LIST.__._FIELD_DATA}' onclick=load_ajax_popup('$get_link','group_id=[[id]]')> <i class='fa fa-list' ></i> </a>";
        $this->crud->render();
    }

    //---------------------------popup windows for add field data
    public function add_field_data()
    {
        $this->load->library("auto");
        $group = post("group_id", true);
        $data = array('db' => $this->auto->list_field_data($group), "id" => $group);
        $this->template->load_popup('AUTO/manage_form/add_field_data', _LIST . __ . _FIELD_DATA, $data);
    }
    //add tree submit
    public function padd_field_data($id)
    {
        $this->load->model("AUTO/add_form_model");

        if ($this->add_form_model->add_field_group($id)) {
            $this->system->message(_FORM . _ADDED);
        }
        redirect("/AUTO/manage_form/manage/Manage_field_data");
    }

    //manage field data ------------------------------------- end

    //add users too database
    public function manage_fields($id = null)
    {
        //load for data table
        $this->load->library("Crud");
        $this->load->library("auto");
        $this->crud->table = "auto_forms_fields";
        $this->crud->title = _MANAGE . _FIELD . _S;
        $this->crud->column_order = array("order_by", "form_id", "type", "name", "des", "show_list", "parent_class", "class", "style", "required", "min", "max", "params");
        $this->crud->column_title = array(_ORDER_BY, _FORM, _TYPE, _NAME . __ . "[EN]", _NAME, _SHOW_LIST, _CSS_CLASS_PARENT, _CSS_CLASS, _CSS_STYLE, _REQUIRED, _MIN, _MAX, _ADVANCED_SETTING);
        $this->crud->column_require = array(1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0);
        $tmp_selectdb = array("select_db", "auto_forms", "name");
        $tmp_select_array = array("array", $this->auto->elements);

        $this->crud->column_type = array("number", json_encode($tmp_selectdb), json_encode($tmp_select_array), "input", "input", "bool", "input", "input", "input", "bool", "input", "input", "input", "input");
        $this->crud->column_search = array("name", "des");
        if ($id) {
            $this->crud->where = "form_id=" . $id;
        }
        $this->crud->order = array("order_by" => "َASC");

        $this->crud->add_action = array("model" => "AUTO/Auto_forge_model", "function" => "add_field");
        $this->crud->delete_action = array("model" => "AUTO/Auto_forge_model", "function" => "delete_field");
        $this->crud->edit_action = array("model" => "AUTO/Auto_forge_model", "function" => "edit_field");

        $this->crud->render();
    }

    //create delete table  all froms -- refesh all table
    //for refresh forms
    //

    public function del_cr_forms()
    {
        $this->permission->check("auto_manage_form", 0, 1);
        $id = post("id", true);
        $this->load->model("AUTO/Auto_forge_model");
        if ($this->Auto_forge_model->del_cr_forms($id)) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }

    //   //manage auto refer ------------------------------------- start

    public function manage_auto_refer()
    {
        //load for data table
        $this->load->library("Crud");
        $this->crud->table = "auto_auto_refer_user";
        $this->crud->title = _MANAGE_AUTO_AUTO_REFER_USER;
        $this->crud->column_order = array("state", "user_id", "form_id", "des");
        $this->crud->column_title = array(_STATE, _USER, _FORM, _DES);
        $this->crud->column_require = array(0, 1, 1, 0);
        $tmp_selectdb = array("select_db", "auto_forms", "name");
        $tmp_selectdb2 = array("select_db", "user_admin", "name");
        $this->crud->column_type = array("bool", json_encode($tmp_selectdb2), json_encode($tmp_selectdb), "input");
        $this->crud->column_search = array("des");
        $this->crud->actions = '<a href="' . site_url("/AUTO/manage_form/manage/") . '" class=" btn btn-primary" > <i class="fa fa-sitemap "></i> ' . _MANAGE . _FORM . _S . ' </a> ';
        $this->crud->render();
    }

}
