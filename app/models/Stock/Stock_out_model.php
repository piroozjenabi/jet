<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class  Stock_out_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    //stock out
    public  function stock_out($prd_id,$num,$date=0,$user_id=0,$des="",$params=array(),$stock_id=null)
    {
        $this->load->library("Stock_lib");

        if(!$stock_id) {
            $stock_id=$this->stock_lib->get_def_stock()->id;
        }

        $date=($date)?$date:time();
        $date = jetDate($date);
        $user_id=($user_id)?$user_id:$this->system->get_user();

        $data=array(
            "prd_id"=>$prd_id,
            "num"=>$num,
            "date"=>$date,
            "params"=>json_encode($params),
            "user_id"=>$user_id,
            "stock_id"=>$stock_id,
            "des"=>$des,
        );

        $out= $this->db->insert("stock_out", $data);
        //        alert stack out
        if($out) {
            $this->stack_out_alert($prd_id);
        }
    }

    function stack_out_alert($prd_id=null)
    {
        $prd_id=($prd_id)?$prd_id:$this->input->post("prd_id", true);
        $this->load->library("Stock_lib");
        $user_id=$this->system->get_user();
        $prd=$this->db->get_where("prd", "id=$prd_id")->row();
        $this->load->library("Alerts_lib");
        $supply=$this->stock_lib->supply($prd_id, "real");
        $mes=$prd->name." "._OUT_STACK_ALERT;
        if($supply<= ($prd->out_stack_alert)) {
            $this->alerts_lib->add_alert(7, array('id'=>$prd_id), time(), $mes, array( "0" => array("id" => $user_id)));
        }
    }

    //stockout factor
    public function stock_out_factor($factor_id)
    {
        //get information about factor
        $res_factor=$this->db->get_where("factor", "id=$factor_id")->result_array()["0"];
        $this->db->select("*");
        $this->db->where("id_factor", $factor_id);
        $this->db->from("factor_prd");
        $res=$this->db->get()->result_array();
        foreach ($res as $key => $value)
        {
            $params=array("factor_id"=>$factor_id);
            $des=_FACTOR_SELL." : ".$factor_id;
            $this->stock_out($value["id_prd"], $value["num"], $res_factor["date"], $res_factor["maker_id"], $des, $params);
        }


    }

    // save stockout from level factor
    public  function stock_out_level($level)
    {
        $this->db->select("*");
        $this->db->where("level_id", $level);
        $this->db->from("factor");
        $res=$this->db->get()->result_array();
        foreach ($res as $key => $value)
        {
            $this->stock_out_factor($value["id"]);
        }

    }

    public function num_prd_stock_out($prd_id,$stock=null)
    {

        $this->db->select_sum('num');
        $this->db->where("prd_id", $prd_id);
        if ($stock) { $this->db->where("stock_id", $stock);
        }
        $result =$this->db->get('stock_out')->result_array();

        return $result ;

    }
    //stack out renge date
    public function get_stock_out_renge_date($start=0,$end=0,$user_id=0,$prd_id=0,$stock)
    {
        if($user_id>0) {
            $this->db->where('maker_id', $user_id);
        } elseif ($user_id==0) {
            $this->db->where('maker_id', $this->system->get_user());
        }
        if($prd_id) {
            $this->db->where('prd_id', $prd_id);
        }
        $this->db->select('id,num');
        $this->db->from('stock_out');
        if ($stock) { $this->db->where("stock_id", $stock);
        }
        if($start) {
            $this->db->where('date >= ', jetDate($start));
        }
        if($end) {
            $this->db->where('date <=', jetDate($end));
        }
        return $this->db->get()->result_array();

    }

}
