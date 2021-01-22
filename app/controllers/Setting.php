<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends CI_Controller
{
    //manage page for setting
    public function index()
    {
        $this->permission->check("base_setting", 0, 1);
        $this->load->model("Setting_model");
        $res=$this->Setting_model->manage_group();
        $this->template->load("setting_group_view", array("db"=>$res));
    }

    public function manage($group=null)
    {
        $this->permission->check("base_setting", 0, 1);
        $this->load->model("Setting_model");
        $res=$this->Setting_model->manage($group);
        $this->template->load_popup("setting_view", _EDIT.__._ADVANCED_SETTING, array("db"=>$res));
    }

    //ajax manage country
    public function manage_country(){
      $this->load->library("Crud");
      $this->crud->table="country";
      $this->crud->title=_MANAGE_COUNTRIES;
      $this->crud->column_order=array("name","code","des");
      $this->crud->column_title=array(_NAME,_CODE,_DES);
      $this->crud->column_require=array(1,0,0);
      $this->crud->column_type=array("input","input","text");
      $this->crud->column_search=array("name","des","code");
      $this->crud->render();
    }
}
