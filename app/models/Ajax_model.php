<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Ajax_model extends CI_Model
{
    public $dashboard_data= array();
    function __construct()
    {
        parent::__construct();
    }
    //set editable text model
    function set_text_edit($pg,$id,$field)
    {
        $value= (strpos(post("value", true), '"') )?post("value", true): str_ireplace(",", "", post("value", true));
        $data=array($field=>$value );
        $this->db->where("id", $id);
        return $this->db->update($pg, $data);
    }



}
