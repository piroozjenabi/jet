<?php defined('BASEPATH') or exit('No direct script access allowed');
class Project_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function add_project($post)
    {
        $this->load->library("Project_lib");
        $data =[
            "name" => $post["name"],
            "des" => $post["des"],
            "status" => $post["status"],
            "maker_id" => $this->system->get_user()
        ];
        if(isset($this->project_lib->status_array[$post["status"]])) 
            $data["{$post["status"]}_date"] = date("Y-m-d h:i:s");
 
        if(!$this->db->insert("project",$data) ) return ["false",_ERROR_ADD.__.PROJECT];
        // $project_id=$this->db->insert_id();
        return true;
    }

    //---------------------
    function get_project_full($id){
        $out = array();
        $out["project"]=$this->db->get_where("project","id = $id")->row();
        $out["user"]=$this->db->select("a.*,b.name")->from("project_user a")->join("user b","a.user_id = b.id")->where("project_id",$id)->get()->result();
        $out["prd"]=$this->db->select("a.*,b.name")->from("project_prd a")->join("prd b","a.prd_id = b.id")->where("project_id",$id)->get()->result();
        $out["company"]=$this->db->select("a.*,b.name")->from("project_company a")->join("crm_company b","a.company_id = b.id")->where("project_id",$id)->get()->result();
        return $out;
    }


}    