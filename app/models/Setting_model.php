<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Setting_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function manage($group)
    {
        $CI =& get_instance();
        $CI->db->select("*");
        if($group) { $CI->db->where("group_id", $group);
        }
        $CI->db->from("setting");
        $res=$CI->db->get()->result_array();
        return $res;
    }
    public function manage_group()
    {
        $CI =& get_instance();
        $CI->db->select("* , setting_group.name as name, setting_group.id as id")
            ->from("setting_group")
            ->join("permision_group", "setting_group.permision_group=permision_group.id")
            ->where("permision_group.lisence=1");

        $res=$CI->db->get()->result_array();
        return $res;
    }

}
