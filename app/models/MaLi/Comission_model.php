<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Comission_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    //with reject and parent
    public function commison_factor($id_factor)
    {

        //        $list_of_parent=$this->db->get_where("factor","parent_id=$id_factor")->result_array();
        $com=$this->commison_factor_one($id_factor);
        //        $com_rej=0;
        //        foreach ($list_of_parent as $key => $value)
        //        {
        //            $com_rej+=$this->commison_factor_one($value["id"],$value["maker_id"],$value["user_id"]);
        //        }
        return ($com);
    }

    //get coimsion group for user
    public function get_user_comision($user_id=null)
    {
        $user_id=($user_id)?$user_id:$this->system->get_user();
        $ret=$this->system->get_setting("def_comision_group");
        $params=$this->system->get_user_admin_from_id($user_id, "params");
        if($params) {
            $params=json_decode($params);
            $tmp=$params->comision;
            if ($tmp) {
                $ret=$tmp;
            }
        }
        return $ret;
    }
    //get coimsion group for user
    public function get_user_uncomision_user($user_id=null)
    {
        $ret=0;
        $user_id=($user_id)?$user_id:$this->system->get_user();
        $params=$this->system->get_user_admin_from_id($user_id, "params");
        if($params) {
            $params=json_decode($params);
            $tmp=$params->uncomision_user;
            if ($tmp) {
                $ret=$tmp;
            }
        }
        $ret=explode(",", $ret);
        return $ret;
    }

    //factor comision withot reject
    public function commison_factor_one($id_factor,$maker=null,$client=null)
    {
        $curent=time();
        $maker=($maker)?$maker:$this->db->get_where("factor", "id=$id_factor")->result_array()[0]["maker_id"];
        $client=($client)?$client:$this->db->get_where("factor", "id=$id_factor")->result_array()[0]["user_id"];
        //baraie karbarani ke komision shameleshan nemishavad
        //        print_r($this->get_user_uncomision_user($maker));
        if(array_search($client, $this->get_user_uncomision_user($maker))) {
            return 0;
        }
        $com_group=$this->get_user_comision($maker);
        $this->db->select("*");
        $this->db->from("mali_commision");
        $this->db->where("groupc", $com_group);
        $res_commision=$this->db->get()->result_array();
        //date factor
        $this->db->select("date");
        $this->db->where("id", $id_factor);
        $factor_date=$this->db->get("factor")->result_array()[0]["date"];

        //main prd
        $this->db->select("id_prd,price ,num ,takhfif  ");
        $this->db->where("id_factor", $id_factor);
        $res_factor=$this->db->get("factor_prd")->result_array();

        //mablaghe kol factor
        $total_factor=0;
        //mablaghe nahaie taki
        $tmptotal_factor=0;
        //mablaghe  komision
        $tot_com=0;
        foreach ($res_factor as $key => $value)
        {
            //mohasebeie mablaghe taki nahaii
            $tmptotal_factor =(($value['price']*$value['num'])-$value['takhfif'])/$value['num'];
            //mohasebe bara jame kol
            $total_factor +=($value['price']*$value['num'])-$value['takhfif'];;
            $flgc=0;
            foreach ( $res_commision as $key2 => $value2)
            {

                if ($value2["prd_id"] == $value["id_prd"] ) {

                    if($tmptotal_factor >= $value2["fromc"]  &&    $tmptotal_factor < $value2["toc"] ) {

                        //                        if( $factor_date >= $value2["date_start"]  &&    $factor_date < $value2["date_end"])
                        //                        {

                        //darsad ra hesab karde va kharej mishavad hamchenin parchame hade mojaz ra true mikonad
                        $tot_com += $tmptotal_factor *($value2["value_percent"]/100) *$value['num'];
                        $flgc=1;
                        break;
                        //                        }
                    }
                }

            }
            //            if($flgc==0)
            //            {
                $tmpf=0;
                //mohasebeie mazad
            //                $tmpf +=($tmptotal_factor-$value2["toc"])*$value["num"];
                //mohasebe darsad
            //                $tmpf +=($value2['toc']*$value['num'])*$value2["value_percent"]/100;
            //                $tot_com +=  $tmpf;
            //            }

        }
        //        echo $tot_com."|";
        return $tot_com;
    }

    //return commision from employer
    public function get_user_commission($user_id=0,$level=1,$month=0)
    {
        $user_id=($user_id==0)?$this->system->get_user():$user_id;
        $this->db->select("id");
        $this->db->from("factor");
        $this->db->where("maker_id", $user_id);
        $this->db->where("level_id", $level);

        if ($month!=0) {
            $month=($month==-1)?0:$month;
            $start_d = $this->system->get_current_month_timetamp("start", $month);
            $end_d= $this->system->get_current_month_timetamp("end", $month);
            $this->db->where("factor.date >",  $start_d);
            $this->db->where("factor.date  <",  $end_d);
        }
        $res_factor=$this->db->get()->result_array();

        $tot=0;
        foreach ($res_factor as $key => $value)
        {
            $tot+=$this->commison_factor($value["id"]);
        }

            return $tot;

    }


    public function add_comisions($id)
    {
        for ($i=1;$i<=count(post("prd_id", true));$i++) {
            $data = array();
            $data["prd_id"] = post("prd_id", true)[$i];
            $data["fromc"] = post("fromc", true)[$i];
            $data["toc"] = post("toc", true)[$i];
            $data["value_percent"] = post("value_percent", true)[$i];
            $data["value_num"] = post("value_num", true)[$i];
            $data["groupc"] = $id;
            if($data["prd_id"]) {    $res = $this->db->insert('mali_commision', $data);
            }
        }
        return $res;
    }
}
