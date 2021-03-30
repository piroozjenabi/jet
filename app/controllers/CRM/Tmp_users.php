<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
 
class Tmp_users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->lang->load("crm");

    }

    //add tmp user
    function add()
    {
        $this->template->load('CRM/tmp_users/add_p_users');
    }


    //add users too database
    function padd()
    {
        $this->load->model('CRM/Tmp_users_model');
        $res=$this->Tmp_users_model->add_users();

        //make ok
        if ($res>0) {
            $this->system->message(_TMP_USERS._ADDED);
            redirect("/CRM/Tmp_users/manage");
        }
        //limit for make
        else if ($res == -1) {
            $this->system->message(_ERROR_LIMIT_ ." ". _TMP_USERS);
            redirect("/CRM/Tmp_users/manage");
        }
        //not maked
        else
        {
            $this->system->message(_ERROR);
            redirect("/CRM/Tmp_users/manage");
        }

    }
    //edit user
    function edit($id)
    {
        $this->load->model('CRM/Tmp_users_model');
        $ret=$this->Tmp_users_model->edit_user($id);
        $this->template->load('CRM/tmp_users/add_p_users', array("detail_user" => $ret));
    }

    function pedit($id)
    {
        $this->load->model('CRM/Tmp_users_model');
        echo $this->Tmp_users_model->add_users($id);
        $this->system->message(_USER._ADDED);
        redirect("/CRM/Tmp_users/manage");
    }

    // list of manage
    function manage($user_id=null,$state="1")
    {
        $this->load->model('CRM/Tmp_users_model');
        $statesArray= $this->Tmp_users_model->list_state();
        $typesArray= $this->Tmp_users_model->list_type();
        $this->load->helper("form");
        $this->load->library("Crud");
        $user_id=($user_id)?$user_id:$this->system->get_user();
        $this->crud->table="tmp_client";
        $this->crud->title=_CRM_MANAGE_TMP_CLIENT;
        $this->crud->column_order=array("id","state","tmp_client_type","tmp_client_peyment","name","contact","tell","mobile");
        $this->crud->column_title=array(_ID,_STATE,_TMP_TYPE,_TMP_PEYMENT,_NAME,_CONTACT,_TELL,_MOBILE);
        $this->crud->column_require=array(2,1,1,1,1,0,0,0);
        $this->crud->column_type=array("hide",json_encode(["select_db","tmp_client_state","name"]),json_encode(["select_db","tmp_client_type","name"]),json_encode(["select_db","tmp_client_peyment_type","name"]),"input","input","input","input");
        $this->crud->column_search=array("name","contact","tell","mobile");
        $this->crud->where="maker_id=$user_id AND state=$state";
        $this->crud->permision=$this->crud->render_permsion_crud("tmp_user");
        $this->crud->form_add=["maker_id"=>$user_id,"date_create"=>time()];
        if ($this->permission->check("tmp_user_manage_define")) {
            $this->crud->actions="<a class='btn btn-info' target='_blank' href='" .  site_url("/CRM/Tmp_users/manage_state/")  ."' > <i class='fa fa-circle-o-notch'> </i> "._MANAGE.__._STATE._S." </a>".
                             "<a class='btn btn-info' target='_blank' href='" .  site_url("/CRM/Tmp_users/manage_type/")  ."'  > <i class='fa fa-circle-o-notch'> </i>  "._MANAGE.__._TYPE._S." </a> <a class='btn'>|</a> ";
        }
        foreach ($statesArray as $key => $val) {
            $this->crud->actions.="<a class='btn btn-warning  ' href='".site_url("/CRM/Tmp_users/manage/$user_id/").$val["id"]."' > <i class='fa fa-search' ></i> " . $val["name"]. ' </a>';
        };
            $this->crud->actions.="<br/><br/>";

        foreach ($typesArray as $key => $val) {
            $this->crud->actions .= "<a class='btn btn-danger  ' href='".site_url("/CRM/Tmp_users/manage/$user_id/").$val["id"]."' title='". $val["des"]. "' > <i class='fa fa-search' ></i> " . $val["name"]. ' </a>';
        };

        $tmp_url=site_url("CRM/Tmp_users/tracks/".'[[id]]');
        $this->crud->actions_row= "<a class='btn btn-default' data-toggle='tooltip'  title='{_PEIGIRI._S}' target='_blank' href='$tmp_url' >  <i class='fa fa-comment-o' ></i>  </a>";;
        $this->crud->render();
        //        $result= $this->Tmp_users_model->manage_user($user_id,$state);
        //        $data = array('user_details' => $result ,'state'=>$state,"my_id"=>$my_id );
        //        $this->template->load('CRM/tmp_users/manage_user_view',$data);
    }

    //manage state of tmp client - tmp_client_state db
    //limit for maximum of create user on state
    //deafult is default value
    //enable commenting for track on tmp client
    public function manage_state()
    {
        $this->permission->check("tmp_user_manage_define", 0, 1);
        $this->load->library("Crud");
        $this->crud->table="tmp_client_state";
        $this->crud->title=_CRM_MANAGE_STATE;
        $this->crud->column_order=array("id","order_by","deafult","name","enable_edit","enable_commenting","disable_converting","limit","submit");
        $this->crud->column_title=array(_ID,_ORDER_BY,_DEFAULT,_NAME,_ENABLE_EDITING,_ENABLE_COMMENTING,_DISABLE_CONVERTING,_CRM_LIMIT,_CRM_SUBMIT);
        $this->crud->column_require=array(2,1,1,1,0,0,0,0,0);
        $this->crud->column_type=array("hide","number","bool","input","bool","bool","bool","number","bool");
        $this->crud->column_search=array("name");
        $this->crud->order=array("order_by"=>"َASC");
        $this->crud->actions="<a class='btn btn-info'  href='" .  site_url("/CRM/Tmp_users/manage/")  ."' ><i class='fa fa-circle-o-notch'> </i>  "._MANAGE.__._TMP_USERS._S." </a>".
            "<a class='btn btn-info' href='" .  site_url("/CRM/Tmp_users/manage_type_payment/")  ."'  ><i class='fa fa-circle-o-notch'> </i>  "._MANAGE.__._TMP_PEYMENT." </a> ".
            "<a class='btn btn-info' href='" .  site_url("/CRM/Tmp_users/manage_type/")  ."'  ><i class='fa fa-circle-o-notch'> </i>  "._MANAGE.__._TYPE._S." </a> ";
        $this->crud->render();
    }
    //manage  type of client - tmp_client_type db
    public function manage_type()
    {
        $this->load->library("Crud");
        $this->crud->table="tmp_client_type";
        $this->crud->title=_MANAGE.__._TYPE._S;
        $this->crud->column_order=array("id","name","des");
        $this->crud->column_title=array(_ID,_NAME,_DES);
        $this->crud->column_require=array(2,1,0);
        $this->crud->column_type=array("hide","input","input");
        $this->crud->column_search=array("name","des");
        $this->crud->actions="<a class='btn btn-info'  href='" .  site_url("/CRM/Tmp_users/manage/")  ."' > <i class='fa fa-circle-o-notch'> </i> "._MANAGE.__._TMP_USERS._S." </a>".
            "<a class='btn btn-info' href='" .  site_url("/CRM/Tmp_users/manage_type_payment/")  ."'  ><i class='fa fa-circle-o-notch'> </i>  "._MANAGE.__._TMP_PEYMENT." </a> ".
            "<a class='btn btn-info' href='" .  site_url("/CRM/Tmp_users/manage_state/")  ."'  > <i class='fa fa-circle-o-notch'> </i> "._MANAGE.__._STATE._S." </a> ";
        $this->crud->render();
    }
    //manage  type of client - tmp_client_type_peyment db
    public function manage_type_payment()
    {
        $this->permission->check("tmp_user_manage_define", 0, 1);
        $this->load->library("Crud");
        $this->crud->table="tmp_client_peyment_type";
        $this->crud->title=_MANAGE.__._TMP_PEYMENT;
        $this->crud->column_order=array("id","name","des");
        $this->crud->column_title=array(_ID,_NAME,_DES);
        $this->crud->column_require=array(2,1,0);
        $this->crud->column_type=array("hide","input","input");
        $this->crud->column_search=array("name","des");
        $this->crud->actions="<a class='btn btn-info'  href='" .  site_url("/CRM/Tmp_users/manage/")  ."' > <i class='fa fa-circle-o-notch'> </i> "._MANAGE.__._TMP_USERS._S." </a>".
            "<a class='btn btn-info' href='" .  site_url("/CRM/Tmp_users/manage_type/")  ."'  ><i class='fa fa-circle-o-notch'> </i>  "._MANAGE.__._TYPE._S." </a> ".
            "<a class='btn btn-info' href='" .  site_url("/CRM/Tmp_users/manage_state/")  ."'  ><i class='fa fa-circle-o-notch'> </i>  "._MANAGE.__._STATE._S." </a> ";
        $this->crud->render();
    }
    public function tracks($id=0,$user_id=null)
    {
        $id=($id==0)?$this->system->get_user:$id;
        $this->load->model('CRM/Tmp_users_model');
        $res=$this->Tmp_users_model->list_track($id);
        $ret_tmpuser=$this->Tmp_users_model->edit_user($id);
        $state= $this->Tmp_users_model->list_state();
        $this->template->load("CRM/tmp_users/tracks", array("id_user"=>$id,"tracks" => $res,"tmp_user"=>$ret_tmpuser,"state"=>$state,"user_id"=>$user_id));
    }

    public function add_tracks($id)
    {
        $this->load->model('CRM/Tmp_users_model');
        $res=$this->Tmp_users_model->add_track($id);
        //make ok
        if ($res>0) {
            $this->system->message(_ADDED);
            redirect("/CRM/Tmp_users/tracks/".$id);
        }

        else
        {
            $this->system->message(_ERROR);
            redirect("/CRM/Tmp_users/tracks/".$id);
        }
    }


    public function change_state($id,$state)
    {
        $this->load->model('CRM/Tmp_users_model');
        if ($this->Tmp_users_model->change_state($id, $state)) {
            $tmp_res=$this->Tmp_users_model->edit_user($id);
            $tmp2_res=$this->Tmp_users_model->get_state($tmp_res[0]["state"]);
            if($tmp2_res[0]["submit"]) {
                $cid=$this->convert_to_client($id);
                if($cid) {
                    redirect("CRM/Tmp_users/tracks/$id/$cid");
                }
            }
            redirect("CRM/Tmp_users/tracks/$id");
        }

    }

    //convert to client

    public function convert_to_client($id)
    {
        $this->load->model('CRM/Tmp_users_model');
        $tmp_res=$this->Tmp_users_model->edit_user($id);
        return $this->Tmp_users_model->convert_to_client($tmp_res);
    }
}
