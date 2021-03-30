<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * return total numbers of table
 *
 * @param string $table name of table
 * @param string $where 
 * @return int
 */
function getCountQuick($table, $where = null)
{
    $CI = &get_instance();
    return $CI->db
        ->select('id')
        ->where($where)
        ->from($table)
        ->count_all_results();
}
/**
 * return all row of table
 *
 * @param string $table name of table
 * @param string $where 
 * @return int
 */
function getAllQuick($table, $where = null){
    $CI = &get_instance();
    return $CI->db
        ->select('id')
        ->where($where)
        ->from($table)
        ->get()->result_array();
}

/**
 * return data from db by primary key
 *
 * @param string $table
 * @param string $id
 * @param string $field
 * @return void
 */
function getQuick($table, $id, $field = null)
{
    $CI = &get_instance();
    $result = $CI->db
        ->select('*')
        ->where([ 'id' => $id ])
        ->from($table)
        ->get()->row_array();
    return $field 
    ? $result["$field"]
    : $result;
}


/**
 * jet profiler
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
    if ($die) die();
}

/**
 * return json to ajax requests
 *
 * @param any $in
 * @param boolean $die
 * @return void
 */
function jsonOut($in, $die = true)
{
    header('Content-Type: application/json');
    $out = [];
    if ($in === false) //simple false 
        $out["status"] = false;
    else if ($in === true) //simple true
        $out["status"] = true;

    elseif (is_array($in) && @$in["status"] == 2) { //return context of html code base 64
        $out["status"] = 2;
        $out["body"] = base64_encode($in["body"]);
    } elseif (is_array($in) && @$in["status"] == 3) { //simple array
        $out = $in["data"];
    } else if (is_array($in) and @$in[0] == false) //return false with custom array
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
    if ($die) { //if parameter 2 die page
        echo json_encode($out);
        die();
    }
    return json_encode($out);
}

/**
 * function to print jalali date
 *
 * @param [type] $time
 * @param string $format
 * @return void
 */
function printDate($time = null, $format = "Y-m-d")
{
    if($time == 0) return '---';
    $CI = &get_instance();
    $time = is_string($time)
        ? strtotime($time)
        : ($time
            ? $time
            : time());
    return $CI->piero_jdate->jdate($format, $time);
}

/**
 * function to parse name
 *
 * @param string $word
 * @return void
 */
function pl($word)
{
    if (defined(strtoupper($word))) return constant(strtoupper($word));
    else if (defined(strtoupper("_" . $word))) return constant(strtoupper("_" . $word));
    else return null;
}

/**
 * return date with template
 *
 * @param integer $time 
 * @return string date format
 */
function jetDate($time = 0)
{
    if (!is_numeric($time)) return $time;
    $time = $time ? $time : time();
    return date("Y-m-d H:i:s", $time);
}

/**
 * load header of pages
 *
 * @param array $params to send to view ['title' => '']
 * @return void
 */
function loadHeader($params = [])
{
    $CI = &get_instance();
    $CI->load->view('include/dt-header', $params, 1);
}

/**
 * encrypt for password
 *
 * @param [type] $value
 * @param string $key
 * @return void
 */
function encrypt($value){
    return md5($value.HASH);
}

/**
 * return post data
 *
 * @param string $key
 * @param string $default
 * @return any
 */
function post($key = null , $secure = true, $default = null){
    $CI = &get_instance();
    return $CI->input->post($key)
    ? $CI->input->post($key, $secure)
    : $default;
}
/**
 * return session data
 *
 * @param string $key
 * @param string $default
 * @return any
 */
function session($key = null , $value = false){
    if($value === false){
        return isset($_SESSION[$key])
        ? $_SESSION[$key]
        : ($key ? null :$_SESSION);
    }else{
        $_SESSION[$key]=$value;
        return true;
    }
}

