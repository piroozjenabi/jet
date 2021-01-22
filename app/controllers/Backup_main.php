<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Backup_main extends CI_Controller
{
    function index()
    {
        $this->permission->check("base_backup", 0, 1);
        $this->load->library("Backup_lib");
        $this->backup_lib->db_bkp();
        $this->system->message(_SUC_OP);
        redirect("dashboard");
    }

    function restore(){
        
    }
}
