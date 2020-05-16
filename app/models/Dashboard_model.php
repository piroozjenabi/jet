<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Dashboard_model extends CI_Model
{
    public $dashboard_data= array();
    function __construct()
    {
        parent::__construct();
    }

    function get_all_module_permision()
    {
        $user_group=$this->system->get_user("usergroup");
        $this->db->select("*");
        $this->db->from("module");
        $this->db->order_by("module.name", "asc");
        $this->db->where("permision_usergroup.usergroup_id", $user_group);
        $this->db->join("permision_usergroup", "permision_usergroup.permision_id=module.permision_id");
        $res=$this->db->get()->result_array();
        return $res;
    }

    function get_modules($id=0)
    {
        if ($id) {
            return $this->db->get_where("module", array('state'=>'1','id'=>$id))->result_array();
        } else {
            return $this->db->get_where("module", array('state'=>'1'))->result_array();
        }
    }

    function panel_icon($value)
    {
        @$model=$value['propertis']->model_counter;
        @$func=$value['propertis']->func_counter;
        @$loc=$value['propertis']->model_loc;
        $CI =& get_instance();
        if ($model && $func) {
            $CI->load->model($loc);

             $res= $CI->$model->$func();
            $ret=array("num"=>$res);
            return $ret;
        }
        return true;
    }

    function panel_btn($value)
    {
        @$model=$value['propertis']->model_counter;
        @$func=$value['propertis']->func_counter;
        @$loc=$value['propertis']->model_loc;
        $CI =& get_instance();
        if ($model && $func) {
            $CI->load->model($loc);

             $res= $CI->$model->$func();
            $ret=array("num"=>$res);
            return $ret;
        }
        return true;
    }

    public function limit_sell()
    {
        $this->load->library("Factor");
        $user_id=$this->system->get_user();
        $lim=$this->system->get_user_eemploy_from_id($user_id, "limit_sell");
        $ret=array(
            "user_limit"=>$lim,
            "user_selled"=>$this->factor->render_limit_pay($user_id)

        );
        return $ret;

    }

}
