<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Kartable extends CI_Controller
{

    public function index($subject_id=0,$type=null)
    {
        $this->load->library("auto");
        $this->load->model("AUTO/kartable_model");
        $res = $this->kartable_model->list_refers($subject_id, $type);
        $this->template->load("AUTO/kartable/kartable_view", ["forms" => $res ,"subject_id"=>$subject_id ,"type"=>$type]);

    }
}
