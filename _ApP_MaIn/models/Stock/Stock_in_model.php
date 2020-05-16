<?php defined('BASEPATH') OR exit('No direct script access allowed');
class  Stock_in_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //lib --------------------------
    public  function stock_in($prd_id,$num,$date=0,$user_id=0,$des="",$params=array(),$stock_id=null,$lot=null,$proforma=null)
    {
        if(!$stock_id) {
            $stock_id=$this->stock_lib->get_def_stock()->id;
        }
        $date=($date)?$date:date('Y-m-d H:i:s');
        $date=jetDate($date);
        $user_id=($user_id)?$user_id:$this->system->get_user();

        $data=array(
            "prd_id"=>$prd_id,
            "num"=>$num,
            "date"=>$date,
            "stock_id"=>$stock_id,
            "params"=>json_encode($params),
            "user_id"=>$user_id,
            "des"=>$des,
            "lot"=>$lot,
            "pro_forma"=>$proforma,
        );

        return $this->db->insert("stock_in", $data);

    }
    //stockin factor
    public function stock_in_factor($factor_id)
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
            $des=_FACTOR_SELL.__._REJECT." : ".$factor_id;
            $this->stock_in($value["id_prd"], $value["num"], $res_factor["date"], $res_factor["maker_id"], $des, $params);
        }


    }

    // save stockin from level factor
    public  function stock_in_level($level)
    {
        $this->db->select("*");
        $this->db->where("level_id", $level);
        $this->db->from("factor");
        $res=$this->db->get()->result_array();
        foreach ($res as $key => $value)
        {
            $this->stock_in_factor($value["id"]);
        }

    }

    public function num_prd_stock_in($prd_id,$stock=null)
    {
        $this->db->select_sum('num');
        $this->db->where("prd_id", $prd_id);
        if ($stock) { $this->db->where("stock_id", $stock);
        }
        $result =$this->db->get('stock_in')->result_array();
        return $result;
    }


    //stack in renge date
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
        $this->db->from('stock_in');
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
