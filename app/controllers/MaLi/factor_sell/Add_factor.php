<?php defined('BASEPATH') or exit('No direct script access allowed');
class add_factor extends CI_Controller
{
    ###############################################load add factor
    public function index($level = 0)
    {
        $level = ($level) ? $level : $this->system->get_setting("deafult_factor_level");
        $this->template->load('MaLi/factor_sell/add_main', ["level" => $level]);
    }
    ###############################################aff factor to database
    public function padd($id = "")
    {
        $this->load->model('MaLi/Factor_sell_model');
        $main_factor_id = $this->Factor_sell_model->add_factor_sell($id);
        if ($main_factor_id) {
            $this->system->message(_FACTOR_ADDED_SUC);
        } else {
            $this->system->message(_FACTOR_NOT_ADDED);
        }
        redirect("MaLi/factor_sell/manage_factor/main/" . post("level_id", true));
    }
}
