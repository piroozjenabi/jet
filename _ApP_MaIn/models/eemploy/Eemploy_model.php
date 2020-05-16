<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Eemploy_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function add_users($id="")
    {

        $data= array();

        foreach ($this->input->post() as $key => $value)
        {
            if(isset($value) && $key!="date_create" ) {
                $data[$key]=$value;
            }
        }


        //for password
        if(isset($data["password"])  && $data["password"]!="" ) {
            $time=$this->db->get_where("user_eemploy", array('id' => $id))->row()->date_create;
            $data["password"]=$this->system->hashp($data["password"], $time);
        }
        //unset pass if blank
        if($data["password"]=="") { unset($data["password"]);
        }
        $data["date_modify"]=time();
        $data["maker_id"]=$this->system->get_user();
        $this->db->where("id", $id);
        return $this->db->update('user_eemploy', $data);
    }
    //get user details for  edit
    public function edit_user($id)
    {
          @ $this->permision->check("eemploy_edit", true);
        $this->db->select("*");
        $this->db->from('user_eemploy');
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }

    //    ----change permison
    public function chnage_permision($id)
    {
        $this->permision->delete_permision_usergroup($id);
        $tmp_array=array();
        $c=1;
        foreach ($this->input->post("perm", true) as $k => $v)
        {
            $tmp_array[$c++]=array("usergroup_id"=>$id,"permision_id"=>$k);
        }
        return $this->permision->add_permision_usergroup($tmp_array);
    }

    //change profile from post method
    public function change_profile()
    {
        $data=[];
        foreach($this->input->post(null, true) as $key => $value) {
            if($key!="id") {    $data["$key"]=$value;
            }
        }
        if(isset($data["birthday"])) { $data["birthday"]=strtotime($data["birthday"]);
        }
        return $this->db->update("user_eemploy", $data, "id={$this->input->post("id",true)}");
    }
}
