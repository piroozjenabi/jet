<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

class Add_form_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function add_field_group($id)
    {
        for ($i=1;$i<=count(post("name", true));$i++) {
            $data = array();
            $data["name"] = post("name", true)[$i];
            $data["value"] = (post("value", true)[$i])?post("value", true)[$i]:post("name", true)[$i];
            $data["group_id"] = $id;

            if($data["name"]) {    $res = $this->db->insert('auto_forms_field_data', $data);
            }
        }


    }
}
