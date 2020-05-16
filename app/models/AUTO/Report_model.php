<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Report_model extends CI_Model
{

    //render base for render base
    var $column_title=null;
    var $column_order=null;
    var $column_type=null;
    var $column_search=null;
    var $column_params=null;

    function __construct()
    {
        parent::__construct();
    }
    //fetch all variable for report main
    public function render_base($form_id)
    {
        $res=$this->auto->list_field_from_id($form_id);
        $this->load->model("AUTO/Auto_forge_model", "forge");
        $tmp_title=array("#");
        $tmp_name=array("form_value_id");
        $tmp_search=array(null);
        $tmp_type=array("id");
        $tmp_params=array(null);
        foreach ($res as $key => $value)
        {
            if($this->forge->elements[$value["type"]]) {

                $tmp_title[] = $value["des"];
                $tmp_name[] = $value["name"];
                $tmp_search[] = $value["name"];
                $tmp_type[] = $value["type"];
                $tmp_params[] = $value["params"];
            }
            //            $tmp_params[]=$value["params"];
        }
        $this->column_title=$tmp_title;
        $this->column_order=$tmp_name;
        $this->column_search=$tmp_search;
        $this->column_type=$tmp_type;
        $this->column_params=$tmp_params;


    }

}
