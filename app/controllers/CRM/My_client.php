<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
 
class My_client extends CI_Controller
{

    //acounting dashboard
    function acounting($type="",$renge=0,$user_id=0)
    {
        $this->load->model("CRM/My_client_model");
        $res=$this->My_client_model->acounting_list($type, $renge, $user_id);
        $this->template->load("CRM/my_client/accounting", array("res" => $res));
    }

    function index($user_id=0)
    {

        $this->load->model("CRM/My_client_model");
        $res=$this->My_client_model->my_client_list($user_id);

        $this->template->load("CRM/my_client/main", array("user_id"=>$user_id,"belfel"=>$res), array("title"=>_MY_CLIENT));
    }

    function belfel($user_id=0)
    {
        if(!$user_id) {
            $user_id=$this->system->get_user();
        }
        $this->load->model("CRM/My_client_model");
        $res=$this->My_client_model->my_client_list($user_id);

        $this->template->load("CRM/my_client/belfel", array("res" => $res));
    }



    public function tracks($id=0)
    {
        $id=($id==0)?$this->system->get_user:$id;
        $curent_time=0;
        $last_time=0;
        $tmp_last_time=0;
        $des_curent_time="";
        $des_last_time="";
        $des_tmp_last_time="";
        $fld_period=0;
        $next=array();
        $this->load->model('CRM/My_client_model');

        // add time tracks
        $time_track= post("date", true);
        if($time_track) {
            $this->My_client_model->add_track_time($time_track, $id);
        }
        // get time tracks
        $period=$this->My_client_model->list_track_time($id);
        foreach ($period as $key => $value)
        {
            if($fld_period) {
                $next[$key]=$value;
            } else {
                if ($value["date"] < jetDate()) {

                    $tmp_last_time = $last_time;
                    $des_tmp_last_time = $des_last_time;
                    $last_time = $value["date"];
                    $des_last_time=$value["des"];
                } else {
                    $curent_time = $value["date"];
                    $des_curent_time=$value["des"];
                    $fld_period = 1;
                }
            }

        }
        //add rule
        $tmp_last_time=($tmp_last_time==0)?$last_time:$tmp_last_time;
        $des_tmp_last_time=($des_tmp_last_time==0)?$des_last_time:$des_tmp_last_time;




        $def_time=jetDate();
        $res=$this->My_client_model->list_track($id, $last_time, $curent_time);
        $ret_tmpuser=$this->My_client_model->edit_user($id);



        $res_array=array("id_user"=>$id,"tracks" => $res,"tmp_user"=>$ret_tmpuser,"cur"=>$curent_time,"des_cur"=>$des_curent_time,"last"=>$last_time,"des_last"=>$des_last_time,'def_time' => $def_time ,"period" => $next );
        $this->template->load("CRM/my_client/tracks", $res_array);
    }

    public function add_tracks($id)
    {
        $this->load->model('CRM/My_client_model');
        $res=$this->My_client_model->add_track($id);

        //make ok
        if ($res>0) {
            $this->system->message(_ADDED);
            redirect("/CRM/My_client/tracks/".$id);
        }

        else
        {
            $this->system->message(_ERROR);
            redirect("/CRM/My_client/tracks/".$id);
        }
    }
}
