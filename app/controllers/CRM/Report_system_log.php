<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Report_system_log extends CI_Controller
{
    function index()
    {
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        //for persian time
        $this->load->library('Piero_jdate');
        if(post("date_start")) {
            $def_time_start=post("date_start", true);
        } else {
            $def_time_start=printDate("Y/m/d");
        }
        //convert persian number to english
        $def_time_start= str_replace($persian, $num, $def_time_start);

        //date end
        if(post("date_end")) {
            $def_time_end=post("date_end", true);
        } else {
            $def_time_end=printDate("Y/m/d", time() + (7 * 24 * 60 * 60));
        }
        //convert persian number to english
        $def_time_end= str_replace($persian, $num, $def_time_end);

        $this->load->model("CRM/Report_system_log_model");

        $result= $this->Report_system_log_model->list_report_system_log();

        $this->load->library('table');
        $tmpl = array ( 'table_open'  => '<table class=" table table-hover table-striped dataTbl" >' );
        $this->table->set_template($tmpl);
        $this->load->library('Piero_jdate');
        foreach ($result->result_array() as $key => &$value) {

            $value[_DATE]=printDate("Y/m/d", $value[_DATE])." ".date("H.m.s", $value[_DATE]);


        }
        $table_list= $this->table->generate($result);
        $data = array('table_list' => $table_list,'def_time_start' => $def_time_start,'def_time_end' => $def_time_end  );

        loadV("CRM/report/report_system_log", $data);

    }
}

?>
