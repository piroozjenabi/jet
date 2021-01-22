<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Promoter_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function add_users($id="")
    {

        $user_id=$this->system->get_user();

        $data= array( );
        $data["id"]=$id;
        $data["name"]=post("name", true);
        $data["meli_id"]=post("meli_id", true);
        $data["group_id"]=post("group_id", true);
        $data["email"]=post("email", true);
        $data["mobile"]=post("mobile", true);
        $data["tell"]=post("tell", true);
        $data["address"]=post("address", true);
        $data["sallari"]=post("sallari", true);
        $data["user_id"]=post("user_id", true);
        $data["hour_daily"]=post("hour_daily", true);

        //        $data["date_modify"]=time();
        if (!$id) {//edit mode
            $data["datecreate"]=time();
        }
        $data["address"]=post("address", true);
        if (!$id) {
            $data["maker_id"] = $user_id;
        }
        $data["extra1"]=post("extra1", true);
        $data["extra2"]=post("extra2", true);
        $data["extra3"]=post("extra3", true);

        if (!$id) {
            $res=$this->db->insert('crm_Promoter', $data);
        }
        else{
            $this->db->where("id", $id);
            $res=$this->db->update('crm_Promoter', $data);
        }

        return $res;
    }

    public function add_track($id="")
    {

        $user_id=$this->system->get_user();

        for ($i=1;$i<=count(post("track", true));$i++) {

            $data = array();
            $data["id"] = "";
            $data["text"] = post("track", true)[$i];
            $data["date"] = time();
            $data["user_id"] = $user_id;
            //            for replay
            if(post("replay", true)[1]) {
                $data["replay"]=post("replay", true)[1];
            }
            $data["Promoter_id"] = $id;
            //            die(post("track", TRUE)[$i]);
            if($data["message"]!="") {
                $res = $this->db->insert('Promoter_track', $data);
            }

        }
        return $res;
    }
    //list track
    public function list_track($id)
    {
        $this->db->select("*");
        $this->db->where("Promoter_id", $id);
        $this->db->from('Promoter_track');
        return $this->db->get()->result_array();
    }


    //manage user model
    public function manage_user($my_id="",$state)
    {

        $this->db->select("*");
        $this->db->from('crm_Promoter');
        if($my_id) {
            $this->db->where("maker_id", $my_id);
        }

        return $this->db->get()->result_array();
    }


    public function count_tmp_user($user_id=0)
    {
        $user_id=($user_id==0)?$this->system->get_user():$user_id;
        $this->db->select("id");
        $this->db->from('tmp_client');
        $this->db->where("maker_id", $user_id);
        return count($this->db->get()->result_array());

    }
    //delete
    public function manage_delete($user_id=0)
    {


        $this->db->where('id', $user_id);

        return     $this->db->delete('user');

    }
    //edit
    public function edit_user($id)
    {

        $this->db->select("*");
        $this->db->from('crm_Promoter');
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }
    //list_state
    public function list_state($state=0)
    {

        $this->db->select("*");
        $this->db->from('tmp_client_state');
        $this->db->order_by('order_by');
        return $this->db->get()->result_array();
    }

        ///chaNGE STATE
    public function change_state($id=0,$state)
    {


        $this->db->where('id', $id);
        return     $this->db->update('tmp_client', array("state" => $state));


    }

    //return tmp state info
    public function get_state($id)
    {
        $this->db->select("*");
        $this->db->from("tmp_client_state");
        $this->db->where("id", $id);
        return $this->db->get()->result_array();

    }

}
