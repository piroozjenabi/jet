<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

class Kartable_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function list_refers($subject_id,$type=null)
    {
        $pf=$this->permission->check("auto_view_all");
        $user_id=$this->system->get_user();
        $this->db->select("*,auto_forms_value.id as mainid,auto_forms_value.form_id as f_id,auto_froms_refer.date as date ,auto_froms_refer.des as des,auto_froms_refer.id as id,auto_refer_subject.name as subject_name")
            ->from("auto_froms_refer")
            ->limit(200)
            ->order_by("auto_froms_refer.id", "DESC")
            ->join("auto_forms_value", "auto_froms_refer.form_value_id=auto_forms_value.id")
            ->join("auto_refer_subject", "auto_froms_refer.subject_id=auto_refer_subject.id");
        if($type=="exited") { $this->db->where("show", false);
        } else { $this->db->where("show", true);
        }
        if(!$pf) { $this->db->where("to_user_id", $user_id);//all refer can see in kartable
        }
        if($subject_id) { $this->db->where("subject_id", $subject_id);
        }
        return $this->db->get()->result_array();

    }
}
