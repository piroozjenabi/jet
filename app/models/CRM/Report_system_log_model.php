<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Report_system_log_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }



    function list_report_system_log()
    {
        $user_id=$this->system->get_user();
        $this->db->select(array( " user.name as "._NAME." "._USER ,"log.url as "._ADDRESS,"log.time as "._DATE,"log.ip as "._IP,"log.AGENT as "._SYSTEM_INFO,"log.post as "._POST ));
        $this->db->from('log');
        $this->db->join('user', 'user.id=log.user_id');
        if($user_id != 16) {
            $this->db->where("log.user_id", $user_id);
        }

        if(post("user", true) >0  ) {
            $this->db->where("user.id", post("user", true));
        }

        if(post("dateh_start", true)   ) {
            $date_rendered_start=strtotime(post("dateh_start"));
            $date_rendered_end=strtotime(post("dateh_end"));

                $this->db->where("log.time >", $date_rendered_start);
                $this->db->where("log.time <", $date_rendered_end);


        }
        $this->db->limit(100);
        $this->db->order_by('log.time', 'DESC');
        return $this->db->get();

    }
}
