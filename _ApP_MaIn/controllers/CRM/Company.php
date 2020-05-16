<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->language("crm_lang");
  }

  function manage()
  {
    $this->load->library("Crud");
    $this->crud->table="crm_company";
    $this->crud->title=_MANAGE_COMPANY;
    $this->crud->column_order=array("state","name","group_ref","country_ref","des");
    $this->crud->column_title=array(_STATE,_NAME,_GROUP,_COUNTRY,_DES);
    $this->crud->column_require=array(1,1,1,0,0);
    $this->crud->column_filter=array(1,1,1,1,1);
    $this->crud->column_type=array("bool","input",json_encode(["select_db","crm_company_group","name"]),json_encode(["select_db","country","name"]),"text");
    $this->crud->column_search=array("name");
    $this->crud->actions = "<a class='btn btn-info  ' href='".site_url("CRM/Company/manage_group")."' > <i class='fa fa-users' ></i>" . _MANAGE_GROUPS. ' </a>';;
    $this->crud->actions.= "<a class='btn btn-info  ' href='".site_url("Setting/manage_country")."' > <i class='fa fa-users' ></i>" . _MANAGE_COUNTRIES. ' </a>';;
    if($this->permision->check("media_manage")){
      $tmp_url= site_url("Media/manage/0/company");
      $this->crud->actions_row .= "<a class='btn btn-default' data-toggle='tooltip' title='"._UPLOAD_MANAGER."' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-upload' ></i> </a>";;
    }
    $this->crud->render();
  }

  function manage_group()
  {
    $this->load->library("Crud");
    $this->crud->table="crm_company_group";
    $this->crud->title=_MANAGE_COMPANY_GROUP;
    $this->crud->column_order=array("name","des");
    $this->crud->column_title=array(_NAME,_DES);
    $this->crud->column_require=array(1,0);
    $this->crud->column_type=array("input","text");
    $this->crud->column_search=array("name");
    $this->crud->actions= "<a class='btn btn-info  ' href='".site_url("CRM/Company/manage")."' > <i class='fa fa-users' ></i>" . _MANAGE_COMPANY. ' </a>';;
    $this->crud->render();
  }


}
