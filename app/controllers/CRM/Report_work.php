<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Report_work extends CI_Controller
{

    function index()
    {

    }

    function report_add()
    {
        $this->template->load("CRM/report/report_add");
    }

    function add_report_work_submit()
    {
        $this->load->model("CRM/Report_work_model");
        $this->Report_work_model->add_report_work();
        $this->system->message(_REPORTS._ADDED);
        redirect("/CRM/Report_work/report_list");
    }

    function report_list()
    {
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        //for persian time
        $this->load->library('Piero_jdate');
        if(post("date_start")) {
            $def_time_start=post("date_start", true);
        } else {
            $def_time_start=$this->piero_jdate->jdate("Y/m/d");
        }
        //convert persian number to english
        $def_time_start= str_replace($persian, $num, $def_time_start);

        //date end
        if(post("date_end")) {
            $def_time_end=post("date_end", true);
        } else {
            $def_time_end=$this->piero_jdate->jdate("Y/m/d", time() + (7 * 24 * 60 * 60));
        }
        //convert persian number to english
        $def_time_end= str_replace($persian, $num, $def_time_end);

        $this->load->model("CRM/Report_work_model");

        $result= $this->Report_work_model->list_report_work();

        $this->load->library('table');
        $tmpl = array ( 'table_open'  => '<table class=" table table-hover table-striped" data-toggle="table" >' );
        $this->table->set_template($tmpl);
        $this->load->library('Piero_jdate');




        foreach ($result->result_array() as $key => &$value) {

            $value[_DATE]=$this->piero_jdate->jdate("Y/m/d", $value[_DATE]);


        }
        $table_list= $this->table->generate($result);
        $data = array('table_list' => $table_list,'def_time_start' => $def_time_start,'def_time_end' => $def_time_end  );

        $this->template->load("CRM/report/report_list", $data);

    }
}

?>
