<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Factor_sell_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function add_factor_sell($id = "")
    {
        $data = array();
        $data["user_id"] = $this->input->post("user", true);
        $data["date"] = strtotime($this->input->post("factor_date", true));
        if (!$id) {
            $data["maker_id"] = $this->system->get_user();
        }
        $data["expire_date"] = $this->input->post("expire_factor", true);
        $data["level_id"] = $this->input->post("level_id", true);
        $data["expire_date"] = strtotime($data["expire_date"]);
        $data["des"] = $this->input->post("des", true);
        if (!$id) {
            if (!$this->db->insert('factor', $data)) {
                return false;
            }

            $main_factor_id = $this->db->insert_id();
        } else {
            $this->db->where("id", $id);
            $main_factor = $this->db->update('factor', $data);
            $main_factor_id = $id;
        }
        //add to data base factor_prd
        $data2["id"] = "";

        //add product to factor
        if ($id) {
            $this->db->where("id_factor", $id);
            $this->db->delete("factor_prd");
        }

        for ($i = 1; $i <= count($this->input->post("price", true)); $i++) {
            $data2["radif"] = $this->input->post("radif", true)[$i];
            $data2["id_prd"] = $this->input->post("prd", true)[$i];
            $data2["id_factor"] = $main_factor_id;
            $data2["takhfif"] = $this->input->post("takhfif", true)[$i] > 0 ? $this->input->post("takhfif", true)[$i] : 0;
            $data2["price"] = $this->input->post("price", true)[$i];
            $data2["num"] = $this->input->post("numprd", true)[$i];
            if ($data2["id_prd"] > 0) {
                $res[$i] = $this->db->insert('factor_prd', $data2);
            }
        }

        // //add ezafat to factor
        // $data_ezafat["id"] = "";
        // for ($i = 1; $i <= count($this->input->post("price_ezafat", true)); $i++) {
        //     $data_ezafat["radif"] = $this->input->post("radif_ezafat", true)[$i];
        //     $data_ezafat["id_factor"] = $main_factor_id;
        //     $data_ezafat["id_ezafat"] = $this->input->post("ezafat", true)[$i];
        //     $data_ezafat["price"] = $this->input->post("price_ezafat", true)[$i];

        //     if ($data_ezafat["price"]) {
        //         $res_dataezafat[$i] = $this->db->insert('factor_ezafat', $data_ezafat);
        //     }
        // }

        // //render level
        // if (!$id) {
        //     $this->load->library("Factor");
        //     $this->factor->render_level($main_factor_id, $this->input->post("level_id", true));
        // }
        return $main_factor_id;

    }
    //manage factor list
    public function manage($filter=null){
        $this->db->select( "a.*,SUM((b.price-b.takhfif)*b.num) as factor_price")
        ->from("factor a")
        ->join("factor_prd b", "b.id_factor = a.id","left")
        ->group_by("a.id");
        return $this->db->get()->result();
    }

    //view factor sell
    public function manage_list($level, $type, $user_id = 0, $mount_ago = 0, $type_date = "date", $type_in, $sort)
    {
        //for datable list
        if ($mount_ago) {
            $start_d = $this->system->get_current_month_timetamp("start", $mount_ago - 1);
            $end_d = $this->system->get_current_month_timetamp("end", $mount_ago - 1);
        }

        $isadminflag = ($this->permision->is_admin()) ? 1 : 0;
        $user_id_tmp = ($user_id == 0) ? $this->system->get_user() : $user_id;
        $user_id_tmp2 = $this->system->get_user();
        $this->db->select("factor.id  , ub.name ,  ub.tell  , factor.date , expire_date , ub.agent ,  ua.name as namec ");
        $this->db->from('factor');
        $this->db->join('user ub', 'ub.id=factor.user_id');
        $this->db->join('user_eemploy ua', 'ua.id=factor.maker_id');
        //load search
        $this->load->library("Search");
        $this->search->result_db();
        //load pagation
        $this->page->result_db();
        //for this mounth
        if ($mount_ago) {
            $this->db->where("factor.$type_date >", $start_d);
            $this->db->where("factor.$type_date <", $end_d);
        }

        //for all expire
        if ($type_in == "expire_all") {
            $end_d = $this->system->get_current_month_timetamp("end");
            $this->db->where("factor.$type_date <", $end_d);
        }

        //if geted user id
        if ($user_id != $user_id_tmp2 && $user_id) {
            $this->db->where('factor.maker_id', $user_id);
        }

        if ($type_in != "list_trans" && $type_in != "list_bedehkar" && $type != "public") {

            $this->db->where('factor.maker_id', $user_id_tmp);
        }

        if ($type == "private" || $user_id == $user_id_tmp2) {
            $this->db->where('factor.maker_id', $user_id_tmp2);
        }

        //apply level filter
        if ($level) {
            $this->db->where('factor.level_id', $level);
        }

        //apply sort
        if ($sort) {
            $this->db->order_by("$sort ASC");
        } else {
            $this->db->order_by("factor.id desc");
        }

        //load pagation
        $this->page->result_db();
        $result = $this->db->get()->result_array();
        $this->page->result_db();
        //
        return $result;

    }

    public function manage_delete($factor_id = 0)
    {
        $this->db->where('id', $factor_id);
        return $this->db->delete('factor');
    }
    public function manage_changelevel($factor_id = 0)
    {
        //setfactor id
        $this->db->select_max('factor_id');
        $factor_fin_id = $this->db->get('factor')->result_array()[0]['factor_id'];
        $factor_fin_id++;

        $this->db->where('id', $factor_id);
        return $this->db->update('factor', array("level_id" => "1", "factor_id" => $factor_fin_id));
    }

    public function show_total_price($id_factor)
    {
        $this->load->library("factor");
        return $this->factor->price($id_factor);
    }

    //edit
    public function edit_factor($id)
    {

        $this->db->select("*");
        $this->db->from('factor');
        $this->db->where('factor.id', $id);
        $this->db->join("factor_prd", "factor_prd.id_factor=factor.id");
        return $this->db->get()->result_array();
    }

    // add all factor to alerts system
    public function add_all_factor_to_alert()
    {
        $this->db->select("*");
        $this->db->from('factor');
        $res = $this->db->get()->result_array();
        foreach ($res as $key => $value) {
            $def_users = $this->system->get_users_from_usergroup(json_decode($this->system->get_setting("expire_alerts_users_group")));
            $this->alerts_lib->add_alert(1, array("id" => $value["id"]), $value["expire_date"], "", $def_users);
            echo "factor:" . $value["id"] . "added <br>";
        }
    }

    //return expire factor
    public function alert_expire_counter()
    {
        return $this->alerts_lib->count_alert(1);
    }

    //return commision from employer
    public function get_user_totalprice($user_id = 0, $level = 1, $type = 1)
    {
        $user_id = ($user_id == 0) ? $this->system->get_user() : $user_id;
        $res_factor = $this->db->get_where("factor", array("maker_id" => $user_id, "level_id" => $level))->result_array();
        $tot = 0;
        $date = 0;
        foreach ($res_factor as $key => $value) {
            $tot += $this->show_total_price($value["id"]);
            $date = $value["date"];
        }
        if ($type == 1) {return $tot;
        } else if ($type == "date") {
            return $date;
        }
    }

    //return commision from employer
    public function get_user_totalpay($user_id = 0, $level = 1, $type = 1)
    {
        $user_id = ($user_id == 0) ? $this->system->get_user() : $user_id;
        $res_factor = $this->db->get_where("factor", array("maker_id" => $user_id, "level_id" => $level))->result_array();
        $tot = 0;
        $date = 0;
        foreach ($res_factor as $key => $value) {
            $tot += $this->show_total_price($value["id"]) - $this->factor->geted_money_factor($value["id"]);
            $date = $value["date"];
        }
        if ($type == 1) {return $tot;
        } else if ($type == "date") {
            return $date;
        }
    }

    //reject factor_add
    public function reject_factor_add($id_factor)
    {
        $res_factor = $this->edit_factor($id_factor);

        $data = array();
        $data2 = array();
        $res_data2 = array();
        $data["user_id"] = $res_factor[0]["user_id"];
        $data["date"] = strtotime($this->input->post("factor_date", true));

        $data["maker_id"] = $this->system->get_user();
        $data["params"] = json_encode(array("id" => $id_factor));
        $data["des"] = $this->input->post("des", true);
        $data["parent_id"] = $this->input->post("parent_id", true);
        $this->db->insert('factor', $data);
        $main_factor_id = $this->db->insert_id();
        $c = 0;
        for ($i = 1; $i <= count($this->input->post("num", true)); $i++) {
            if ($this->input->post("num", true)[$i]) {
                $c++;
                $data2["radif"] = "[$c]";
                $data2["id_prd"] = $this->input->post("prd", true)[$i];
                $data2["id_factor"] = $main_factor_id;
                $data2["takhfif"] = 0;
                $data2["price"] = $this->input->post("price", true)[$i];
                $data2["num"] = $this->input->post("num", true)[$i];
                $res_data2[$c] = $this->db->insert('factor_prd', $data2);
            }
        }

        //render level
        $this->load->library("Factor");
        $this->factor->render_level($main_factor_id, $this->system->get_setting("deafult_reject_factor_level"));
        return $main_factor_id;
    }

    public function get_money_add($id_factor)
    {
        $res_factor = $this->edit_factor($id_factor);
        $data = array();
        $data["user_id"] = $res_factor[0]["user_id"];
        $data["date"] = strtotime($this->input->post("date", true));
        $data["maker_id"] = $this->system->get_user();
        $data["factor_id"] = $id_factor;
        $data["des"] = $this->input->post("des", true);
        $data["price"] = (int) $this->input->post("price", true);
        return $this->db->insert('pay', $data);
    }
    //other_pay
    public function other_pay_add($id_factor)
    {
        $res_factor = $this->edit_factor($id_factor);
        $data = array();
        $data["user_id"] = $res_factor[0]["user_id"];
        $data["eemploy_id"] = $res_factor[0]["maker_id"];
        $data["date"] = strtotime($this->input->post("date", true));
        $data["maker_id"] = $this->system->get_user();
        $data["factor_id"] = $id_factor;
        $data["des"] = $this->input->post("des", true);
        $data["price"] = $this->input->post("price", true);
        $main_factor = $this->db->insert('factor_other_pay', $data);
        return $main_factor;
    }
    public function list_other_pay($id_factor)
    {
        return $this->db->get_where('factor_other_pay', "factor_id=$id_factor")->result_array();
    }
    public function getAdditions(){
        return $this->db->get("factor_additions")->result();
    }

}
