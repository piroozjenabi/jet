<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax extends CI_Controller
{
    /**
     * editable text input
     */
    public function save_edit_text()
    {
        $params=json_decode(str_rot13(post("id")));
        $this->load->model("Ajax_model");
        $this->Ajax_model->set_text_edit($params->pg, $params->id, $params->field);
        $value=post("value");
        echo   $value ;
    }

    public function load_edit_text($pg)
    {
        echo  "jetcando.ir";
    }
}
