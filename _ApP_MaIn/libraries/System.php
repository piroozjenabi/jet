<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class System
{
    var $chk_chk = 2;
    private $start_day = null;
    public function __construct()
    {
        $CI = &get_instance();
        $this->start_day = $this->get_setting("start_day_week");
    }
    //load main cotroler from db
    public function gohome()
    {
        return redirect($this->get_setting("home"));
    }


    //get setting from db from
    public function get_setting($name, $def = false, $json = false)
    {
        $CI = &get_instance();
        $CI->db->select('value')
            ->from("setting")
            ->where("name", $name);
        $result = $CI->db->get()->row();
        $out = ($result) ? $result->value : $def;
        if ($json) {
            $out = json_decode($out);
        }
        return $out;
    }
    //        ------------------------------------login and user start
    //return user data
    public function get_user($type = "id")
    {
        $CI = &get_instance();
        $u = $CI->session->userdata("u");
        $p = $CI->session->userdata("p");
        //edit for test employ
        $res = $this->check_up_min($u, $p, $type);
        return $res;
    }

    //        ------------------------------------login and user start
    //return users or user from user group
    public function get_users_from_usergroup($id, $type = "id")
    {
        $CI = &get_instance();
        $CI->db->select($type);
        $CI->db->where_in("usergroup", $id);
        $CI->db->from("user_eemploy");
        return $CI->db->get()->result_array();
    }

    //return user from id
    public function get_user_from_id($id, $type = "name")
    {
        $CI = &get_instance();
        $CI->db->select($type);
        $CI->db->where("id", $id);
        $CI->db->from("user");
        return $CI->db->get()->row()->{$type};
    }

    //return user from id
    public function get_user_eemploy_from_id($id, $type = "name")
    {
        $CI = &get_instance();
        $CI->db->select($type);
        $CI->db->where("id", $id);
        $CI->db->from("user_eemploy");
        if ($type === "*") {
            return $CI->db->get()->row();
        }
        return $CI->db->get()->row()->{$type};
    }

    //change pass word
    public  function change_pass($id, $pass_word, $npass_word)
    {
        $CI = &get_instance();
        $CI->db->select("date_create");
        $CI->db->where("id", $id);
        $CI->db->from("user_eemploy");
        $dc = $CI->db->get()->row()->date_create;
        if ($dc) { }
        {
            $data["password"] = $this->hashp($npass_word, $dc);
            $CI->db->where("id", $id);
            $res = $CI->db->update('user_eemploy', $data);
        }
        return $res;
    }
    //encrypt password or others
    public function hashp($str, $md)
    {
        // $md=hash("sha256", $md);
        // return crypt($str, $md);
        return md5($str);
    }
    //check username and password
    public function check_up($u, $p, $type = "id")
    {
        $CI = &get_instance();
        if (!$u ||   !$p) {
            return false;
        }

        $CI->db->select('date_create');
        $CI->db->where('username', $u);
        $CI->db->from("user_eemploy");
        $result = $CI->db->get()->row();
        if (!$result) {
            return false;
        }
        $ps = $this->hashp($p, $result->date_create);
        $CI->db->select("*");
        $CI->db->where(array('password' => $ps, "username" => $u));
        $CI->db->from("user_eemploy");
        $result = $CI->db->get()->row();
        if (isset($result->id)) {
            return $result->{$type};
        } else {
            return false;
        }
    }
    //check username and password for all page and not hashed password
    public function check_up_min($u, $p, $type = "id")
    {
        $CI = &get_instance();
        if (!$u ||   !$p) {
            return false;
        }

        $CI->db->select("*");
        $CI->db->where(array('password' => $p, "username" => $u));
        $CI->db->from("user_eemploy");
        $result = $CI->db->get()->row();
        if (isset($result->id)) {
            return $result->{$type};
        } else {
            return false;
        }
    }

    //hash p and set session
    function setlogin($u, $p, $id)
    {
        $CI = &get_instance();
        $CI->db->select('date_create');
        $CI->db->where('username', $u);
        $CI->db->from("user_eemploy");
        $result = $CI->db->get()->row()->date_create;
        $p = $this->hashp($p, $result);
        $data = array('u' => $u, 'p' => $p, 'i' => $id, "A" => 1);
        $CI->session->set_userdata($data);
        return true;
    }
    //check login from session
    public function checklogin()
    {

        $CI = &get_instance();
        $u = $CI->session->userdata("u");
        $p = $CI->session->userdata("p");
        if ($this->check_up_min($u, $p)) {
            return true;
        } else {
            return false;
        }
    }

    //        ------------------------------------login and user end
    function lis()
    {
        if (time() < 1609459200) {
            $this->chk_chk = 1;
        }
    }
    //        ------------------------------------prd start
    //return prd from id
    public function get_prd_from_id($id, $type = "name")
    {
        $CI = &get_instance();
        $CI->db->select($type);
        $CI->db->where("id", $id);
        $CI->db->from("prd");
        return $CI->db->get()->row()->{$type};
    }
    //get prd
    public function get_prd($id, $val)
    {
        $CI = &get_instance();
        $CI->db->select($val);
        $CI->db->from("prd");
        $CI->db->where("id", $id);
        return $CI->db->get()->row()->{$val};
    }

    public function list_prd($select = "*")
    {
        $CI = &get_instance();
        $CI->db->select($select);
        $CI->db->order_by("order_by");
        $CI->db->from("prd");
        return  $CI->db->get()->result();
    }

    //        ------------------------------------prd end
    //        ------------------------------------time start
    //return time for persian time
    public function return_time_persian($time = 0)
    {
        $CI = &get_instance();
        $time = ($time) ? $time : time();
        $CI->load->library('Piero_jdate');
        $def_time = $CI->piero_jdate->jdate("Y/m/d", $time);
        //convert persian number to english
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        return str_replace($persian, $num, $def_time);
    }

    //return curent month time start and end $end_type if start validate in first time and end start of next date
    public function get_current_month_timetamp($type = "start", $mount_inc = 0)
    {
        $CI = &get_instance();
        $CI->load->library('Piero_jdate');
        $mount_inc = ($mount_inc) ? strtotime("-$mount_inc month") : strtotime("+1 days");
        $curent_month = $CI->piero_jdate->jdate("m", $mount_inc);
        $curent_year = $CI->piero_jdate->jdate("Y", strtotime("+1 days"));
        $last_day = $CI->piero_jdate->jdate("t", strtotime("+1 days"));
        switch ($type) {
            case "start":
                return $CI->piero_jdate->jmktime(0, 0,  0,  $curent_month, 0, $curent_year);

                break;
            case "end":
                return $CI->piero_jdate->jmktime(23, 50,  50,  $curent_month, $last_day, $curent_year);
                break;
        }
    }
    //
    //return array of mount name num=count of month to past
    function curent_months($num = 12, $with_year = true)
    {
        $CI = &get_instance();
        $CI->load->library('Piero_jdate');
        $out = array();
        for ($i = 0; $i <= $num; $i++) {
                $time = strtotime("-$i month");
                $year = $CI->piero_jdate->jdate("y", $time); //give num of mounth
                $month = $CI->piero_jdate->jdate("m", $time); //give num of mounth
                $name_month = $CI->piero_jdate->jdate_words(array("mm" => $month))["mm"];
                $out[$i] = $name_month . " " . $year; //convert date to mounth
            }
        return $out;
    }
    //return curent month time start and end $end_type if start validate in first time and end start of next date
    public function get_current_week_timetamp($type = "start", $week_inc = 0)
    {

        $CI = &get_instance();
        switch ($type) {
            case "start":
                return     strtotime("$week_inc  $this->start_day ago ");

                break;
            case "end":
                return     strtotime("$week_inc week $this->start_day ");
                break;
        }
    }



    //        ------------------------------------time end
    //get array to post to send via ajax
    public function array_post($arr)
    {
        $tmp_startup = null;
        foreach ($arr as $k => $v) {
                $tmp_startup .= "&$k=$v";
            }
        return ltrim($tmp_startup, '&');;
    }

    //render out for json if true $in state true else false
    // out put for json ajax in
    function json_out($in)
    {
        if ($in) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }

    //message
    public function message($text)
    {
        $CI = &get_instance();
        $CI->session->set_userdata("mes", $text);
    }

    public function show_message()
    {
        $CI = &get_instance();
        $message = $CI->session->userdata("mes");
        $CI->session->unset_userdata("mes");
        return $message;
    }
    //return all data from db
    public function get_db($db, $id, $type = "name")
    {
        $CI = &get_instance();
        $CI->db->select($type);
        if ($id) {
            $CI->db->where("id", $id);
        }
        $CI->db->from("$db");
        return $CI->db->get()->result_array()[0][$type];
    }
//===========================================upload start
public function upload($file = 'file')
{
    $config = array();
    $config['upload_path'] = $this->get_setting('def_upload_path');
    $config['allowed_types'] = $this->get_setting('def_upload_type');
    // $config['allowed_types'] = 'gif|jpg|png|jpeg|pjpeg|mp4|*';
    $config['max_size'] = $this->get_setting('def_upload_max_size');
    $config['overwrite'] = false;
    $config['encrypt_name'] = true;

    $CI = &get_instance();
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if (!$CI->upload->do_upload($file)) {
        return array('status' => false, 'error' => $CI->upload->display_errors());
    } else {
        return array('status' => true, 'data' => $CI->upload->data());
    }
}
//===========================================upload end

}

 