<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

class Prd_commision extends CI_Controller
{
    //list of product with commision
    public function index()
    {
        $this->load->model('MaLi/Prd_commision_model');
        $res=$this->Prd_commision_model->listall();
        $this->template->load2("MaLi/prds/prd_commision", array("res"=>$res));


    }





}

?>
