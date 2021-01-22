<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller
{

    function index($show_alert=false)
    {
        $this->load->model("dashboard_model");
        $res = $this->dashboard_model->get_all_module_permission();
        $this->render($res, $show_alert);
    }
    function render($res,$show_alert)
    {
        $html="";
        foreach ($res as $key => $value) {
            if ($value["load_type"]) {
                $value["propertis"]=json_decode($value["propertis"]);
                $value["db"] = $this->dashboard_model->{$value["load_type"]}($value);
                $html .= $this->load->view("mod/" . $value["load_type"], $value, true);
            }
        }
        $this->template->load("Dashboard_view", array("html"=>$html,"show_alert"=>$show_alert), array("title"=>_DASHBOARD));
    }
    ///change password
    public function change_pass_view()
    {
        $this->template->load_popup("ASF!@EAD!@#/Asdfgjkh#213rsdf#4", _CHANGE_PASSWORD);
    }
    //change paasord for users
    public function change_PASS_p()
    {
        $user_name=$this->system->get_user("username");
        $pass_word=post("old");
        $npass_word=post("neW");
        $res=$this->system->check_up2($user_name, $pass_word);
        if($res) {
            if($this->system->change_pass($res, $pass_word, $npass_word)) {
                $this->system->message(_PASSWORD.__._CHANGED_SUC);
            }
        }
        else{
            $this->system->message(_ERROR.__._PASSWORD);
        }
        redirect("Dashboard");
    }

    ///fill profile user employer
    public function fill_profile()
    {
        $this->template->load_popup("ASF!@EAD!@#/asd$#asd", _FILL_PROFILE);
    }
    public function fill_profilep()
    {
        $this->load->model("eemploy/Eemploy_model", 'e');
        $res=$this->e->change_profile();

        if($res) {

                $this->system->message(_PASSWORD.__._CHANGED_SUC);
        }
        else{
            $this->system->message(_ERROR.__._PASSWORD);
        }
        redirect("Dashboard");
    }


}
