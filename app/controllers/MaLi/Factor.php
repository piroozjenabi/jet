<?php defined('BASEPATH') or exit('No direct script access allowed');
class Factor extends CI_Controller
{
    ###############################################add factor
    public function add($id=null)
    {
        $this->load->model('MaLi/Factor_sell_model');
        if(post("user")){
            $res = $this->Factor_sell_model->add_factor_sell($id);
            if ($res) {
                $this->system->message(_FACTOR_ADDED_SUC);
            } else {
                $this->system->message(_FACTOR_ADDED_FAIL);
            }
            redirect("MaLi/factor_sell/manage_factor/main/", true);
        } else{
            $additions=$this->Factor_sell_model->getAdditions(); //get list of incement of factor
            loadV('MaLi/factor_sell/add_main',["additions"=>$additions], ["title" => _ADD_FACTOR]);
        }
    }
    ###############################################manage factor
    public function manage(){
        $this->load->model('MaLi/Factor_sell_model');
        $result= $this->Factor_sell_model->manage();
        dd($result);

    }


}