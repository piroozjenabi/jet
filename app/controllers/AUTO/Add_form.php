<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Add_form extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->lang->load("auto");
    }
    public function index()
    {
        $this->load->library("auto");
        $res=$this->auto->list_value_form();
        //load for data table
        loadV("AUTO/Add_form/add_form_view", ["forms" =>$res], ["title" => _AUTOM]);

    }
    //load add
    public function add($form_number)
    {
        $this->load->library("auto");
        $tmp=$this->db->get_where("auto_forms", "id=$form_number")->result_array()[0];
        loadV("AUTO/Add_form/form", array("form_id"=>$form_number,'out' =>$this->auto->render_form($form_number),"title"=>_AUTO_ADD_FORM.__.$tmp["name"]."<small>".$tmp["des"]."</small>"),["title"=>_AUTO_ADD_FORM]);
    }
    //save form
    public function padd()
    {
        $form_number=post("form_id");
        $auto_refer=post("auto_refer");
        $this->load->library("auto");

        //validate form
        $validate=$this->auto->add_validate();
        if($validate!=1) {
            echo json_encode($validate);
            die();
        }
        if (post("form_value_id", true)!= null) {
            $form_id=$this->auto->add_forms_record($form_number, post("form_value_id", true));
            $this->auto->add_history($form_id, 2);
        }
        else{
            $form_id=$this->auto->add_forms_record($form_number);
            $this->auto->add_history($form_id, 1);

        }

        if(isset($form_id)) {
            //auto refer setting --- mode auto refer in setting
            if ($auto_refer) {
                $this->auto->auto_refer($form_id, $form_number);
            }
            //add history add
            echo json_encode(array("status" => true,"id"=>$form_id,"form_id"=>$form_number));
        }
        else {
            echo json_encode(array("status" => false));
        }
    }
    //edit form
    public function edit($form_number,$id)
    {
        $this->load->library("auto");
        loadV("AUTO/Add_form/form", array('out' =>$this->auto->render_form($form_number, $id),"title"=>_EDIT ));
    }
    //delete form from id
    public function delete()
    {
        $this->load->library("Auto");
        $id=post("id");
        if((count($this->auto->list_refer_accepted($id))==0 )|| $this->permission->check("auto_edit_after_accepted") ) {
            $this->load->library("auto");
            if ($this->auto->delete_form_value($id)) {
                echo json_encode(array("status" => true));
            } else {
                echo json_encode(array("status" => false));
            }
        }
        else { die();
        }
    }

}
