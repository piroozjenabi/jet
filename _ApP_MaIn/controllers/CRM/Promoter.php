<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Promoter extends CI_Controller
{

    function add()
    {
        $this->template->load('CRM/Promoter/add_p_users');
    }

    //add users too database
    function padd()
    {
        $this->load->model('CRM/Promoter_model');
        $res=$this->Promoter_model->add_users();

        //make ok
        if ($res>0) {
            $this->system->message(_PROMOTER._ADDED);
            redirect("/CRM/Promoter/manage");
        }
        //limit for make
        else if ($res == -1) {
            $this->system->message(_ERROR_LIMIT_ ." ". _PROMOTER);
            redirect("/CRM/Promoter/manage");
        }
        //not maked
        else
        {
            $this->system->message(_ERROR);
            redirect("/CRM/Promoter/manage");
        }

    }
    //edit user
    function edit($id)
    {
        $this->load->model('CRM/Promoter_model');
        $ret=$this->Promoter_model->edit_user($id);
        $this->template->load('CRM/Promoter/add_p_users', array("detail_user" => $ret));
    }

    function pedit($id)
    {
        $this->load->model('CRM/Promoter_model');
        echo $this->Promoter_model->add_users($id);
        $this->system->message(_USER._ADDED);
        redirect("/CRM/Promoter/manage");
    }
    // list of manage
    function manage($my_id=0,$state="1")
    {
        $this->load->model('CRM/Promoter_model');
        $my_id=($my_id!=0)?$my_id:$this->system->get_user();
        $result= $this->Promoter_model->manage_user($my_id, $state);
        $state= $this->Promoter_model->list_state();
        $data = array('user_details' => $result ,'state'=>$state , "my_id"=>$my_id );
        $this->template->load('CRM/Promoter/manage_user_view', $data);
    }

    public function tracks($id=0)
    {
        $id=($id==0)?$this->system->get_user:$id;
        $this->load->model('CRM/Promoter_model');
        $res=$this->Promoter_model->list_track($id);
        $ret_tmpuser=$this->Promoter_model->edit_user($id);
        $state= $this->Promoter_model->list_state();
        $this->template->load("CRM/Promoter/tracks", array("id_user"=>$id,"tracks" => $res,"tmp_user"=>$ret_tmpuser,"state"=>$state));
    }

    public function add_tracks($id)
    {
        $this->load->model('CRM/Promoter_model');
        $res=$this->Promoter_model->add_track($id);

        //make ok
        if ($res>0) {
            $this->system->message(_ADDED);
            redirect("/CRM/Promoter/tracks/".$id);
        }

        else
        {
            $this->system->message(_ERROR);
            redirect("/CRM/Promoter/tracks/".$id);
        }
    }
    public function change_state($id,$state)
    {
        $this->load->model('CRM/Promoter_model');
        if ($this->Promoter_model->change_state($id, $state)) {
            $tmp_res=$this->Promoter_model->edit_user($id);
            $tmp2_res=$this->Promoter_model->get_state($tmp_res[0]["state"]);
            if($tmp2_res[0]["submit"]) {
                $cid=$this->convert_to_client($id);
                if($cid) {
                    redirect("MaLi/pusers/users/edit/$cid");
                }
            }
            redirect("CRM/Promoter/tracks/$id");
        }

    }

}
