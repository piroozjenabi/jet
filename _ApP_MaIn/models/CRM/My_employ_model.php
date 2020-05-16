<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class My_employ_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    //list of my user
    function my_client_list($user_id)
    {


        $this->load->model("MaLi/Factor_sell_model");
        $this->load->library('Piero_jdate');
        $def_usergroup_seller=json_decode($this->system->get_setting("defualt_selluser_group"));

        $enable_admin_see_all=$this->system->get_setting("enable_user_just_can_see_child_emp");

        //        $this->db->distinct();
        $this->db->select('*');
        $this->db->from('user_eemploy');
        if($enable_admin_see_all) {
            $this->db->where("user_eemploy.maker_id", $user_id);
        }

        $this->db->where_in("user_eemploy.usergroup", $def_usergroup_seller);

        $this->db->order_by('user_eemploy.name', 'DESC');

        $res=$this->db->get()->result_array();


        return $res;

    }



}
