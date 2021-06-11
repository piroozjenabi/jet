<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Refer extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->lang->load("auto");
    }
    //list of refers  and state
    public function index($subject_id=null)
    {
        $this->load->library("auto");
        $this->load->model("AUTO/refer_model");
        $res = $this->refer_model->list_refers($subject_id);
        loadV("AUTO/refer/refer_view", array( "forms" => $res ,"subject_id"=>$subject_id ));

    }

    // add refer controller view popup
    public function add_refer()
    {
        $id = post("id", true);
        $this->template->load_popup(
            "AUTO/refer/add_refer", _REFER, array(
            "user_id"      => $id,
            "form_id" =>post("form_id")
            )
        );
    }
    //addrefer to database by auto library
    public function padd_refer()
    {
        $flag=true;
        if(post("des", true) && post("refer", true)&& post("subject_id", true)>=1) {
            $form_id=post("form_id", true);
            $subject_id=post("subject_id", true);
            $des=post("des", true);
            $this->load->library("Auto");
            foreach ( post("refer", true) as $item )
            {
                if(!$this->auto->add_refer($form_id, $item, $des, $subject_id)) {
                    echo json_encode(array("status" => false));
                    $flag=false;
                    break;
                }
            }
            if($flag) {
                echo json_encode(array("status" => true));
            }
        }
        else {
            echo json_encode(array("status" => false));
        }
    }

    //reject refers
    public function padd_reject()
    {
        $this->load->library("Auto");
        $refer_id=post("refer_id", true);
        $des=post("des", true);
        if($this->auto->add_reject($refer_id, $des)) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }

    //accept refer button
    public function accept()
    {
        $this->load->library("Auto");
        $refer_id=post("refer_id", true);
        if($this->auto->refer_accept($refer_id)) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }



    // set refer readed
    public function read()
    {
        $this->load->library("Auto");
        $refer_id=post("refer_id", true);
        if($this->auto->refer_read($refer_id)) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }

    // set refer showed or no for exit from cartable
    public function show()
    {
        $this->load->library("Auto");
        $refer_id=post("refer_id", true);
        $state=post("show", true);
        if($this->auto->refer_show($refer_id, $state)) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }    // set refer showed or no for exit from cartable
    public function delete()
    {
        $this->load->library("Auto");
        $refer_id=post("id", true);
        if($this->auto->refer_delete($refer_id)) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }




}
