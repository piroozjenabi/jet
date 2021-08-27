<?php defined('BASEPATH') or exit('No direct script access allowed');
class Tmp_users_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function add_users($id = "")
    {
        $def_state = $this->db->get_where("tmp_client_state", "deafult=1")->result_array()[0]["id"];
        //limit for tmp user
        $limit_tmp = $this->db->get_where("tmp_client_state", "id=$def_state")->result_array()[0]["limit"];
        $user_id = $this->system->get_user();
        $res = $this->db->get_where("tmp_client", array("maker_id" => "$user_id", "state" => $def_state))->result();
        $count_res = count($res);
        if ($limit_tmp <= $count_res || $limit_tmp < 0) {
            return -1;
        }

        $data = array();
        $data["id"] = $id;
        $data["name"] = post("name", true);
        $data["tmp_client_peyment"] = post("tmp_client_peyment", true);
        $data["tmp_client_type"] = post("tmp_client_type", true);
        $data["email"] = post("email", true);
        $data["mobile"] = post("mobile", true);
        $data["tell"] = post("tell", true);
        $data["state"] = $def_state;

        $data["date_modify"] = $id ? jetDate() : null;
        $data["date_expire"] = "";
        $data["address"] = post("address", true);
        if (!$id) {
            $data["maker_id"] = $this->system->get_user();
        }

        $data["contact"] = post("contact", true);
        $data["extra1"] = post("extra1", true);
        $data["extra2"] = post("extra2", true);

        if (!$id) {
            $res = $this->db->insert('tmp_client', $data);
        } else {
            $this->db->where("id", $id);
            $res = $this->db->update('tmp_client', $data);
        }

        return $res;
    }

    public function add_track($id = "")
    {

        $user_id = $this->system->get_user();

        for ($i = 1; $i <= count(post("track", true)); $i++) {

            $data = array();
            $data["id"] = "";
            $data["message"] = post("track", true)[$i];
            $data["from_user"] = $user_id;
            //            for replay
            if (post("replay", true)[1]) {
                $data["replay"] = post("replay", true)[1];
            }
            $data["tmp_user"] = $id;
            //            die(post("track", TRUE)[$i]);
            if ($data["message"] != "") {
                $res = $this->db->insert('tmp_client_tracking', $data);
            }

        }
        return $res;
    }
    //list track
    public function list_track($id)
    {
        $this->db->select("*");
        $this->db->where("tmp_user", $id);
        $this->db->from('tmp_client_tracking');
        return $this->db->get()->result_array();
    }

    //manage user model
    public function manage_user($my_id = "", $state)
    {

        $this->db->select("*");
        $this->db->from('tmp_client');
        if ($my_id) {
            $this->db->where("maker_id", $my_id);
        }
        $this->db->where("state", $state);

        return $this->db->get()->result_array();
    }

    public function count_tmp_user($user_id = 0)
    {
        $user_id = ($user_id == 0) ? $this->system->get_user() : $user_id;
        $this->db->select("id");
        $this->db->from('tmp_client');
        $this->db->where("maker_id", $user_id);
        return count($this->db->get()->result_array());

    }
    //delete
    public function manage_delete($user_id = 0)
    {

        $this->db->where('id', $user_id);

        return $this->db->delete('user');

    }
    //edit
    public function edit_user($id)
    {

        $this->db->select("*");
        $this->db->from('tmp_client');
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }
    //list_state
    public function list_state()
    {
        return $this->db->select("*")
            ->from('tmp_client_state')
            ->order_by('order_by')
            ->get()->result_array();
    }
    //list_type
    public function list_type()
    {
        return $this->db->select("*")->from('tmp_client_type')->get()->result_array();
    }

    ///chaNGE STATE
    public function change_state($id = 0, $state)
    {
        $this->db->where('id', $id);
        return $this->db->update('tmp_client', array("state" => $state, "date_modify" => jetDate()));
    }

    //return tmp state info
    public function get_state($id)
    {
        $this->db->select("*");
        $this->db->from("tmp_client_state");
        $this->db->where("id", $id);
        return $this->db->get()->result_array();

    }

    //convert from tmp to user
    public function convert_to_client($tmp)
    {

        $data = array();
        $data["id"] = "";
        $data["name"] = $tmp[0]["name"];
        $data["email"] = $tmp[0]["email"];
        $data["mobile"] = $tmp[0]["mobile"];
        $data["tell"] = $tmp[0]["tell"];
        $data["date_create"] = jetDate();
        $data["date_modify"] = jetDate();
        $data["date_expire"] = "";
        $data["address"] = $tmp[0]["address"];
        $data["usergroup"] = config("def_user_group_after_convert");
        $data["maker_id"] = $this->system->get_user();
        $data["state"] = "1";
        $data["agent"] = $tmp[0]["contact"];
        $data["status_id"] = 1;
        $data["perfix_code"] = config("perfix_user");
        $data["tmp_user"] = $tmp[0]["id"];

         
        return $this->db->insert('user', $data)
        ? $this->db->insert_id()
        : 0;
    }
}
