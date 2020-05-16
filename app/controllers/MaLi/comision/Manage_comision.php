<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
 
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_comision extends CI_Controller
{

    public function index()
    {
        $this->load->library("comision");
        $res=$this->comision->list_group();
        $this->template->load('MaLi/comision/manage_view', array('db' => $res ));
    }

    //add group too database
    function padd()
    {

        if ($this->element->quick_padd("mali_commision_group")) {
            $this->system->message(_GROUP.__._COMMISSION._ADDED);
        }
        redirect("/MaLi/comision/Manage_comision");
    }


    //---------------------------popup windows for add field data
    public function add_comision()
    {
        $this->load->library("comision");
        $group=$this->input->post("id", true);
        $data = array('db' => $this->comision->list_comision($group) ,"id"=>$group);
        $this->template->load_popup('MaLi/comision/add_comision', _LIST.__._FIELD_DATA, $data);
    }
    //add tree submit
    function padd_comision($id)
    {
        $this->load->model("MaLi/Comission_model");

        if ($this->Comission_model->add_comisions($id)) {
            $this->system->message(_COMMISSION._ADDED);
        }
        redirect("MaLi/comision/Manage_comision");
    }


}
