<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * library for manage alets
 */
class Alerts_lib
{
    public function type_list()
    {
        $CI = &get_instance();
        $CI->db->select("*");
        $CI->db->from("alerts_type");
        return $CI->db->get()->result_array();
    }

    //return list
    public function menu_list($type_id)
    {
        $CI = &get_instance();
        $id_user = $CI->system->get_user();
        $CI->db->select("*");
        $CI->db->from("alerts");
        $CI->db->where("user_id", $id_user);
        //        $CI->db->where("readed", 0);
        if ($type_id >= 0) {
            $CI->db->where("type_id", $type_id);
        }
        $CI->db->where("date < ",jetDate());
        $CI->db->order_by("date", "desc");
        return $CI->db->get()->result_array();

    }

    //add alert
    public function add_alert($type, $params, $date, $message = "", $users)
    {
        $CI = &get_instance();
        $type_params = $CI->db->get_where("alerts_type", "id=$type")->result_array()[0];
        $date = ($type_params["delay"]) ? strtotime('+' . $type_params["delay"] . ' hours', $date) : $date;
        $date = jetDate($date);
        $message = ($message) ? $message : $type_params["def_message"];
        $data = array("message" => $message, "date" => $date, "type_id" => $type, "params" => json_encode($params));
        foreach ($users as $key => $value) {
            $data["user_id"] = $value["id"];
            $CI->db->insert("alerts", $data);
        }

        return true;
    }
    //list of allert type
    public function return_alert_type($id, $param = "name")
    {
        $CI = &get_instance();
        return $CI->db->get_where("alerts_type", array("id" => $id))->result_array()[0][$param];
    }
    //count of alerts
    public function count_alert($type = 0, $id_user = 0)
    {
        $CI = &get_instance();
        $id_user = ($id_user == 0) ? $CI->system->get_user() : $id_user;
        $arr = ($type != 0) ? array("user_id" => $id_user, "type_id" => $type, "readed" => 0, "date <" => time()) : array("user_id" => $id_user, "readed" => 0, "date < " => time());
        return count($CI->db->get_where("alerts", $arr)->result_array());

    }

    //chenged to readed
    public function read_alert($id)
    {
        $CI = &get_instance();
        $CI->db->where('id', $id);
        return $CI->db->update('alerts', array("readed" => "1"));
    }

    //delete alert
    public function delete_alert($id)
    {
        $CI = &get_instance();
        $CI->db->where('id', $id);
        return $CI->db->delete('alerts');
    }

    //render for list
    public function render($list)
    {
        $res = array();
        $c = 1;

        foreach ($list as $key => $value) {
            $res[$c]["id"] = $value["id"];
            $res[$c]["date"] = $value["date"];
            $res[$c]["readed"] = $value["readed"];
            $res[$c]["params"] = json_decode($value["params"]);
            $message = "";
            $message = $this->return_alert_type($value["type_id"], "def_message");
            if ($value["message"]) {
                $message .= " | " . $value["message"];
            }
            $res[$c]["message"] = $message;
            //actions
            $fnc = @($this->return_alert_type($value["type_id"], "function")) ? $this->return_alert_type($value["type_id"], "function") : "def";
            $res[$c]["actions"] = $this->$fnc(json_decode($value["params"]));

            $res[$c]["color"] = $this->return_alert_type($value["type_id"], "color");

            $c++;
        }
        return $res;
    }

    #############################################################################################################################
    ###################################### [  TYPE OF ALERT ]####################################################################
    #############################################################################################################################
    // functions for out put alerts
    public function expire_factor($params)
    {
        $show_link = site_url("MaLi/factor_sell/manage_factor/view_details");
        $id_factor = $params->id;
        $res = "<td><a class='btn btn-primary' target='_blank' onclick=load_ajax_popup('$show_link','id=$id_factor')> <i class='fa fa-eye' ></i>" . _VIEW_FACTOR . "</a><a class='btn btn-info' target='_blank' href='" . site_url("/MaLi/factor_preview/Factor_sell_pre/index/" . $params->id) . "'> <i class='fa fa-file-pdf-o' ></i>" . _PRINT . __ . _FACTOR . "</a></td>";
        return $res;
    }

    //show period traching
    public function period_tracking($params)
    {
        $res = "<td><a class='btn btn-info' target='_blank' href='" . site_url("/CRM/my_client/tracks/" . $params->id) . "'> <i class='fa fa-eye' ></i>" . _VIEW . _CLIENT . "</a></td>";
        return $res;
    }

    //defualt 
    public function def($params)
    {
        return null;
    }

    //new factor alert
    public function alert_new_factor($params)
    {
        $show_link = site_url("MaLi/factor_sell/manage_factor/view_details");
        $id_factor = $params->id;
        $res = "<td><a class='btn btn-primary' target='_blank' onclick=load_ajax_popup('$show_link','id=$id_factor')> <i class='fa fa-eye' ></i>" . _VIEW_FACTOR . "</a><a class='btn btn-info' target='_blank' href='" . site_url("/MaLi/factor_preview/Factor_sell_pre/index/" . $params->id) . "'> <i class='fa fa-file-pdf-o' ></i>" . _PRINT . __ . _FACTOR . "</a></td>";
        return $res;
    }

    // refer refer form 
    public function refer($params)
    {
        $show_link = site_url("AUTO/Manage/show_form");
        $res = "<td><a class='btn btn-default' onclick=load_ajax_popup('$show_link','id=$params->id')>" . _VIEW . "</a><a class='btn btn-default' href='" . site_url("/AUTO/kartable") . "'>" . _VIEW . __ . _KARTABL . "</a></td>";
        return $res;
    }

    // reject forms
    public function reject($params)
    {
        $show_link = site_url("AUTO/Manage/show_form");
        $res = "<td><a class='btn btn-default' onclick=load_ajax_popup('$show_link','id=$params->id')>" . _VIEW . "</a><a class='btn btn-default' href='" . site_url("/AUTO/refer") . "'>" . _VIEW . __ . _KARTABL . __ . _REJECTED . _S . "</a></td>";
        return $res;
    }

    public function checku($params)
    {
        return "";
    }

}
