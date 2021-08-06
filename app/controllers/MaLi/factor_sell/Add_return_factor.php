<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

class add_return_factor extends CI_Controller
{

    function add_return($id)
    {
        $this->load->model('MaLi/Factor_sell_model');
        $ret=$this->Factor_sell_model->edit_factor($id);
        //        time
        $this->load->library('Piero_jdate');
        $def_time=printDate("Y/m/d", $ret[0]["date"]);
        $def_time_expire=printDate("Y/m/d", $ret[0]["date"]);
        //convert persian number to english
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        $ret[0]["date"]= str_replace($persian, $num, $def_time);
        $ret[0]["expire_date"]= str_replace($persian, $num, $def_time_expire);


        loadV('MaLi/factor_sell/add_main', array("detail_factor" => $ret));
    }
    public function padd($id="")
    {
        $this->load->model('MaLi/Factor_sell_model');
        $main_factor_id=$this->Factor_sell_model->add_factor_sell($id);
        if ($main_factor_id) {
            $this->system->message(_FACTOR . _ADDED);
            // add alerts expire
            if($this->system->get_setting("enable_alert_expire_factor")) {
                // alert add new factor
                $client_id = post("user", true);
                $mes=$this->system->get_user_from_id($client_id)." | ".$this->system->get_user_from_id($client_id, "tell")." ".$this->system->get_user_from_id($client_id, "mobile");
                $def_users=$this->system->get_users_from_usergroup(json_decode($this->system->get_setting("new_factor_alerts_users_group")));
                $this->alerts_lib->add_alert(3, array("id"=>$main_factor_id), time(), $mes, $def_users);

                if (post("factor_date", true) != post("expire_factor", true)) {
                    //alert expire time
                    $def_users=$this->system->get_users_from_usergroup(json_decode($this->system->get_setting("expire_alerts_users_group")));
                    $this->alerts_lib->add_alert(1, array("id"=>$main_factor_id), strtotime(post("expire_factor", true)), $mes, $def_users);

                }
            }
        }
        else {
            $this->system->message(_NOT_ADDED);
        }

        redirect("MaLi/factor_sell/manage_factor");
    }
}
