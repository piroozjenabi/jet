<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class  Stock_out extends CI_Controller
{

        //manage list
    public function manage()
    {

        $this->load->helper("form");
        $user_id = $this->system->get_user();
        $this->permision->check("stock_out", 0, 1);
        //load for data table
        $this->load->library("Crud");
        $this->crud->table = "stock_out";
        $this->crud->title = _MANAGE_STOCK_OUT;
        $this->crud->column_order = array("stock_id", "prd_id","user_reciver_id", "num", "des", "date");
        $this->crud->column_title = array(_STOCK, _PRD, _RECIVER,_NUM, _DES, _DATE);
        $this->crud->column_require = array(1, 1, 1, 1, 1, 1);
        $this->crud->column_type = array(json_encode(array("select_db", "stock", "name")), json_encode(array("select_db", "prd", "name")), json_encode(array("select_db", "user", "name")), "number", "input", "date");
        $this->crud->form_add = ["user_id"=>$user_id];
        $this->crud->add_action=array("model"=>"Stock/Stock_out_model","function"=>"stack_out_alert");
        $this->crud->edit_action=array("model"=>"Stock/Stock_out_model","function"=>"stack_out_alert");
        $this->crud->column_search = array( "num","des");
        $tmp_url = site_url("Stock/Stock");
        $this->crud->actions = "<a class='btn btn-info  '  href='$tmp_url' > <i class='fa fa-database' ></i>" . _MANAGE_MOJOODI . " </a>";;
        $this->crud->render();


    }
        //for render recepie in factor
    function render_recipe()
    {
        $this->permision->check("stock_recipe", 0, 1);
        $id=$this->input->post("id", true);
        $this->load->model('MaLi/Factor_sell_model');
        $ret=$this->Factor_sell_model->edit_factor($id);
        $this->template->load_popup("Stock/recipe", _REJECT_FORM, array("detail_factor" => $ret,"factor_id" => $id));
    }
    function prender_recipe()
    {
        //        $this->permision->check("stock_recipe",0,1);
        //        $this->load->model('Stock/Stock_out_model');
        //        if($this->Stock_out_model->recipe())
        //            $this->system->message(_FACTOR_ADDED);
        //        redirect("MaLi/factor_sell/manage_factor/level/4");
    }


}
