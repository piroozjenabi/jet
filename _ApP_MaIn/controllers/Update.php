<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * update for cando
 */
class Update extends CI_Controller
{
    //TODO make check
    function index(){
        $this->load->library("Update_lib");
        $this->update_lib->check_update();

    }
    function doUpdate()
    {
        $this->load->library("Update_lib");
        $this->update_lib->do_update();
    }


}
?>
