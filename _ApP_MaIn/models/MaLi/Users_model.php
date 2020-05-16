<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Users_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //    edit full user
    public function pedit_user($id=null)
    {
        $data= array();

        foreach ($this->input->post() as $key => $value)
        {
            if ($value) {
                $data[$key]=$value;
            }
        }
        //for password
        if(isset($data["password"])) {
            $time=$this->db->get_where("user", array('id' => $id))->result_array()[0]["date_create"];

            $data["password"]=$this->system->hashp($data["password"], $time);
        }
        $data["date_modify"]=time();
        $this->db->where("id", $id);
        return $this->db->update('user', $data);
    }
    //edit list of values
    public function edit_user($id)
    {
        $this->db->select("*");
        $this->db->from('user');
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }





}
