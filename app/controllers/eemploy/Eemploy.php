<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Eemploy extends CI_Controller
{
    // list of manage  eemploy user
    function manage()
    {

        $this->load->helper("form");

        $user_id=$this->system->get_user();
        //load for data table
        $this->load->library("Crud");
        $this->load->library("Piero_jdate");
        $this->crud->table="user_admin";
        $this->crud->title=_MANAGE_EEMPLOYS;
        $this->crud->column_order=array("state","meli_id","name","username","mobile","usergroup","birthday","extra");
        $this->crud->column_title=array(_STATE,_MELI_ID,_NAME,_USERNAME,_MOBILE,_GROUP,_BIRTH,_ACCOUNT_NUMBER_BANK);
        $this->crud->column_require=array(1,1,1,1,1,1,0,0);
        $tmp_selectdb=array("select_db","usergroup_eemploy","name");
        $this->crud->column_type=array("bool","input","input","input","input",json_encode($tmp_selectdb),"date",'input');
        $this->crud->column_search=array("name","meli_id","username");
        $this->crud->permision=$this->crud->render_permsion_crud("eemploy");
        if($this->crud->permision["edit"]) {
            $this->crud->actions_row = "<a class='btn btn-default' data-toggle='tooltip' title='{_EDIT_FULLL}' onclick=load_ajax_popup('".site_url("eemploy/eemploy/edit/")."','id=[[id]]')><i class='fa fa-edit' ></i></a>" ;
        }
        if($this->permission->check("media_manage")){
            $tmp_url= site_url("Media/manage/0/rival");
            $this->crud->actions_row .= "<a class='btn btn-default' data-toggle='tooltip' title='"._UPLOAD_MANAGER."' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-upload' ></i> </a>";;
          }
        //        $this->crud->form_add=form_hidden("maker_id",$user_id).form_hidden("date_create",time());
        $this->crud->form_add=["maker_id"=>$user_id,"date_create"=>time()];
        $this->crud->actions= "<a class='btn btn-info  ' href='".site_url("eemploy/eemploy_user_group/manage")."' > <i class='fa fa-users' ></i>" . _MANAGE_USER_GROUP_EMPLOY. ' </a>';;
        $this->crud->render();
    }
    //edit user full edit
    function edit()
    {
        @$this->permission->check("eemploy_edit", true);
        $this->load->model('eemploy/eemploy_model');
        $ret=$this->eemploy_model->edit_user(post("id", true));
        $this->template->load_popup('eemploy/add_p_users', _EDIT_FULLL, array("detail_user" => $ret));
    }
    function pedit()
    {
        $id=post("id", true);
        $this->permission->check("eemploy_edit", 0, 1);
        $this->load->model('eemploy/eemploy_model');
        jsonOut((bool)$this->eemploy_model->add_users($id));
    }


}
