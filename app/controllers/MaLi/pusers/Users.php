<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Users extends CI_Controller
{

    // list of manage
    function manage()
    {
        $this->load->helper("form");
        $user_id=$this->system->get_user();
        $my_id=$this->system->get_user();
        //load for data table
        $this->load->library("Crud");
        $this->crud->table="user";
        $this->crud->title=_MANAGE_CLIENTS;
        $this->crud->column_order=array("state","name","tell","mobile","usergroup","parent","birth");
        $this->crud->column_title=array(_STATE,_NAME,_TELL,_MOBILE,_GROUP,_PARENT,_BIRTH);
        $this->crud->column_require=array(1,1,1,0,0,0,0,0);
        $this->crud->column_list=array(1,1,0,0,1,0,0);
        $this->crud->where="maker_id=$my_id";
        $tmp_selectdb=array("select_db","user","name");
        $tmp_selectdb2=array("select_db","usergroup","name");
        $this->crud->column_type=array("bool","input","input","input","input","input",json_encode($tmp_selectdb2),json_encode($tmp_selectdb),"date");
        $this->crud->column_search=array("name","comerical_id","agent","tell");
        $this->crud->form_add=["maker_id"=>$user_id,"date_create"=>time()];
        $this->crud->permission=$this->crud->render_permsion_crud("user");
        if($this->crud->permission["edit"]) {
            $tmp_url= site_url("MaLi/pusers/users/edit/" . '[[id]]');
            $this->crud->actions_row = "<a class='btn btn-default' data-toggle='tooltip' title='{_EDIT_FULLL}'  onclick=load_ajax_popupfull('".$tmp_url."','id=[[id]]') > <i class='fa fa-edit' ></i> </a>";;
        }
        if($this->permission->check("media_manage")){
            $tmp_url= site_url("Media/manage/0/user");
            $this->crud->actions_row .= "<a class='btn btn-default' data-toggle='tooltip' title='"._UPLOAD_MANAGER."' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-upload' ></i> </a>";;
          }
        $this->crud->actions= "<a class='btn btn-info  ' href='".site_url("MaLi/pusers/users/manage_usergroup")."' > <i class='fa fa-users' ></i>" . _MANAGE_GROUPS. ' </a>';;
        $this->crud->render();
    }
    //list of all user
    function manage_all()
    {
        $this->load->helper("form");
        $user_id=$this->system->get_user();
        $this->permission->check("user_view_all", 0, 1);
        $this->load->library("Crud");
        $this->crud->table="user";
        $this->crud->title=_MANAGE_CLIENTS;
        $this->crud->column_order=array("id","state","vip","date","name","tell","mobile","usergroup","parent","price","birth");
        $this->crud->column_title=array(_ID,_STATE,_VIP,_DATE_CREATE,_NAME,_TELL,_MOBILE,_GROUP,_PARENT,_PRICE,_BIRTH);
        $this->crud->column_require=array(0,1,0,2,1,0,0,1,0,0,0,0,0);
        $this->crud->column_filter=array(1,1,1,0,1,1,1,1,0,1);
        $this->crud->column_list=array("id","state","vip","name","tell","usergroup");
        $tmp_selectdb=array("select_db","user","name");
        $tmp_selectdb2=array("select_db","usergroup","name");
        $this->crud->column_type=array("hide","bool","boolYN","date","input","input","input",json_encode($tmp_selectdb2),json_encode($tmp_selectdb),"input","date");
        $this->crud->column_search=array("name","comerical_id","agent","tell");
        $this->crud->form_add=["maker_id"=>$user_id];
        $this->crud->permission=$this->crud->render_permsion_crud("user");
        if($this->crud->permission["edit"]) {
            $tmp_url                 = site_url("MaLi/pusers/users/edit/");
            $this->crud->actions_row = "<a class='btn btn-default' data-toggle='tooltip' title='"._EDIT_FULLL."' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-edit' ></i> </a>";;
        }
        if($this->permission->check("media_manage")){
          $tmp_url= site_url("Media/manage/0/user");
          $this->crud->actions_row .= "<a class='btn btn-default' data-toggle='tooltip' title='"._UPLOAD_MANAGER."' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-upload' ></i> </a>";;
        }
        $this->crud->actions= "<a class='btn btn-info  ' href='".site_url("MaLi/pusers/users/manage_usergroup")."' > <i class='fa fa-users' ></i>" . _MANAGE_GROUPS. ' </a>';;
        $this->crud->render();
    }
    //edit user full edit
    function edit()
    {
        $this->permission->check("user_edit", 0, 1);
        $this->load->model('MaLi/Users_model');
        $ret=$this->Users_model->edit_user(post("id", true));
        $this->template->load_popup('MaLi/users/add_p_users', _EDIT_FULLL.__._USER, array("detail_user" => $ret));
    }
    function pedit()
    {
        $this->permission->check("user_edit", 0, 1);
        $id=post("id", true);
        $this->load->model('MaLi/Users_model');
        jsonOut((bool)$this->Users_model->pedit_user($id));
    }

    //list of all user group
    function manage_usergroup()
    {
        $this->permission->check("user_view_all", 0, 1);
        $this->load->library("Crud");
        $this->crud->table="usergroup";
        $this->crud->title=_MANAGE_GROUPS;
        $this->crud->column_order=array("state","name","parent");
        $this->crud->column_title=array(_STATE,_NAME,_VALED);
        $this->crud->column_require=array(1,1,0);
        $tmp_selectdb=array("select_db","usergroup","name");
        $this->crud->column_type=array("bool","input",json_encode($tmp_selectdb));
        $this->crud->column_search=array("name");
        //        $this->crud->permission=$this->crud->render_permsion_crud("user");
        $this->crud->actions= "<a class='btn btn-info  ' href='".site_url("MaLi/pusers/users/manage")."' > <i class='fa fa-users' ></i>" . _MANAGE_CLIENTS. ' </a>';;
        $this->crud->render();
    }

    //show details for ajazx popup
    public function show_details()
    {
        $id=post("id", true);
        $this->load->model('MaLi/users_model');
        $ret=$this->users_model->edit_user($id);
        $this->template->load_popup("MaLi/users/show_details", _FULL_INVOICE, array("detail_users" => $ret,"user_id" => $id,"other_pay" =>""));
    }

    //show details for bill popup
    public function show_bill()
    {
        $id=post("id", true);
        $this->load->model('MaLi/users_model');
        $ret=$this->users_model->edit_user($id);
        $this->template->load_popup("MaLi/users/show_bill", _FULL_INVOICE, array("detail_users" => $ret,"user_id" => $id,"other_pay" =>""));

    }

    //upload manager
    public function uploadManager($id=null)
    {
      // $this->permission->check("user_upload",0,1);
      $this->load->view("fileManager");
    }
}
