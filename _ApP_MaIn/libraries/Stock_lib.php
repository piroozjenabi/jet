<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Stock_lib
{

    //get all about supply
    //     $type:  "in" list of all in  , "out" list of all out , "supply" in - out
    //             "last_stock_check" return num of last stock check , "num_out_after_stock_check" return num after stock check
    //     "real" last_stock_check-num_out_after_stock_check

    public function supply($prd_id,$type="real",$stock=0)
    {
        $CI =& get_instance();
        $CI->load->model('Stock/Stock_out_model');
        $CI->load->model('Stock/Stock_in_model');
        $CI->load->model('Stock/Stock_model');
        $stock_out=$CI->Stock_out_model->num_prd_stock_out($prd_id, $stock)[0]["num"];
        $stock_in=$CI->Stock_in_model->num_prd_stock_in($prd_id, $stock)[0]["num"];

        switch ($type){
        case("in"):
            return $stock_in;
                break;
        case("out"):
            return $stock_out;
                break;
        case ("supply"):
            return ($stock_in - $stock_out);
                break;
        case "last_stock_check":

            return $CI->Stock_model->last_stock_check($prd_id, "num", $stock);
                break;
        case "num_out_after_stock_check":
            return $CI->Stock_model->out_after_check($prd_id, $stock);
                break;
        case "real":

            $stk_check=$CI->Stock_model->last_stock_check($prd_id, "num", $stock);

            if(!$stk_check)
                //dont enter stock check
            {return ($stock_in - $stock_out);
            }
            else
            {

                $tmp_chk=$CI->Stock_model->out_after_check($prd_id, $stock);

                if($tmp_chk) {
                    return $CI->Stock_model->last_stock_check($prd_id, "num", $stock)-$tmp_chk;
                }
                else
                {
                    return $CI->Stock_model->last_stock_check($prd_id, "num", $stock);
                }
            }

            break;

        }

        return false;
    }

    function get_def_stock()
    {
        $CI=&get_instance();
        return $CI->db->get_where("stock", "def=1")->row();
    }


}
