<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Prd extends CI_Controller
{
    //edit prd
    public function edit()
    {
        $this->permision->check("prd_edit", 0, 1);
        $this->load->model('MaLi/Prd_model');
        $ret = $this->Prd_model->edit_prd($this->input->post("id", true));
        $this->template->load_popup('MaLi/prds/add_p_prd', _EDIT_FULLL . __ . _PRD, array("detail_prd" => $ret));
    }
    public function pedit($id=null)
    {
        $this->permision->check("prd_edit", 0, 1);
        $id = $this->input->post("id", true);
        $this->permision->check("user_edit", 0, 1);
        $this->load->model('MaLi/Prd_model');
        $this->system->json_out($this->Prd_model->add_prd($id));
    }
    //manage
    public function manage($parent_id = null)
    {
        //        load for data table
        $this->load->library("Crud");
        $this->crud->table = "prd";
        $this->crud->title = _MANAGE . __ . _PRD;
        $this->crud->column_order = array("id", "state", "name", "group_id", "out_stack_alert", "price1", "vahed_asli", "order_by", "row_plus");
        $this->crud->column_list = array("id", "state", "name", "group_id", "out_stack_alert", "price1");
        $this->crud->column_title = array(_ID, _STATE, _NAME, _GROUP, _OUT_STACK_ALERT, _PRICE, _VAHED_ASLI, _ORDER_BY, _FACTOR_ROW_PLUS_);
        $this->crud->column_require = array(2, 1, 1, 0, 0, 0, 0, 0,0, 0, 0);
        $this->crud->column_filter = array(1, 1, 1, 1, 0, 0, 1, 0,0, 0, 0);
        $tmp_selectdb = array("select_db", "prd_group", "name");
        $tmp_selectdbvahed = array("select_db", "mali_prd_unit", "name");
        $this->crud->column_type = array("hide", "bool", "input", json_encode($tmp_selectdb), "number", "input", json_encode($tmp_selectdbvahed), "number", "number", "number", "input");
        $this->crud->column_search = array("name", "row_plus");
        $this->crud->permision = $this->crud->render_permsion_crud("prd");
        if ($this->crud->permision["edit"]) {
            $tmp_url = site_url("MaLi/pprd/prd/edit/");
            $this->crud->actions_row = "<a class='btn btn-default' data-toggle='tooltip' title='" . _EDIT_FULLL . "' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-edit' ></i> </a>";
        }
        if ($this->permision->check("media_manage")) {
            $tmp_url = site_url("Media/manage/0/prd");
            $this->crud->actions_row .= "<a class='btn btn-default' data-toggle='tooltip' title='" . _UPLOAD_MANAGER . "' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-upload' ></i> </a>";
        }
        $this->crud->actions = "<a class='btn btn-info' href='" . site_url("MaLi/pprd/prd/manage_group") . "' > <i class='fa fa-user-md' ></i>" . _MANAGE_PRD_GROUP . ' </a>';
        // $this->crud->actions .= "<a class='btn btn-info' href='" . site_url("MaLi/pprd/prd/manage_unit") . "' > <i class='fa fa-user-md' ></i>" . _MANAGE . __ . _VAHED . _S . ' </a>';
        // $this->crud->actions_row= "<a class='btn btn-default' data-toggle='tooltip' title='{_EDIT_FULLL}' href='".site_url("MaLi/pprd/prd/edit/[[id]]")."' > <i class='fa fa-edit' ></i> </a>";;
        $this->crud->render();
    }

    //prd group -------------------------------------------
    // list of manage
    public function manage_group()
    {
        //load for data table
        $this->load->library("Crud");
        $this->crud->table = "prd_group";
        $this->crud->title = _MANAGE_PRD_GROUP;
        $this->crud->column_order = array("name", "state", "des", "parent");
        $this->crud->column_title = array(_NAME, _STATE, _DES, _VALED);
        $this->crud->column_require = array(1, 1, 1, 0);
        $tmp_selectdb = array("select_db", "prd_group", "name");
        $this->crud->column_type = array("input", "bool", "input", json_encode($tmp_selectdb));
        $this->crud->column_search = array("name", "des");
        $tmp_url = site_url("MaLi/pprd/prd/manage/" . '[[id]]');
        $this->crud->actions_row = "<a class='btn btn-default'  data-toggle='tooltip' title='{_PRD._S}'  onclick=load_ajax_popupfull('$tmp_url','id=[[id]]')> <i class='fa fa-lock' ></i> </a>";
        $this->crud->actions = "<a class='btn btn-info  ' href='" . site_url("MaLi/pprd/prd/manage") . "' > <i class='fa fa-user-md' ></i>" . _MANAGE . __ . _PRD . _S . ' </a>';
        $this->crud->render();
    }

    //prd group -------------------------------------------end
    //
    /// //prd unit -------------------------------------------
    // list of manage
    public function manage_unit()
    {
        //load for data table
        $this->load->library("Crud");
        $this->crud->table = "mali_prd_unit";
        $this->crud->title = _VAHED;
        $this->crud->column_order = array("name");
        $this->crud->column_title = array(_NAME);
        $this->crud->column_require = array(1);
        $this->crud->column_type = array("input");
        $this->crud->column_search = array("name");
        $this->crud->actions = "<a class='btn btn-info  ' href='" . site_url("MaLi/pprd/prd/manage") . "' > <i class='fa fa-user-md' ></i>" . _MANAGE . __ . _PRD . _S . ' </a>';
        $this->crud->render();
    }

    //prd group -------------------------------------------end
}
