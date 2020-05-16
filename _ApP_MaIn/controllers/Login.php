<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function index()
    {
        if ($this->system->checklogin()) {
            $this->system->gohome();
        }
        $this->template->load_login("login/index");
    }

    //check password and username
    function auth()
    {
        $username=$this->input->post("username", true);
        $password=$this->input->post("password", true);
        $id=$this->system->check_up($username, $password);
        if($id) {
            if($this->system->setlogin($username, $password, $id)) {
                $this->system->json_out(true);
            }

        }
        else {
            $this->system->json_out(false);
        }
    }
    //destroy sessions
    public function logout()
    {
        $this->session->sess_destroy();
        redirect("login");
    }
}
