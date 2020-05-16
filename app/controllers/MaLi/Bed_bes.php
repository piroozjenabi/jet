<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Bed_bes extends CI_Controller
{

    function ajax_get()
    {
        $arr=array();

        $arr["user_id"] = $this->input->post("user_id");
        $arr["factor_id"] =($this->input->post("factor_id"))? $this->input->post("factor_id"):"";
        $arr["group_id"] =($this->input->post("group_id"))? $this->input->post("group_id"):"0";

        //for edit
        if($this->input->post("id")) {
            $this->load->library("bed_beslib", "bed");
            $arr["detail"] =$this->bed_beslib->get($this->input->post("id"));
        }

        $this->template->load_popup("MaLi/Bed_bes/ajax_get", _PAY.__._CLIENT, $arr);

    }
    function ajax_getp($id=null)
    {
        $this->load->library("Bed_beslib");
        $group=$this->input->post("group_id", true);
        if(strtotime($this->input->post("datecheck", true)) >= time() ) {

            $message=_ALERT.__._CHECKOU.__.$this->system->get_user_from_id($this->input->post("user_id", true)).__.number_format($this->input->post("price", true));
            $users=$this->system->get_users_from_usergroup(json_decode($this->system->get_setting("def_usergroup_recive_checku_alert")));
            $this->alerts_lib->add_alert(4, array("price" =>$this->input->post("price", true),"user_id"=>$this->input->post("user_id", true),"date" =>strtotime($this->input->post("date", true))), strtotime($this->input->post("datecheck", true)), $message, $users);
            $group= ($group)?$group:$this->system->get_setting("deafult_checku_group");
        }
        else
        {
            $group= ($group)?$group:$this->system->get_setting("deafult_pay_client_group");
        }
        $checku=array();
        if($this->input->post("flagcheck")) {
            $group= $this->system->get_setting("deafult_checku_group");
            $checku["flagcheck"] = true;
            $checku["datecheck"] = strtotime($this->input->post("datecheck", true));
            $checku["bankcheck"] = $this->input->post("bankcheck", true);
            $checku["serialcheck"] = $this->input->post("serialcheck", true);
            $checku["branchcheck"] = $this->input->post("branchcheck", true);
            $checku["accnumbercheck"] = $this->input->post("accnumbercheck", true);
            $checku["reciverbankcheck"] = $this->input->post("reciverbankcheck", true);

        }
        $this->bed_beslib->padd($id, $this->input->post("price", true), $group, $this->input->post("user_id", true), $this->input->post("factor_id", true), $this->input->post("des", true), strtotime($this->input->post("date", true)), $checku);
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
