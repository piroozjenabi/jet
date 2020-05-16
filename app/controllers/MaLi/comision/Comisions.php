<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Comisions extends CI_Controller
{

    function index()
    {
        $this->load->model('MaLi/Factor_sell_model');
        $this->load->model('MaLi/Comission_model');
        $this->load->model("CRM/My_employ_model");
        $this->load->library("Factor");

        $user_id=$this->system->get_user();
        //get list of month
        $arr_month=$this->system->curent_months();
        $res=$this->My_employ_model->my_client_list($user_id);

        $out=array();
        foreach ($arr_month as $k => $v)
        {
            $tot_com=0;$tot_num=0;$tot_sell=0;
            foreach ($res as $key => &$value)
            {
                $k=(!$k)?-1:$k;
                //            $value["commission_thismonth"]=$this->Comission_model->get_user_commission($value["id"],$this->system->get_setting("main_factor_level"),$k)-$this->Comission_model->get_user_commission($value["id"],$this->system->get_setting("deafult_reject_factor_level"),$k);
                $value["commission_thismonth"]=$this->Comission_model->get_user_commission($value["id"], $this->system->get_setting("main_factor_level"), $k);
                $tot_com+=$value["commission_thismonth"];

                $value["totsell"]=$this->factor->user_sell_mounth($value["id"], $k);
                $tot_sell+=$value["totsell"];

            }
            $out[$k]["res"]=$res;
            $out[$k]["month_name"]=$v;
            $out[$k]["tot_com"]=$tot_com;
            $out[$k]["tot_sell"]=$tot_sell;
        }
        $this->template->load("MaLi/comision/comision_view", array("res" => $out));

    }





}
?>
