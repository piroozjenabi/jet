<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Manage extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->lang->load("auto");
    }

    //load popup details of forms
    public function show_form()
    {
            $this->load->library("auto");
            $id=$this->input->post("id", true);
        //            $this->auto->refer_read($id);
            $id_form=$this->auto->get_form_from_id($id)[0]["form_id"];
            $ret=$this->auto->render_form($id_form, $id, "view");
            $this->template->load_popup("AUTO/show_form", _VIEW_DETAILS.__._FORM, array("view_form" => $ret,"form_id" => $id));
    }




}
