<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Stock extends  CI_Controller
{

    //    list of remains stock
    public function index()
    {
        $this->load->library("Stock_lib");
        $list_prd=$this->system->list_prd("id,name");
        $this->load->model('Stock/Stock_in_model');
        $this->load->model('Stock/Stock_out_model');
        $this->load->model('Stock/Stock_model');
        $fill=array();
        $c=0;
        $d=0;

        if($this->system->get_setting("disolay_stock_by_stock")) {
            $list_stock = $this->Stock_model->stock_list();

            foreach ($list_stock as $k => $v) {
                foreach ($list_prd as $key => $value) {
                    if($v['id'] && $this->stock_lib->supply($value->id, "supply", $v["id"])) {
                        $fill[$v['name']."-".$v['des']][$c]["id"] = $value->id;
                        $fill[$v['name']."-".$v['des']][$c]["name"] = $value->name;
                        $fill[$v['name']."-".$v['des']][$c]["stock_in"] = $this->stock_lib->supply($value->id, "in", $v["id"]);
                        $fill[$v['name']."-".$v['des']][$c]["stock_out"] = $this->stock_lib->supply($value->id, "out", $v["id"]);
                        $fill[$v['name']."-".$v['des']][$c]["remind"] = $this->stock_lib->supply($value->id, "supply", $v["id"]);
                        $fill[$v['name']."-".$v['des']][$c]["stock_check"] = $this->stock_lib->supply($value->id, "last_stock_check", $v["id"]);
                        $fill[$v['name']."-".$v['des']][$c]["num_out_after_stock_check"] = $this->stock_lib->supply($value->id, "num_out_after_stock_check", $v["id"]);
                        $fill[$v['name']."-".$v['des']][$c]["real_supply"] = $this->stock_lib->supply($value->id, "real", $v["id"]);

                        $c++;
                    }

                }
            }

        }
        else
         {
            foreach ($list_prd as $key => $value) {
                $fill[$c]["id"] = $value->id;
                $fill[$c]["name"] = $value->name;
                $fill[$c]["stock_in"] = $this->stock_lib->supply($value->id, "in");
                $fill[$c]["stock_out"] = $this->stock_lib->supply($value->id, "out");
                $fill[$c]["remind"] = $this->stock_lib->supply($value->id, "supply");
                $fill[$c]["stock_check"] = $this->stock_lib->supply($value->id, "last_stock_check");
                $fill[$c]["num_out_after_stock_check"] = $this->stock_lib->supply($value->id, "num_out_after_stock_check");
                $fill[$c]["real_supply"] = $this->stock_lib->supply($value->id);

                $c++;
            }
        }
            $this->template->load("Stock/stock", array("db" => $fill));
    }

        //for reset stock
    public function reset_stock()
    {
        $this->load->model('Stock/Stock_in_model');
        $this->load->model('Stock/Stock_out_model');
        $this->load->library('Factor');

        if($this->permision->is_admin()) {
            $res_factor=$this->db->get_where("factor_level")->result_array();
            //                print_r($res_factor);
            foreach ($res_factor as $key => $value)
            {
                //                    stock_in
                if($value["stock_in"]) {
                    $this->Stock_in_model->stock_in_level($value["id"]);
                }//                    stock_out
                if($value["stock_out"]) {
                    $this->Stock_out_model->stock_out_level($value["id"]);
                }
            }
        }
    }
            //stock check list
    public function stock_check()
    {
        $this->load->helper("form");
        $user_id=$this->system->get_user();
        $this->permision->check("stock_check", 0, 1);
        //load for data table
        $this->load->library("Crud");
        $this->crud->table="stock_check";
        $this->crud->title=_STOCK_CHECK;
        $this->crud->column_order=array("stock_id","prd_id","num","des","date");
        $this->crud->column_title=array(_STOCK,_PRD,_NUM,_DES,_DATE);
        $this->crud->column_require=array(1,1,1,1,1,0);
        $this->crud->column_type=array(json_encode(array("select_db","stock","name")),json_encode(array("select_db","prd","name")),"number","input","date");
        $this->crud->form_add=["user_id"=>$user_id];
        $this->crud->column_search=array("num","des");
        $tmp_url=site_url("Stock/Stock");
        $this->crud->actions = "<a class='btn btn-info  '  href='$tmp_url' > <i class='fa fa-database' ></i>"._MANAGE_MOJOODI." </a>";;
        $this->crud->render();
    }

    //manage stock define parent and all stock
    function manage()
    {
        $this->permision->check("stock_manage", 0, 1);
        //load for data table
        $this->load->library("Crud");
        $this->crud->table="stock";
        $this->crud->title=_MANAGE_STOCK;
        $this->crud->column_order=array("name","def","des","parent");
        $this->crud->column_title=array(_NAME,_DEFULT,_DES,_VALED);
        $this->crud->column_require=array(1,1,0,0);
        $tmp_selectdb=array("select_db","stock","name");
        $this->crud->column_type=array("input","bool","input",json_encode($tmp_selectdb));
        $this->crud->column_search=array("name","des");
        $tmp_url=site_url("Stock/Stock");
        $this->crud->actions = "<a class='btn btn-info  '  href='$tmp_url' > <i class='fa fa-database' ></i>"._MANAGE_MOJOODI." </a>";;
        $this->crud->render();

    }

    //load transfer popup
    function transfer()
    {
        $this->template->load_popup("Stock/transfer", _TRANSFER.__._STOCK);
    }
    function ptransfer()
    {
        $this->load->model('Stock/Stock_in_model');
        $this->load->model('Stock/Stock_out_model');
        $date=strtotime($this->input->post("date", true));
        $this->Stock_in_model->stock_in($this->input->post("prd_dest", true), $this->input->post("num", true), $date, 0, $this->input->post("des", true), array("type"=>"transfer","prd_source"=>$this->input->post("prd_source", true)), $this->input->post("stock_dest", true), $this->input->post("lot", true), $this->input->post("proforma", true));
        $this->Stock_out_model->stock_out($this->input->post("prd_source", true), $this->input->post("num", true), $date, 0, $this->input->post("des", true), array("type"=>"transfer","prd_source"=>$this->input->post("prd_dest", true)), $this->input->post("stock_source", true));
        $this->system->message(_SUC_OP);
        redirect("Stock/Stock");
    }


    //kardex
    function kardex()
    {
        $this->load->library("Crud");
        $this->crud->table="stock_in";
        $this->crud->column_order=array("prd_id","num","date","des");
        $this->crud->column_title=array(_PRD,_NUM,_DATE,_DES);
        $this->crud->column_type=array("input","input","input","input");
        $this->crud->column_require=array(1,1,1,1);
        $this->crud->column_search=array("name","des");
        $this->crud->render("karkoshte/job_list");
    }
}
