<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

class Refer_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function list_refers($subject_id)
    {
        $user_id=$this->system->get_user();
        $this->db->select("*,auto_forms_value.id as mainid,auto_froms_refer.date as date ,auto_froms_refer.params as params ,auto_froms_refer.des as des,auto_froms_refer.id as id,auto_refer_subject.name as subject_name")
            ->from("auto_froms_refer")
            ->where("from_user_id", $user_id)
            ->limit(200)
            ->order_by("auto_froms_refer.date", 'DESC')
            ->join("auto_forms_value", "auto_froms_refer.form_value_id=auto_forms_value.id")
            ->join("auto_refer_subject", "auto_froms_refer.subject_id=auto_refer_subject.id");
        if($subject_id) { $this->db->where("subject_id", $subject_id);
        }
        return $this->db->get()->result_array();

    }
}
