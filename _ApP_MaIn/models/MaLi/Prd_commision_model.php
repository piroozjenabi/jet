<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Prd_commision_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    function listall()
    {

        $this->db->select("*");
        $this->db->from("mali_commision");
        $this->db->join("mali_commision_group", "mali_commision.groupc=mali_commision_group.id");
        $this->db->join("prd", "mali_commision_group.prd=prd.id");
        return $this->db->get()->result_array();


    }
}
