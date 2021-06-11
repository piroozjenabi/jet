<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Report_main extends CI_Controller
{
    function index($form_id=null,$state_refer=1)
    {

        if(!$form_id) {
            loadV("AUTO/report/report_main", array("form_id"=>$form_id));
        } else
        {
            $this->load->model("AUTO/Report_model", "model");
            $this->load->library("Auto");
            $this->load->library("Report_auto", array(0=>$form_id));
            //fetch setting
            $name_en=$this->auto->render_name_en($form_id);
            $this->model->render_base($form_id);
            $this->report_auto->table=$name_en;
            $this->report_auto->column_order=$this->model->column_order;
            $this->report_auto->column_title=$this->model->column_title;
            $this->report_auto->column_type=$this->model->column_type;
            $this->report_auto->column_search=$this->model->column_search;
            $this->report_auto->column_params=$this->model->column_params;
            $this->report_auto->order=array("$name_en.id" => 'DESC');
            $this->report_auto->join=array("auto_forms_value","$name_en.form_value_id=auto_forms_value.id");
            $this->report_auto->join2=array("auto_froms_refer","$name_en.form_value_id=auto_froms_refer.form_value_id");
            if($state_refer==-1) {
                $this->report_auto->where="auto_froms_refer.state >= 0";
            } else {
                $this->report_auto->where="auto_froms_refer.state=$state_refer";
            }
            $this->report_auto->render("AUTO/report/report_main");
        }
    }
}
