<?php defined('BASEPATH') or exit('No direct script access allowed');
class System
{
    private $start_day = null;

    public function __construct()
    {
        $this->start_day = $this->get_setting("start_day_week");
    }

    /**
     * go home redirect
     *
     * @return void
     */
    public function goHome()
    {
        return redirect($this->get_setting("home"));
    }


    /**
     * get setting from database
     *
     * @param $string $name
     * @param boolean $def
     * @param boolean $json
     * @return any
     */
    public function get_setting($name, $def = false, $json = false)
    {
        $CI = &get_instance();
        $CI->db->select('value')
            ->from("setting")
            ->where("name", $name);
        $result = $CI->db->get()->row();
        $out = $result ? $result->value : $def;
        return $json ? json_encode($out) : $out;
    }

    /**
     * get user details from sessions
     *
     * @param string $type
     * @return any
     */
    public function get_user($type = "id")
    {
        return isset(session()['user']->{$type})
            ? session()['user']->{$type}
            : null;
    }

    /**
     * get users from user groups
     *
     * @param int $id
     * @param string $type
     * @return void
     */
    public function get_users_from_usergroup($id, $type = "id")
    {
        $CI = &get_instance();
        return $CI->db->select($type)
            ->where_in("usergroup", $id)
            ->from("user_admin")->get()->result_array();;
    }
    /**
     * get user = client from user 
     *
     * @param int $id
     * @param string $type
     * @return void
     */

    public function get_user_from_id($id, $type = "name")
    {
        $CI = &get_instance();
        $CI->db->select($type)
            ->where("id", $id)
            ->from("user");
        return $CI->db->get()->row()->{$type};
    }


    /**
     * return user = admin from id
     *
     * @param string $id
     * @param string $type
     * @return any
     */
    public function get_user_eemploy_from_id($id, $type = "name")
    {
        $CI = &get_instance();
        $CI->db->select($type)
            ->where("id", $id)
            ->from("user_admin");

        return $type === '*'
            ? $CI->db->get()->row()
            : $CI->db->get()->row()->{$type};
    }

    /**
     * change password method
     */
    public function change_pass($id, $password, $newPassword)
    {
        $CI = &get_instance();
        return $CI->db
            ->where("id", $id)
            ->where('password', encrypt($password))
            ->update("user_admin", ['password' => encrypt($newPassword)]);
    }

    /**
     * check username and password
     */
    public function validate($username, $password, $type = "id")
    {
        $CI = &get_instance();
        if (!$username || !$password) {
            return false;
        }
        $CI->db->select("*")
            ->where(array('password' => encrypt($password), "username" => $username))
            ->from("user_admin");
        $result = $CI->db->get()->row();
        $this->setLogin($result);
        return isset($result->id) 
            ? $result->{$type}
            : false;
    }

    /**
     * check username and password for login
     *
     * @param string $username
     * @param string $password
     * @param string $type field of value
     * @return any
     */
    public function validateUser($username, $password, $type = "id")
    {
        $CI = &get_instance();
        if (!$username || !$password)
            return false;

        $result = $CI->db->select("$type")
            ->where(array('password' => $password, "username" => $username))
            ->from("user_admin")
            ->get()->row();

        return isset($result->{$type}) && $result->{$type}
            ? $result->{$type}
            : false;
    }

    /**
     * get user details from 
     *
     * @param string $username
     * @param string $password
     * @return void
     */
    function setLogin($data)
    {
        return $data->id
        ? session('user', $data)
        : session('user', false);
    }
    /**
     * check login from session
     *
     * @return void
     */
    public function checkLogin()
    {
        return isset(session('user')->id) && session('user')->id;
    }

    /**
     * return prd from id
     *
     * @param int $id
     * @param string $type field
     * @return void
     */
    public function get_prd_from_id($id, $field = "name")
    {
        $CI = &get_instance();
        $CI->db->select($field)->where("id", $id);
        return $CI->db->get("prd")->row()->{$field};
    }

    /** 
     * get list of all prd
     */
    public function list_prd($select = "*")
    {
        $CI = &get_instance();
        $CI->db->select($select);
        $CI->db->order_by("order_by");
        $CI->db->from("prd");
        return  $CI->db->get()->result();
    }

    #################################### JALALI DATE
    /**
     * return current month time start
     *
     * @param string $type  if start validate in first time and end start of next date
     * @param integer $mount_inc
     * @return any
     */
    public function get_current_month_timetamp($type = "start", $mount_inc = 0)
    {
        $CI = &get_instance();
        $CI->load->library('Piero_jdate');
        $mount_inc = ($mount_inc) ? strtotime("-$mount_inc month") : strtotime("+1 days");
        $current_month = $CI->piero_jdate->jdate("m", $mount_inc);
        $current_year = $CI->piero_jdate->jdate("Y", strtotime("+1 days"));
        $last_day = $CI->piero_jdate->jdate("t", strtotime("+1 days"));
        switch ($type) {
            case "start":
                return $CI->piero_jdate->jmktime(0, 0,  0,  $current_month, 0, $current_year);

                break;
            case "end":
                return $CI->piero_jdate->jmktime(23, 50,  50,  $current_month, $last_day, $current_year);
                break;
        }
    }
    /**
     * return array of mount name num=count of month to past
     *
     * @param integer $num
     * @param boolean $with_year
     * @return void
     */
    function current_months($num = 12)
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
    /**
     * return current month time start and end
     *
     * @param string $type if start validate in first time and end start of next date
     * @param integer $week_inc 
     * @return void
     */
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


    #################################### END JALALI DATE
    /**
     * get array to post to send via ajax
     *
     * @param array $arr
     * @return void
     */
    public function array_post($arr)
    {
        $tmp_startup = null;
        foreach ($arr as $k => $v) {
            $tmp_startup .= "&$k=$v";
        }
        return ltrim($tmp_startup, '&');;
    }

    /**
     * set flush message 
     */
    public function message($text)
    {
        $CI = &get_instance();
        return session("message", $text);
    }

    /**
     * get flush message 
     */
    public function show_message()
    {
        $message = session("message");
        session("message", null);
        return $message;
    }

    #################################### UPLOAD
    public function upload($file = 'file')
    {
        $config = array();
        $config['upload_path'] = $this->get_setting('def_upload_path');
        $config['allowed_types'] = $this->get_setting('def_upload_type');
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
    #################################### upload end

}
