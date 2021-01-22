<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function index()
    {
        
        if ($this->system->checkLogin()) {
             $this->system->goHome();
        }
        $this->template->loadLogin("login/index");
    }

    /**
     * check password and username
     */
    function auth()
    {
        return jsonOut((bool) $this->system->validate(post("username"), post("password")) );
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        return redirect("login");
    }
}
