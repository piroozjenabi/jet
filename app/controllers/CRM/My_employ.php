<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class My_employ extends CI_Controller
{

    function index($type=null)
    {
        $this->load->model('MaLi/Factor_sell_model');
        $this->load->model('MaLi/Comission_model');
        $this->load->library("Factor");
        $user_id=$this->system->get_user();
        $this->load->model("CRM/My_employ_model");
        $res=$this->My_employ_model->my_client_list($user_id);
        foreach ($res as $key => &$value)
        {

            $value["commission"]=$this->Comission_model->get_user_commission($value["id"], $this->system->get_setting("main_factor_level"), true)-$this->Comission_model->get_user_commission($value["id"], $this->system->get_setting("deafult_reject_factor_level"), true);
            $value["factor_total"]=$this->Factor_sell_model->get_user_totalprice($value["id"]);
            $value["last_date"]=$this->Factor_sell_model->get_user_totalprice($value["id"], 1, "date");
            $value["sell_price"]=$this->factor->render_limit_pay($value["id"]);
            $value["total_pay"]=$this->Factor_sell_model->get_user_totalpay($value["id"]);

        }
        loadV("CRM/my_employ/main", array("res" => $res,"type"=>$type));

    }
}
