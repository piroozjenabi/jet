<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class System_log
{

    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->library('user_agent');
        $data=array();
        $data['id']=null;
        $data['des']="";
        if (isset(session('user')->id) && session('user')->id ){
            $data['user_id']=  session('user')->id;
            $data['user_name']= session('user')->username;
        }
        else
        {
            $data['user_id']="";
            $data['user_name']="";
            $data['des']="login";
        }
        $data['url']=base_url(uri_string());
        $data['time']=time();

        $data['ip']=$CI->input->ip_address();
        $data['agent']=$this->agent()."--".$CI->agent->platform();
        $data['system']= $CI->agent->agent_string();
        $data['post']=json_encode($CI->input->post());
        //add to db
        $CI->db->insert('log', $data);
    }


    public function agent()
    {

        $CI =& get_instance();
        $CI->load->library('user_agent');
        if ($CI->agent->is_browser()) {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        elseif ($CI->agent->is_robot()) {
            $agent = $CI->agent->robot();
        }
        elseif ($CI->agent->is_mobile()) {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }
        return $agent;
    }

}


?>
