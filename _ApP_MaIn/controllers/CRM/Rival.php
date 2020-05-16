<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Rival extends  CI_Controller
{
    function manage()
    {
        $this->permision->check("rival_manage", 0, 1);
        $this->load->helper("form");
        $user_id=$this->system->get_user();
        //load for data table
        $this->load->library("Crud");
        $this->crud->table="crm_rival_prd";
        $this->crud->title=_MANAGE_RIVALS;
        $this->crud->column_order=array("brand","prd_name","group_rival_prd","prd_country","prd_company","prd_price","prd_realated","prd_website","prd_contact");
        $this->crud->column_title=array(_BRAND,_PRD,_GROUP_PRD,_PRD_COUNTRY,_COMPANY,_PRICE,_PRD_RELATED,_WEB,_PRD_CONTACT);
        $this->crud->column_require=array(1,1,1,0,0,1,0,0,0);
        $tmp_selectdb=array("select_db","prd","name");
        $tmp_selectdb2=array("select_db","prd_group","name");
        $this->crud->column_type=array("input","input",json_encode($tmp_selectdb2),"input","input","input",json_encode($tmp_selectdb),'input','input');
        $this->crud->column_search=array("brand","prd_name","prd_country","prd_company","prd_website","prd_contact");
        $this->crud->permision=$this->crud->render_permsion_crud("rival");
        $this->crud->form_add=["maker_id"=>$user_id,"date"=>time()];
        $this->crud->actions= "<a class='btn btn-info  ' href='".site_url("MaLi/pprd/prd/manage_group")."' > <i class='fa fa-users' ></i>" . _MANAGE_PRD_GROUP. ' </a>';;
        if($this->permision->check("media_manage")){
            $tmp_url= site_url("Media/manage/0/rival");
            $this->crud->actions_row .= "<a class='btn btn-default' data-toggle='tooltip' title='"._UPLOAD_MANAGER."' onclick=load_ajax_popupfull('$tmp_url','id=[[id]]') > <i class='fa fa-upload' ></i> </a>";;
          }
        $this->crud->render();
    }


}
