<?php defined('BASEPATH') or exit('No direct script access allowed');
class Project_lib{

    public $status_array= ["todo" => _TODO, "doing" => _DOING, "done" => _DONE];


    //---------------------project

    function add_user_project($id,$user){
        $ci=&get_instance();
        return $ci->db->insert("project_user",[
            "project_id"=>$id,
            "user_id"=>$user
        ]);
    }
    function add_prd_project($id,$prd){
        $ci=&get_instance();
        return $ci->db->insert("project_prd",[
            "project_id"=>$id,
            "prd_id"=>$prd
        ]);
    }
    function add_company_project($id,$user){
        $ci=&get_instance();
        return $ci->db->insert("project_company",[
            "project_id"=>$id,
            "company_id"=>$user
        ]);
    }

    function set_status_project($id,$status){
        $ci=&get_instance();
        return $ci->db->where("id",$id)->update("project",["status"=>$status,"{$status}_date"=>date("Y-m-d h:i:s")]);
    }
    //---------------------todo and comments
    function list_todo($data=array())
    {
        $ci=&get_instance();
        $ci->db->select('*')->from("project_todo")->order_by("done")->order_by("date",'DESC');
        if(isset($data['project_id']) && $data['project_id']  ) $ci->db->where("project_id", $data['project_id']);
        return $ci->db->get()->result();
    }

    function add_todo($data){
        $ci=&get_instance();
        if(!$data['name'] || !$data['project_id']  || !$data['maker_id'] )
            return ["status"=>false,"err"=>_ERROR_IN_INPUT_PARAMS];
        return $ci->db->insert("project_todo",$data);
    }
    function add_comment($data){
        $ci=&get_instance();
        if(!$data['comment'] || $data['comment'] == "  " || !$data['project_id']  || !$data['maker_id'] )
        return ["status"=>false,"err"=>_ERROR_IN_INPUT_PARAMS];
        return $ci->db->insert("project_comments",$data);
    }

    function list_comments($data=array())
    {
        $ci=&get_instance();
        $ci->db->select('*')->from("project_comments");
        if(isset($data['project_id']) && $data['project_id']  ) $ci->db->where("project_id", $data['project_id']);
        return $ci->db->get()->result();
    }

    function delete_todo($id){
        $ci=&get_instance();
        return $ci->db->where("id",$id)->delete("project_todo");
    }

    function set_todo_done($id){
        $ci=&get_instance();
        return $ci->db->where("id",$id)->update("project_todo",["done"=>1]);
    }

}
