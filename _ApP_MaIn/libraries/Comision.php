<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
 
class Comision
{
    //list group commison
    function list_group($where=null)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from("mali_commision_group");
        if ($where) { $CI->db->where($where);
        }
        return $CI->db->get()->result_array();
    }

    //list commison
    function list_comision($group=null,$where=null)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from("mali_commision");
        if ($where) { $CI->db->where($where);
        }
        if ($group) { $CI->db->where("groupc", $group);
        }
        return $CI->db->get()->result_array();
    }

    //list commison
    function list_comision_month($group=null,$where=null)
    {


        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from("mali_commision");
        if ($where) { $CI->db->where($where);
        }
        if ($group) { $CI->db->where("groupc", $group);
        }
        return $CI->db->get()->result_array();
    }



}
