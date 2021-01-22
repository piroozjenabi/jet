<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * base project manager controller
 * @author pirooz jenabi <jenabi.pirooz@gmail.com>
 * @category jet cando
 */

class Project extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->language("project");
        $this->load->library("project_lib");
    }
    function manage(){
        $this->permission->check("project_manage", 0, 1);
        $user_id = $this->system->get_user();
        //load for data table
        $this->load->library("Crud");
        $this->crud->table = "project";
        $this->crud->title = _MANAGE_PROJECT;
        $this->crud->column_order = array("id", "name", "status", "des","point_date" ,"maker_id", "todo_date", "doing_date", "done_date");
        $this->crud->column_title = array(_ID, _NAME, _STATE, _DES,_POINT_DATE, _MAKER, _TODO, _DOING, _DONE,);
        $this->crud->column_require = array(2, 1, 2, 0,0,2,2,2,2,2);
        $this->crud->column_type = array("hide", "input", json_encode(["array",$this->project_lib->status_array]), "text","date", json_encode(["select_db","user_admin","name"]), "date","date","date");
        $this->crud->column_search = array("name","des");
        $this->crud->permision = ["add"=>false,"edit"=>true,"delete"=>true];
        $this->crud->form_add = ["maker_id" => $user_id];

        $this->crud->actions.= "<a class='btn btn-success' data-toggle='tooltip' title='" . _ADD.__._PROJECT . "' onclick=load_ajax_popup('". site_url("project/add")."','id=[[id]]') > <i class='fa fa-plus' ></i> " . _ADD.__._PROJECT . " </a>";;
       
        $tmp_url = site_url("Project/view");
        $this->crud->actions_row .= "<a class='btn btn-info' data-toggle='tooltip' title='" . _MANAGE . "' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-cog' ></i> </a>";;

        //media manager
        if ($this->permission->check("media_manage")) {
            $tmp_url = site_url("Media/manage/0/project");
            $this->crud->actions_row .= "<a class='btn btn-default' data-toggle='tooltip' title='" . _UPLOAD_MANAGER . "' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-upload' ></i> </a>";;
        }

        //comments manager
        if ($this->permission->check("project_comments")) {
            $tmp_url = site_url("Project/comments");
            $this->crud->actions_row .= "<a class='btn btn-default' data-toggle='tooltip' title='" . _COMMENT_MANAGER. "' onclick=load_ajax_popup('$tmp_url','id=[[id]]') > <i class='fa fa-comments' ></i> </a>";;
        }

        //todo list manager
        if ($this->permission->check("project_todo")) {
            $tmp_url = site_url("Project/todolist");
            $this->crud->actions_row .= "<a class='btn btn-default' data-toggle='tooltip' title='" . _TODO_MANAGER . "' onclick=load_ajax_popup('$tmp_url','id=[[id]]') > <i class='fa fa-list-ol' ></i> </a>";;
        }
        //view
        $this->crud->render();
    }

    function add(){
        $this->template->load_popup("project/add",_ADD.__._PROJECT);
    }

    function addp(){
        $this->load->model("Project_model");
        $res = $this->Project_model->add_project(post(null));
        jsonOut($res);
    }

    //main function for config and view project-----------------------------------------------------
    function view(){
        $id = post("id");
        $this->load->model("Project_model","model");
        $db=$this->model->get_project_full($id);
        $this->template->load_popup("project/view",_PROJECT_VIEW,["db"=>$db]);
    }

    function op_project($op,$id=0){
        if(!$id) $id=post("id");
        if(!$id) jsonOut(false);
        switch ($op){
            case "add_user":
                jsonOut($this->project_lib->add_user_project($id,post("user")));
            break;    
            case "add_prd":
                jsonOut($this->project_lib->add_prd_project($id,post("prd")));
            break;    
            case "add_company":
                jsonOut($this->project_lib->add_company_project($id,post("company")));
            break;
            case "set_status":
                jsonOut($this->project_lib->set_status_project($id,post("status")));
            break;

            default:jsonOut(false);break;
        }


    }

    //for comments-----------------------------------------------------
    function comments(){
        $id = post("id", true);
        $db = $this->project_lib->list_comments(["project_id" => $id]);
        $msg = [];
        //add 
        if (post("comment")) {
            $flg = $this->project_lib->add_comment([
                "comment" => post("comment"),
                "project_id" => $id,
                "maker_id" => $this->system->get_user()
            ]);
            if ($flg) $msg = [true, _SUC_OP];
            else $msg = [false, _NO_SUC_OP];
            jsonOut(["status" => 2, "body" => $this->load->view("project/comments", ["db" => $db, "msg" => $msg, "id" => $id], true)]);
        }
        $this->template->load_popup("project/comments", _COMMENTS_MANAGER, ["db" => $db, "msg" => $msg, "id" => $id]);

    }

    function list_todo(){
        $this->permission->check("project_todo", 0, 1);
        $user_id=$this->system->get_user();
        //load for data table
        $this->load->library("Crud");
        $this->crud->table="project_todo";
        $this->crud->title=_TODO_MANAGER;
        $this->crud->column_order=array("id","name","des","date","project_id","to_user","maker_id");
        $this->crud->column_title=array(_ID,_NAME,_DES,_DATE,_PROJECT,_USER,_MAKER);
        $this->crud->column_require=array(2,1,0,0,0,0,0);
        $tmp_selectdb=array("select_db","user_admin","name");
        $tmp_selectdb2=array("select_db","user_admin","name");
        $tmp_selectdb3=array("select_db","project","name");
        $this->crud->column_type=array("hide","input","input","date",json_encode($tmp_selectdb3),json_encode($tmp_selectdb),json_encode($tmp_selectdb2));
        $this->crud->column_search=array("name","des");
        $this->crud->permision=["add"=>false,"edit"=>true,"delete"=>true];
        $this->crud->form_add=["maker_id"=>$user_id];
        $this->crud->render();
    }
    //list of comments-----------------------------------------------------
    function list_comments(){
        $this->permission->check("project_comments", 0, 1);
        $user_id=$this->system->get_user();
        //load for data table
        $this->load->library("Crud");
        $this->crud->table="project_comments";
        $this->crud->title=_COMMENTS_MANAGER;
        $this->crud->column_order=array("id","comment","date","project_id","maker_id");
        $this->crud->column_title=array(_ID,_COMMENT,_DATE,_PROJECT,_MAKER);
        $this->crud->column_require=array(2,1,0,0,0);
        $tmp_selectdb2=array("select_db","user_admin","name");
        $tmp_selectdb3=array("select_db","project","name");
        $this->crud->column_type=array("hide","text","date",json_encode($tmp_selectdb3),json_encode($tmp_selectdb2));
        $this->crud->column_search=array("comment");
        $this->crud->permision=["add"=>true,"edit"=>true,"delete"=>true];
        $this->crud->form_add=["maker_id"=>$user_id];
        $this->crud->render();
    }
    //for to list-----------------------------------------------------
    function todolist(){
        $this->permission->check("project_todo", 0, 1);
        $id = post("id", true);
        $db = $this->project_lib->list_todo(["project_id"=>$id]);
        $msg=[];
        //add 
        if(post("todo")){
            $flg = $this->project_lib->add_todo([
                "name"=> post("todo"),
                "project_id" => $id,
                "maker_id" => $this->system->get_user()    
            ]);
            if($flg) $msg = [true,_SUC_OP];
            else $msg = [false, _NO_SUC_OP];
            jsonOut(["status"=>2,"body"=>$this->load->view("project/todo", ["db" => $db, "msg" => $msg, "id" => $id], true)]);
        }
        $this->template->load_popup("project/todo", _TODO_MANAGER, ["db" => $db, "msg" => $msg, "id" => $id]);

        
    }
    //list of operation todo-----------------------------------------------------
    function op_todo($op,$id){
        $this->permission->check("project_todo", 0, 1);
        switch ($op) {
            case 'done':
                jsonOut($this->project_lib->set_todo_done($id)) ;
            break;
            case 'delete':
                jsonOut($this->project_lib->delete_todo($id)) ;
            break;
            case 'view':
                // jsonOut(["status"=>2,"body"=>$this->project_lib->view($id)]) ;
            break;
        }

    }

}