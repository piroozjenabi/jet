<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
//opartions drop down menu
function load_atts($def_class = "btn-default")
{
    return array(
        'width' => '_w',
        'height' => '_h',
        'scrollbars' => 'yes',
        'status' => 'yes',
        'resizable' => 'yes',
        'screenx' => '0',
        'screeny' => '0',
        'class' => 'btn ' . $def_class);
}

function trace($in, $name = null)
{
    if (is_array($in)) {
        if ($name) {echo "<h2>$name </h2>";
        }
        echo "<pre>";
        print_r($in);
        echo "</pre>";
    } else {
        if ($name) {echo "<hr><b> $name =</b>";
        }
        echo $in . "<hr>";
    }

}
// get table count of array
function get_count_db($db, $where = null)
{
    $CI = &get_instance();
    $CI->db->select("id")
        ->from("$db");
    if ($where) {$CI->db->where($where);
    }
    return $CI->db->count_all_results();
}

/******************************************************************************/
/**
 * partak debuger
 *
 * @param array $in
 * @param boolean $die
 * @param string $title
 * @return void
 */
function dd($in, $die = false, $title = 'DUMP')
{
        $line = @debug_backtrace()[0]["line"];
        $file = @debug_backtrace()[0]["file"];
        $host = @gethostname();
        $id = 'jet' . rand(1, 100);
        $showText = (is_array($in) || is_object($in)) ? str_replace('"', '\'', json_encode($in, JSON_UNESCAPED_UNICODE)) : $in;
        echo "<div  style='padding:5px;width:auto%;background:#5a67a6;color:#fff;text-align:center;cursor:pointer;overflow:auto;z-index:999999' > <b> $title </b>  $file : $line | $host 
        <span style='color:#cbf1f5;font-weight:bolder;cursor:pointer;float:right' onclick='$(\"#sht$id\").select(); document.execCommand(\"copy\");' > [ C ] </span>
        <span style='color:#f3cf7a;font-weight:bolder;cursor:pointer;float:right' onclick='win=window.open();win.document.body.innerHTML =$(\"#sht$id\").val()' >  [ O ] </span>
        <span style='color:#ffc7c7;font-weight:bolder;cursor:pointer;float:right' onclick='$(\"#$id\").toggle()' >  [ X ] </span> </div> ";
        echo "<pre id='$id' style='margin:5px 0px;padding:10px;border:1px solid #ccc;direction:ltr;overflow:auto;'>";
        var_dump($in);
        echo "<input style='width:1px;height:1px' id='sht$id' value=\"{$showText}\" /> </pre>  ";
        if($die) die();
      
}

function jsonOut($in, $die = true){
    header('Content-Type: application/json');
    $out = [];
    if ($in == false and is_bool($in)) //simple false 
        $out["status"] = false;
    else if ($in == true and is_bool($in)) //simple true
         $out["status"] = true;
     elseif (is_array($in) && @$in["status"] == 2) { //return contex of html code base 64
        $out["status"] = 2;
        $out["body"] = base64_encode($in["body"]);
    } elseif (is_array($in) && @$in["status"] == 3) { //simple array
        $out = $in["data"];
    } else if (is_array($in) and @$in[0] == false) //retrrn false with custom array
    {
        $out["status"] = false;
        $out["data"] = $in;
    } else if (is_array($in)) //return array with true
    {
        $out["status"] = true;
        $out["data"] = $in;
    } else {
        $out["status"] = false;
    }
    if ($die) { //if parametr 2 die page
        echo json_encode($out);die();
    }
    return json_encode($out);
}
    //main function for date 
    function printDate($time=null,$format="Y-m-d"){
        $CI = &get_instance();
        $CI->load->library('Piero_jdate');
        if(is_string($time)) $time=strtotime($time);
        $time = (!$time)?time():$time;
        return $CI->piero_jdate->jdate($format,  $time);
    }

    function pl($word){
        if (defined(strtoupper($word))) return constant(strtoupper($word));
        else if (defined(strtoupper("_".$word))) return constant(strtoupper("_".$word));
        else return null;
    }

    /**
     * return date with templete
     *
     * @param integer $time 
     * @return string date format
     */
    function jetDate($time = 0){
        if(!is_numeric($time)) return $time;
        $time = $time?$time:time();
        return date("Y-m-d H:i:s", $time);
    }

    function loadHeader($params = []){$CI = &get_instance(); $CI->load->view('include/dt-header', $params, 1); }