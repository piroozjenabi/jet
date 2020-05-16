<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Bed_beslib
{

    public function padd($id,$price,$group_id,$user_id,$factor_id,$des="",$date=0,$params=array())
    {
//        if date not enteref now
        $date = ($date) ? $date : time();
        $CI =& get_instance();
        $data = array("price" => $price
        , "group_id" => $group_id
        , "date_enter" => time()
        , "date" => $date
        , "des" => $des
        , "user_id" => $user_id
        , "factor_id" => $factor_id
        , "maker_id" => $CI->system->get_user());
        if ($params)
            $data["params"]  = json_encode($params);


        $CI->permision->check("base_accounting", 0, 1);
//        if edit
        if ($id) {
            $CI->db->where("id",$id);
            return  $res=$CI->db->update('mali_bed_bes',$data);
                }
            else
        return $CI->db->insert("mali_bed_bes",$data);
    }
//delete fron bed bes
    function del($id)
    {
        $CI =& get_instance();
        $CI->permision->check("base_accounting", 0, 1);
        $CI->db->where('id',$id);
        return 	$CI->db->delete('mali_bed_bes');
    }

    //get
    public function get($id)
    {
        $CI =& get_instance();
        $CI->db->select("*");
        $CI->db->from("mali_bed_bes");
        $CI->db->where("id",$id);
        return $CI->db->get()->result_array()[0];
    }

    // list of bed group
    function get_bed_usergroups($where=null)
    {
        $CI =& get_instance();
        $CI->db->select("*");
        $CI->db->from("mali_bed_bes_group");
        $CI->db->where("bed",1);
        if($where)$CI->db->where($where);
        return $CI->db->get()->result_array();
    }    // list of bes group
    function get_bes_usergroups($where=null)
    {
        $CI =& get_instance();
        $CI->db->select("*");
        $CI->db->from("mali_bed_bes_group");
        $CI->db->where("bes",1);
        if($where)$CI->db->where($where);
        return $CI->db->get()->result_array();
    }
//get bed user total
    public function get_user_bed($user_id,$start,$end)
    {

        $groups=$this->get_bed_usergroups();
        $CI =& get_instance();
        $CI->db->select_sum("price");
        $CI->db->from("mali_bed_bes");
        $CI->db->where("enable",true);
        $tmp_where="(";
        foreach ( $groups as $k => $v)
            $tmp_where.="group_id = ".$v["id"]." OR ";
        $tmp_where=(substr($tmp_where,0,-4)).")";
        $CI->db->where($tmp_where);
        if ($start)$CI->db->where("date >",$start);
        if ($end)$CI->db->where("date <",$end);
        $CI->db->where("user_id",$user_id);
        return $CI->db->get()->result_array()[0]['price'];
    }

    //get bes user total
    public function get_user_bes($user_id)
    {

        $groups=$this->get_bes_usergroups("user_tbl='user'");
        $CI =& get_instance();
        $CI->db->select_sum("price");
        $CI->db->from("mali_bed_bes");
        $CI->db->where("user_id",$user_id);
        $CI->db->where("enable",true);
        $tmp_where="(";
        foreach ( $groups as $k => $v)
            $tmp_where.="group_id = ".$v["id"]." OR ";
            $tmp_where=(substr($tmp_where,0,-4)).")";

            $CI->db->where($tmp_where);


        return $CI->db->get()->result_array()[0]['price'];
    }

    //get bes user total
    public function get_list_bes_from_user($user_id)
    {

        $groups=$this->get_bes_usergroups("user_tbl='user'");
        $CI =& get_instance();
        $CI->db->select("*");
        $CI->db->from("mali_bed_bes");
        $tmp_where="(";
        foreach ( $groups as $k => $v)
            $tmp_where.="group_id = ".$v["id"]." OR ";
        $tmp_where=(substr($tmp_where,0,-4)).")";
        $CI->db->where($tmp_where);
        $CI->db->where("user_id",$user_id);
        return $CI->db->get()->result_array();
    }
    //get bed user total
    public function get_list_bed_from_user($user_id)
    {
        $groups=$this->get_bed_usergroups("user_tbl='user'");
        $CI =& get_instance();
        $CI->db->select("*");
        $CI->db->from("mali_bed_bes");
        $tmp_where="(";
        foreach ( $groups as $k => $v)
            $tmp_where.="group_id = ".$v["id"]." OR ";
        $tmp_where=(substr($tmp_where,0,-4)).")";
        $CI->db->where($tmp_where);
        $CI->db->where("user_id",$user_id);
        return $CI->db->get()->result_array();
    }

    //return user bes renge
    public function get_user_bes_renge_date($start=0,$end=0)
    {
        $CI =& get_instance();
        $groups=$this->get_bes_usergroups();
        $CI->db->distinct();
        $CI->db->select('user_id,price,date');
        $CI->db->from('mali_bed_bes');
        $CI->db->group_start();
        foreach ( $groups as $k => $v)
            $CI->db->or_where("group_id",$v["id"]);
        $CI->db->group_end();
        if ($start)
            $CI->db->where('date >',$start);
        if($end)
            $CI->db->where('date <',$end);
        return $CI->db->get()->result_array();
    }


    //return last bes

    public function get_last_bes($user_id)
    {
        $CI =& get_instance();
        $groups=$this->get_bes_usergroups();
        $CI->db->select("*");
        $CI->db->where("user_id",$user_id);
        $CI->db->group_start();
        foreach ( $groups as $k => $v)
            $CI->db->or_where("group_id",$v["id"]);
        $CI->db->group_end();
        $CI->db->order_by("date","DESC");
        $CI->db->limit(1);
        $CI->db->from('mali_bed_bes');
        return $CI->db->get()->result_array();


    }
    // enable or disable bed bes
    public function en_dis($id){
        $CI =& get_instance();
        $tmp=!$CI->db->get_where("mali_bed_bes","id=$id")->result_array()[0]["enable"];
        $CI->db->where("id",$id);
        $CI->db->update("mali_bed_bes",array("enable"=>$tmp));
    }
    // time line bed bes | bill
    public function bill_user($user_id)
    {
        $CI =& get_instance();
        $CI->load->library('factor');
        $levelsar=$CI->factor->get_level_list("bed_bes");
        $CI->db->select("factor.id,factor.date,factor.expire_date");
        $CI->db->where("factor.user_id",$user_id);
        $CI->db->from("factor");
        return $CI->db->get()->result_array();

    }
}
