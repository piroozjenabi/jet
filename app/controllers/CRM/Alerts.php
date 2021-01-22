<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Alerts extends CI_Controller
{
    //manage list of alert
    function index($type_id="-1")
    {
        $res=$this->alerts_lib->menu_list($type_id);
        $res=$this->alerts_lib->render($res);
        $this->template->load("CRM/alerts/main_list", ["db"=>$res,"type_id"=>$type_id]);
    }
    //read alert json input
    function read_alert()
    {
        $id=post("id", true);
        if($this->alerts_lib->read_alert($id)) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }
    //    delete alert get id and delete
    function delete()
    {
        $id=post("id", true);
        if($this->alerts_lib->delete_alert($id)) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }

}
