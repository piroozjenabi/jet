<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * Date: 6/26/16
 * Time: 3:01 PM
 */
class Ajax extends CI_Controller
{
    //editable text input
    public function save_edit_text()
    {
        $params=json_decode(str_rot13($this->input->post("id", true)));
        $this->load->model("Ajax_model");
        $this->Ajax_model->set_text_edit($params->pg, $params->id, $params->field);
        $value=$this->input->post("value", true);
        echo   $value ;
    }

    public function load_edit_text($pg)
    {
        echo  "jetcando.ir";
    }
}
