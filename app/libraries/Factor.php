<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Factor
{
    public function render_level($factor_id, $level_id = 0)
    {
        $CI = &get_instance();
        $level_id = ($level_id)?$level_id : $CI->system->get_setting("deafult_factor_level");
        $level_pro = $this->get_level($level_id);
        if ($level_pro["alert_usergroups_make"]) {
            $def_users_make = $CI->system->get_users_from_usergroup(json_decode($level_pro["alert_usergroups_make"]));
        }

        if ($level_pro["alert_usergroup_expire"]) {
            $def_users_expire = $CI->system->get_users_from_usergroup(json_decode($level_pro["alert_usergroup_expire"]));
        }

        $factor_pro = $CI->db->get_where("factor", "id=$factor_id")->result_array()[0];
        $mes = $CI->system->get_user_from_id($factor_pro["user_id"]) . " | " . $CI->system->get_user_from_id($factor_pro["user_id"], "tell") . " " . $CI->system->get_user_from_id($factor_pro["user_id"], "mobile") . " " . $CI->system->get_user_from_id($factor_pro["user_id"], "address") . " | " . _NUM . __ . _CARTON . " : " . $this->num_carton_factor($factor_id);
        $data = array();
        //render
        //        set factor number
        $data["level_id"] = $level_id;
        // alert system to make
        if ($level_pro["alert_self_make"]) {
            $CI->alerts_lib->add_alert(3, array("id" => $factor_id), $factor_pro["date"], $mes, array(0 => array("id" => $factor_pro["maker_id"])));

        }
        if ($level_pro["alert_usergroups_make"]) {

            $CI->alerts_lib->add_alert(3, array("id" => $factor_id), $factor_pro["date"], $mes, $def_users_make);
        }
        //        alert system to expire
        if ($level_pro["alert_self_expire"]) {
            if ($factor_pro["expire_date"] < $factor_pro["date"]) {
                $CI->alerts_lib->add_alert(1, array("id" => $factor_id), $factor_pro["expire_date"], $mes, array(0 => array("id" => $factor_pro["maker_id"])));
            }
        }
        if ($level_pro["alert_usergroup_expire"]) {
            if ($factor_pro["expire_date"] < $factor_pro["date"]) {
                $CI->alerts_lib->add_alert(1, array("id" => $factor_id), $factor_pro["expire_date"], $mes, $def_users_expire);
            }
        }
        //stock in
        if ($level_pro["stock_in"]) {
            $CI->load->model('Stock/Stock_in_model');
            $CI->stock_in_model->stock_in_factor($factor_id);
        }
        //stock out
        if ($level_pro["stock_out"]) {
            $CI->load->model('Stock/Stock_out_model');
            $CI->stock_out_model->stock_out_factor($factor_id);
        }

        $CI->db->where("id", $factor_id);
        $CI->db->update('factor', $data);

    }
    //        get list level
    public function get_level_list($type = "", $select = "*")
    {
        $CI = &get_instance();
        $CI->db->select($select);
        if ($type == "bed_bes") {
            $CI->db->where("bed", 1);
            $CI->db->or_where("bes", 1);
        }
        $CI->db->from("factor_level");
        return $CI->db->get()->result_array();
    }

    // get level info
    public function get_level($level_id)
    {
        $CI = &get_instance();
        return $CI->db->get_where("factor_level", "id=$level_id")->row_array();
    }

    // get factor_preview info
    public function get_factor_preview($id)
    {
        $CI = &get_instance();
        return $CI->db->get_where("factor_preview", "id=$id")->row_array();
    }

    //get level from factor id
    public function get_level_info_from_factor_id($factor_id)
    {
        $CI = &get_instance();
        $level_id = $CI->db->get_where("factor", "id=$factor_id")->row()->level_id;
        return $this->get_level($level_id);
    }

    //max buy client system
    public function get_factor_renge_date($start, $end = 0, $maker_id = 0)
    {
        $CI = &get_instance();
        $main_factor_level = $CI->system->get_setting("main_factor_levels", 1, true);

        $maker_id = ($maker_id) ? $maker_id : $CI->system->get_user();
        $CI->db->select('id');
        $CI->db->from('factor');
        $CI->db->where('maker_id', $maker_id);
        $CI->db->group_start();
        foreach ($main_factor_level as $key) {
            $CI->db->or_where('level_id', $key);
        }
        $CI->db->group_end();

        $CI->db->where('date >', $start);
        if ($end) {
            $CI->db->where('date <', $end);
        }
        return $CI->db->get()->result_array();

    }

    //return user factor renge
    public function get_user_factor_renge_date($start = 0, $end = 0)
    {
        $CI = &get_instance();
        $main_factor_level = $CI->system->get_setting("main_factor_levels", 1, true);
        $CI->db->select('user_id');
        $CI->db->from('factor');
        $CI->db->group_start();
        foreach ($main_factor_level as $key) {
            $CI->db->or_where('level_id', $key);
        }
        $CI->db->group_end();
        if ($start) {
            $CI->db->where('date >', $start);
        }
        if ($end) {
            $CI->db->where('date <', $end);
        }
        return $CI->db->get()->result_array();

    }

    //render pay limit for eemployer -- form limit module
    public function render_limit_pay($user_id = 0)
    {
        $CI = &get_instance();
        $CI->load->model('MaLi/Factor_sell_model');
        $user_id = ($user_id) ? $user_id : $CI->system->get_user();
        $ret = $this->get_factor_renge_date($CI->system->get_current_month_timetamp("start"), $CI->system->get_current_month_timetamp("end"), $user_id);
        $tot = 0;
        foreach ($ret as $key => $value) {
            $tot += $CI->Factor_sell_model->show_total_price($value["id"]);
        }

        return $tot;

    }

    //get sell user for month -- seled eemploy from this mounth
    public function user_sell_mounth($user_id, $month = 0)
    {
        $CI = &get_instance();
        $month = ($month == -1) ? 0 : $month;
        $ret = $this->get_factor_renge_date($CI->system->get_current_month_timetamp("start", $month), $CI->system->get_current_month_timetamp("end", $month), $user_id);
        $tot = 0;
        foreach ($ret as $key => $value) {
            $tot += $CI->Factor_sell_model->show_total_price($value["id"]);
        }
        return $tot;
    }

    //get money geted from factor
    public function geted_money_factor($factor_id)
    {
        $CI = &get_instance();
        $CI->db->select_sum('price');
        $CI->db->from('pay');
        $CI->db->where('factor_id', $factor_id);
        return $CI->db->get()->result_array()[0]["price"];

    }

   

    //price of factor
    public function price($id_factor)
    {
        $bes = $this->get_level_info_from_factor_id($id_factor)["bes"];
        $CI = &get_instance();
        $CI->db->select("price ,num ,takhfif  ");
        $CI->db->where("id_factor", $id_factor);
        $res_factor = $CI->db->get("factor_prd")->result_array();

        $total_factor = 0;
        foreach ($res_factor as $key => $value) {
            $total_factor += ($value['price'] * $value['num']) - $value['takhfif'];

        }

        //for ezafat
        $CI->db->select("price");
        $CI->db->where('id_factor', $id_factor);
        $res_ezafat = $CI->db->get("factor_ezafat")->result_array();
        $total_ezafat = 0;
        foreach ($res_ezafat as $key => $value) {
            $total_ezafat += $value['price'];
        }

        //for kosoorat
        $CI->db->select("price");
        $CI->db->where('id_factor', $id_factor);
        $res_kosoorat = $CI->db->get("factor_kosoorat")->result_array();
        $total_kosoorat = 0;
        foreach ($res_kosoorat as $key => $value) {
            $total_kosoorat += $value['price'];
        }

        $main_total = $total_factor + $total_ezafat - $total_kosoorat;
        $main_total = ($bes) ? $main_total * -1 : $main_total;
        return $main_total;

    }

    //get list of factor from user id
    public function get_list_factor_from_user($user_id, $level = 0)
    {
        $CI = &get_instance();
        $level = ($level) ? $level : $CI->system->get_setting("main_factor_level");
        $CI->db->select('*');
        $CI->db->from('factor');
        $CI->db->where('user_id', $user_id);
        if ($level) {$CI->db->where('level_id', $level);
        }
        return $CI->db->get()->result_array();

    }

    // return db from id
    public function get($id)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->from('factor');
        $CI->db->where('id', $id);
        return $CI->db->get()->result_array();
    }

}
