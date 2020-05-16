<?php defined('BASEPATH') OR exit('No direct script access allowed');

class stock_model extends CI_Model
{

    // returm num of prd from last stock check
    public function last_stock_check($prd_id,$type="num",$stock=null)
    {
        $this->db->select($type);
        $this->db->where("prd_id", $prd_id);
        if ($stock) { $this->db->where("stock_id", $stock);
        }
        $this->db->order_by("prd_id", "desc");

        $this->db->from("stock_check");
        @$tmp=$this->db->get()->result_array();
        if($tmp) {
            return $tmp[count($tmp)-1][$type ];
        } else {
            return false;
        }
    }
    
    // return real remind supply
    public function out_after_check($prd_id,$stock=null)
    {
        $tnum_in=0; $tnum_out=0;$tnum=0;
        $start= ($this->last_stock_check($prd_id, "date", $stock))?$this->last_stock_check($prd_id, "date", $stock):0;
        $end=time();
        $result_out=$this->Stock_out_model->get_stock_out_renge_date($start, $end, -1, $prd_id, $stock);
        $result_in=$this->Stock_in_model->get_stock_out_renge_date($start, $end, -1, $prd_id, $stock);

        if (count($result_out)) {
            foreach ($result_out as $key => $value) {
                $tnum_out += $value["num"];
            }
        }
        if (count($result_in)) {
            foreach ($result_in as $key => $value) {
                $tnum_in += $value["num"];
            }
        }
        $tnum=$tnum_out-$tnum_in;
         return $tnum;
    }

    //get by product enter proform
    public function stock_list()
    {
        $this->db->select("*");
        $this->db->from("stock");
        return $this->db->get()->result_array();
    }


    //get by product enter proform
    public function get_dis_proform()
    {
        $this->db->distinct();
        $this->db->select("pro_forma");
        $this->db->from("stock_in");
        return $this->db->get()->result_array();
    }


}
