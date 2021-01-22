<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Eemploy_user_group extends CI_Controller
{

    function manage($parent=null)
    {
        $this->permission->check("eemploy_permision", 0, 1);
        //load for data table
        $this->load->library("Crud");
        $this->crud->table="tbl_usergroup_eemploy";
        $this->crud->title=_MANAGE_USER_GROUP_EMPLOY;
        $this->crud->column_order=array("name","state","parent");
        $this->crud->column_title=array(_NAME,_STATE,_VALED);
        $this->crud->column_require=array(1,0,0);
        $tmp_selectdb=array("select_db","tbl_usergroup_eemploy","name");
        $this->crud->column_type=array("input","bool",json_encode($tmp_selectdb));
        $this->crud->column_search=array("name");
        if($this->permission->check("eemploy_permision")) {
            $tmp_url                 = site_url("eemploy/eemploy_user_group/manage_permision/" . '[[id]]');
            $this->crud->actions_row = "<a class='btn btn-warning' data-toggle='tooltip' title='{_PERMISION}'  onclick=load_ajax_popupfull('$tmp_url','id=[[id]]')> <i class='fa fa-lock' ></i> </a>";
        }
        $this->crud->actions= "<a class='btn btn-info  ' href='".site_url("/eemploy/eemploy/manage")."' > <i class='fa fa-user-md' ></i>" . _MANAGE.__._EMPLOYs. ' </a>';;
        if($parent) { $this->crud->where="parent=".$parent;
        }
        $this->crud->render();
    }

    //    ---------------------------------permisioion
    //manage user group permision
    public function change_permision($id)
    {
        $this->permission->check("eemploy_permision", 0, 1);
        $this->load->model('eemploy/eemploy_model');
        jsonOut((bool)$this->eemploy_model->chnage_permision($id));
    }
    public function manage_permision($id)
    {
        $this->permission->check("eemploy_permision", 0, 1);
        $this->template->load_popup("BasE/Permision/manage_permision", _MANAGE.__._PERMISION, array("user_group_id" => $id));
    }
}
