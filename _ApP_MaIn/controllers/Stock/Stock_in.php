<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class  Stock_in extends CI_Controller
{

    public function manage()
    {
        $this->load->helper("form");
        $user_id=$this->system->get_user();
        $this->permision->check("stock_check", 0, 1);
        //load for data table
        $this->load->library("Crud");
        $this->crud->table="stock_in";
        $this->crud->title=_MANAGE_STOCK_IN;
        $this->crud->column_order=array("stock_id","prd_id","num","des","date","pro_forma","lot");
        $this->crud->column_title=array(_STOCK,_PRD,_NUM,_DES,_DATE,_PRO_FORMA,_LOT);
        $this->crud->column_require=array(1,1,1,1,1,0,0,0);
        $this->crud->column_type=array(json_encode(array("select_db","stock","name")),json_encode(array("select_db","prd","name")),"number","input","date","input","input");
        $this->crud->form_add=["user_id"=>$user_id];
        $this->crud->column_search=array("num","des","pro_forma","lot");
        $tmp_url=site_url("Stock/Stock");
        $this->crud->actions = "<a class='btn btn-info  '  href='$tmp_url' > <i class='fa fa-database' ></i>"._MANAGE_MOJOODI." </a>";;
        $this->crud->render();

    }






}
