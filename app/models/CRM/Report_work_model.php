<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Report_work_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function add_report_work()
    {
        for ($i=1;$i<=count(post("name", true));$i++) {

            $data["id"] = "";
            $data["user_id"] = $this->system->get_user();
            $data["date"] = time();
            $data["des"] = post("name", true)[$i];


            if($data["des"] != null) {
                $res_data2[$i]=$this->db->insert('user_employ_report', $data);
            }

        }
    }

    function list_report_work()
    {
        $user_id=$this->system->get_user();
        $this->db->select(array( " user.name as "._NAME." "._USER ,"user_employ_report.des as "._REPORT,"user_employ_report.date as "._DATE ));
        $this->db->from('user_employ_report');
        $this->db->join('user', 'user.id=user_employ_report.user_id');
        if($user_id != 16) {
            $this->db->where("user_employ_report.user_id", $user_id);
        }

        if(post("user", true) >0  ) {
            $this->db->where("user.id", post("user", true));
        }

        if(post("dateh_start", true)   ) {
            $date_rendered_start=strtotime(post("dateh_start"));
            $date_rendered_end=strtotime(post("dateh_end"));

                $this->db->where("user_employ_report.date >", $date_rendered_start);
                $this->db->where("user_employ_report.date <", $date_rendered_end);


        }
        $this->db->limit(100);
        $this->db->order_by('user_employ_report.date', 'DESC');
        return $this->db->get();

    }
}
