<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Time: 3:01 PM
 */
class Bed_bes extends CI_Controller
{

    function ajax_get()
    {
        $arr=array();

        $arr["user_id"] = post("user_id");
        $arr["factor_id"] =(post("factor_id"))? post("factor_id"):"";
        $arr["group_id"] =(post("group_id"))? post("group_id"):"0";

        //for edit
        if(post("id")) {
            $this->load->library("bed_beslib", "bed");
            $arr["detail"] =$this->bed_beslib->get(post("id"));
        }

        $this->template->load_popup("MaLi/Bed_bes/ajax_get", _PAY.__._CLIENT, $arr);

    }
    function ajax_getp($id=null)
    {
        $this->load->library("Bed_beslib");
        $group=post("group_id", true);
        if(strtotime(post("datecheck", true)) >= time() ) {

            $message=_ALERT.__._CHECKOU.__.$this->system->get_user_from_id(post("user_id", true)).__.number_format(post("price", true));
            $users=$this->system->get_users_from_usergroup(json_decode($this->system->get_setting("def_usergroup_recive_checku_alert")));
            $this->alerts_lib->add_alert(4, array("price" =>post("price", true),"user_id"=>post("user_id", true),"date" =>strtotime(post("date", true))), strtotime(post("datecheck", true)), $message, $users);
            $group= ($group)?$group:$this->system->get_setting("deafult_checku_group");
        }
        else
        {
            $group= ($group)?$group:$this->system->get_setting("deafult_pay_client_group");
        }
        $checku=array();
        if(post("flagcheck")) {
            $group= $this->system->get_setting("deafult_checku_group");
            $checku["flagcheck"] = true;
            $checku["datecheck"] = strtotime(post("datecheck", true));
            $checku["bankcheck"] = post("bankcheck", true);
            $checku["serialcheck"] = post("serialcheck", true);
            $checku["branchcheck"] = post("branchcheck", true);
            $checku["accnumbercheck"] = post("accnumbercheck", true);
            $checku["reciverbankcheck"] = post("reciverbankcheck", true);

        }
        $this->bed_beslib->padd($id, post("price", true), $group, post("user_id", true), post("factor_id", true), post("des", true), strtotime(post("date", true)), $checku);
        $this->system->message(_SUC_OP);
        redirect("CRM/my_client/acounting");

    }
    //delete
    function del($id)
    {
        $this->load->library("bed_beslib");
        $this->bed_beslib->del($id);
        $this->system->message(_SUC_OP);
        redirect("CRM/my_client/acounting");
    }

    //enable or disable
    function en_dis($id)
    {
        $this->load->library("bed_beslib");
        $this->bed_beslib->en_dis($id);
        $this->system->message(_SUC_OP);
        redirect("CRM/my_client/acounting");
    }

    function list_checks()
    {
        //load for data table
        $this->load->library("Crud");
        $this->crud->table="mali_bed_bes";
        $this->crud->title=_VIEW.__._CHECKOU._S;
        $this->crud->column_order=array("user_id","des","price","date","params");
        $this->crud->column_title=array(_NAME.__._CLIENT,_DES,_PRICE._R,_DATE,_DATE.__._CHECKOU);
        $this->crud->column_type=array("client","input","number","date","json");
        $this->crud->column_require=array(1,1,1,1,0);
        $this->crud->column_search=array("user.name","price","des");
        $this->crud->order=array("mali_bed_bes.id"=>"asc");
        $this->crud->permision=array("add"=>false,"edit"=>false,"delete"=>"false");
        $this->crud->where="group_id=8";
        $this->crud->join[]=array("user","mali_bed_bes.user_id=user.id");
        $this->crud->render("karkoshte/job_list");


    }
}
