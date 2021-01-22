<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class My_client_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    //list of my user
    function my_client_list($user_id)
    {
        $this->load->model("MaLi/Factor_sell_model");
        $this->load->library('Piero_jdate');
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where("user.maker_id", $user_id);
        $this->db->order_by('user.name', 'DESC');
        $res=$this->db->get()->result_array();
        foreach ($res as $key => &$value)
        {
            $this->db->select('id,date');
            $this->db->from('factor');
            $this->db->where("factor.user_id", $value['id']);
            $this->db->where("factor.level_id", '1');
            $res_factor=$this->db->get()->result_array();
            $count=count($res_factor);
            $value["count"]=$count;
            $total_price=0;
            $last_date=0;
            foreach ($res_factor as $keyf => $valuef)
            {

                $total_price += $this->Factor_sell_model->show_total_price($valuef["id"]);
                $last_date=  $valuef["date"];
            }
            $value["total_price"]=$total_price;
            $value["last_date"]=$last_date;

        }

        return $res;

    }

    //list of my user
    function acounting_list($type="",$renge="",$user_id=0)
    {
        $this->load->model("MaLi/Factor_sell_model");
        $this->load->library('Piero_jdate');
        $this->load->library('bed_beslib');
        $this->load->library("Factor");
        $tmplevels=$this->factor->get_level_list("bed_bes", "id");
        $levels=array();
        foreach ($tmplevels as $k => $v) {
            $levels[]=$v["id"];
        }

        //define
        $tmp_start=0;
        $tmp_end=0;

        //if type == factor
        if($type=="factor") {
            $this->load->library("Factor");

            if ($renge == "week" ) {
                $tmp_start=$this->system->get_current_week_timetamp("start");
                $tmp_end=$this->system->get_current_week_timetamp("end");
            }
            else if ($renge == "mounth" ) {
                $tmp_start=$this->system->get_current_month_timetamp("start");
                $tmp_end=$this->system->get_current_month_timetamp("end");

            }
            $tmp_res_factor_user=array(null);
            $res_factor_user=$this->factor->get_user_factor_renge_date($tmp_start, $tmp_end);
            foreach ($res_factor_user as $k => $v) {
                $tmp_res_factor_user[]=$v["user_id"];
            }
        }


        //end type factor


        //if type == bes for bestankari filter
        if($type=="bes") {
            if ($renge == "day" ) {
                    $tmp_start=strtotime("-1 days");
                $tmp_end=strtotime("+1 days");

            }
            else if ($renge == "week" ) {
                $tmp_start=$this->system->get_current_week_timetamp("start");
                $tmp_end=$this->system->get_current_week_timetamp("end");
            }
            else if ($renge == "mounth" ) {
                $tmp_start=$this->system->get_current_month_timetamp("start");
                $tmp_end=$this->system->get_current_month_timetamp("end");

            }
            $tmp_res_bes_user=array(null);
            $res_bes_user=$this->bed_beslib->get_user_bes_renge_date($tmp_start, $tmp_end);
            foreach ($res_bes_user as $k => $v) {
                $tmp_res_bes_user[]=$v["user_id"];
            }
        }


        //end type factor
        $this->db->select('*');
        $this->db->from('user');
        if($user_id) {
            $this->db->where("user.maker_id", $user_id);
        }
        $this->db->order_by('user.name', 'DESC');
        if($type=="factor") { @$this->db->where_in("user.id", $tmp_res_factor_user);
        }
        if($type=="bes") { @$this->db->where_in("user.id", $tmp_res_bes_user);
        }
        $res=$this->db->get()->result_array();

        foreach ($res as $key => &$value)
        {

            $this->db->select('id,date,level_id');
            $this->db->from('factor');
            $this->db->where("factor.user_id", $value['id']);
            $this->db->where_in("factor.level_id", $levels);
            if($type=="debtor") {
                if ($renge == "day" ) {
                    $this->db->where("factor.expire_date < ", time());
                }
                else if ($renge == "mounth" ) {
                    $this->db->where("factor.expire_date < ", $this->system->get_current_month_timetamp("end", 1));
                }
            }
            $res_factor=$this->db->get()->result_array();
            $count=count($res_factor);
            $value["count"]=$count;
            $total_price=0;
            //total dariafti

            if($type=="debtor") {

                if ($renge == "day" ) {
                    $total_dariafti= $this->bed_beslib->get_user_bes($value['id'], 0, time());
                }
                else if ($renge == "mounth" ) {
                    $total_dariafti= $this->bed_beslib->get_user_bes($value['id'], 0, $this->system->get_current_month_timetamp("end", 1));
                }

            }
            else{$total_dariafti=$this->bed_beslib->get_user_bes($value['id']);
            }

            $last_date=0;
            $remind=0;

            foreach ($res_factor as $keyf => $valuef)
            {
                $total_price += $this->Factor_sell_model->show_total_price($valuef["id"]);
                $last_date=  $valuef["date"];
                //                echo "t=$total_price | p=".$this->Factor_sell_model->show_total_price($valuef["id"])."<br>";
            }
            $remind=$total_price-$total_dariafti;

            if ($total_price==0 && !$this->system->get_setting("show_zero_on_acounting_clients")) { unset($res[$key]);
            }

            //debtor type

            if($type=="debtor") {
                if ($remind <=0  ) {
                    unset($res[$key]);
                }
            }

            @$tmp_get_last_price=$this->bed_beslib->get_last_bes($value['id'])[0]["price"];
            @$tmp_get_last_date=$this->bed_beslib->get_last_bes($value['id'])[0]["date"];
            $value["last_get_date"]=($tmp_get_last_date)?$tmp_get_last_date:null;
            $value["last_get_price"]=($tmp_get_last_price)?$tmp_get_last_price:null;
            $value["total_price"]=$total_price;
            $value["remind"]=$remind;
            $value["total_dariafti"]=$total_dariafti;
            $value["last_date"]=$last_date;

        }
        return $res;

    }

    function counter()
    {
        $user_id=$this->system->get_user();
        $this->db->select('id');
        $this->db->from('user');
        $this->db->where("user.maker_id", $user_id);
        $ret=$this->db->get()->result_array();
        return count($ret);
    }

    public function add_track($id="")
    {
        $user_id=$this->system->get_user();
        for ($i=1;$i<=count(post("track", true));$i++) {
            $data = array();
            $data["id"] = "";
            $data["message"] = post("track", true)[$i];
            $data["date"] = time();
            $data["from_user"] = $this->system->get_user();
            //            for replay
            if(post("replay", true)[1]) {
                $data["replay"]=post("replay", true)[1];
            }
            $data["client"] = $id;
            if($data["message"]!="") {
                $res = $this->db->insert('user_tracking', $data);
            }

        }
        return $res;
    }
    //list track
    public function list_track($id,$time_start=0,$time_end=0)
    {
        $this->db->select("*");
        $this->db->where("client", $id);
        $this->db->from('user_tracking');
        if ($time_start > 0) {
            $this->db->where("date >", $time_start);
        }
        if ($time_end> 0) {
            $this->db->where("date <", $time_end);
        }
        return $this->db->get()->result_array();
    }

    //edit
    public function edit_user($id)
    {

        $this->db->select("*");
        $this->db->from('user');
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }

    //list track
    public function list_track_time($id,$time_start=0,$time_end=0)
    {
        $this->db->select("*");
        $this->db->where("id_client", $id);
        $this->db->from('user_track_period');
        $this->db->order_by('date');
        if ($time_start > 0) {
            $this->db->where("date >", $time_start);
        }
        if ($time_end> 0) {
            $this->db->where("date <", $time_end);
        }
        return $this->db->get()->result_array();
    }

    //add tracking time
    public function add_track_time($time,$client_id)
    {
        $user_id=$this->system->get_user();
        $count=count($this->list_track_time($client_id, time()));
        if($this->system->get_setting("max_user_time_period")>$count ) {
            $data = array();
            $data["id"] = "";
            $data["des"] = post("des", true);
            $data["date"] = $time;
            $data["id_user"] = $user_id;
            $data["id_client"] = $client_id;
            if($this->db->insert('user_track_period', $data)) {


                $mes=post("des", true)." ".$this->system->get_user_from_id($client_id);
                $this->alerts_lib->add_alert(2, array('id'=>$client_id), $time, $mes, array( "0" => array("id" => $user_id)  ));
            }
        }
        else{

            return 0;
        }
    }

}
