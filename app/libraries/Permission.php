<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * load all thing about permision
 * power by pirooz jenabi
 * jenabi.pirooz@gmail.com -- info@piero.ir
 */
class Permission
{
    function __construct()
    {
        //    $this::check_permision_page();

    }

    function list_main_permision()
    {
        $CI =& get_instance();
        return    $CI->db->get_where("permision_group", "lisence=1 AND menu=1")->result_array();
    }
    function list_menu_permision($group_id)
    {
        $CI =& get_instance();
        $user_group=$CI->system->get_user("usergroup");
        return    $CI->db->select("*")
            ->from("permision")
            ->where("menu", 1)
            ->where("permision_group_id", $group_id)
            ->order_by("order_by")
            ->join("permision_usergroup", 'permision_usergroup.permision_id=permision.id')
            ->where("permision_usergroup.usergroup_id", $user_group)
            ->get()->result_array();
    }

    public function check_permision_page()
    {

        //        $ch_perm=$this::check_permision();
        //        if ( !$ch_perm ){
        //            $CI =& get_instance();
        //            $CI->system->message(_PERMISION_DENIED);

        //$CI->system->goHome();
        //echo uri_string();
        //        }
    }
    //load permision user grroup
    public function check_permision($controller=null)
    {

        $CI =& get_instance();
        $id_user=$CI->system->get_user();
        $usergroup_id=$CI->system->get_user("usergroup");
        $home=$CI->system->get_setting("home");
        $cur_controler=$CI->router->fetch_class();
        $cur_func=$CI->router->fetch_method();
        echo $cur_func;

        if ($controller==null) {
            $controller=uri_string();
        }
        //die($cur_controler);
        if ($controller=="" || $cur_controler=="Factor_sell_pre"|| $cur_controler=="login" || $controller==$home ) {
            return 1;

        }

        $CI->db->select("permision_usergroup.permision_id");
        $CI->db->from("permision_usergroup");
        $CI->db->join("permision", "permision.id=permision_usergroup.permision_id");
        $CI->db->where("permision_usergroup.usergroup_id", $usergroup_id);
        $CI->db->where("permision.controller", $controller);
        $res=$CI->db->get()->result_array();
        if($res) {
            return $controller;
        }
        else
        {

            return 0;

        }


    }

    //get id permision

    public function get($permision,$type="id")
    {
        $CI =& get_instance();
        $CI->db->select($type);
        $CI->db->where('name', $permision);
        $CI->db->from('permision');
        return $CI->db->get()->result_array()[0][$type];


    }
        //check user_permision
    public function check($permision,$user_id=0,$redirect=0)
    {

        $CI =& get_instance();
        $permision=$this->get($permision);
        $user_group=($user_id)?$CI->system->get_user_from_id($user_id, "usergroup"):$CI->system->get_user("usergroup");
        $CI->db->select('id');
        $CI->db->where('usergroup_id', $user_group);
        $CI->db->where('permision_id', $permision);
        $CI->db->from('permision_usergroup');
        if (@$CI->db->get()->result_array()[0]["id"] ) {
            return true;
        } else
            {
            if(!$redirect) {
                return false;
            }
            else{
                die();
                $CI->system->message(_ACCESS_DENIED);
                redirect("dashboard");
            }
        }


    }



    function is_admin($id_user=0)
    {
        $CI =& get_instance();
        if(!$id_user) {
            $id_user=$CI->system->get_user("usergroup");
        }
        if($id_user==1 || $id_user==4 ) {
            return true;
        } else {
            return false;
        }

    }

    function user_permision()
    {
        $CI =& get_instance();
        if($CI->system->get_user()==26) {
            return true;
        }
        return false;
    }

    function add_permision($name,$des,$param)
    {

    }
    //return list all permision
    public function list_all($group=0)
    {
        $CI =& get_instance();
        $CI->db->select("*");
        if($group) {
            $CI->db->where("permision_group.id", $group);
        }
        $CI->db->from("permision");
        $res=$CI->db->get()->result_array();
        return $res;
    }


    //list category for lisence chech

    public function list_cat_permision()
    {
        $CI =& get_instance();
        $CI->db->select("*");
        $CI->db->where("lisence=1");
        $CI->db->from("permision_group");
        $res=$CI->db->get()->result_array();
        return $res;
    }
    public function list_permision_usergroup($usergroup=0,$cat=0)
    {

        $CI =& get_instance();
        $usergroup=($usergroup ==0)?$CI->system->get_user("usergroup"):$usergroup;
        $CI->db->select("permision_id");
        $CI->db->where("usergroup_id", $usergroup);
        $CI->db->from("permision_usergroup");
        $res_usergroup=$CI->db->get()->result_array();
        $tmp_array=array();
        $c=1;
        foreach ($res_usergroup as $k =>$v)
        {
            $tmp_array[$c]= $v["permision_id"];
            $c++;
        }


        $CI->db->select("*");
        if($cat) {
            $CI->db->where("permision_group_id", $cat);
        }
        $CI->db->from("permision");
        $res=$CI->db->get()->result_array();

        foreach ($res as $key => &$value)
        {

            if(array_search($value["id"], $tmp_array)) {
                $value["active"] = 1;
            } else {
                $value["active"]=0;
            }
        }



        return $res;
    }
    //check permision and delete
    public function delete_permision_usergroup($id)
    {
        //        if (!$this->check("eemploy_permision")) return false;
        $CI =& get_instance();
        $CI->db->where("usergroup_id", $id);
        return $CI->db->delete("permision_usergroup");
    }
    //check permision and add
    public function add_permision_usergroup($arr)
    {
        //        if (!$this->check("eemploy_permision")) return false;
        $CI =& get_instance();
        return $CI->db->insert_batch("permision_usergroup", $arr);
    }

    //    check permision have module dashboard
    function is_module($id)
    {
        $CI =& get_instance();
        return $CI->db->get_where("module", "permision_id=$id")->result_array();
    }

}
