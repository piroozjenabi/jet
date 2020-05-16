<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 * state of refer
 *      0 unread
 *      1 read and accept
 *      2 reject
 */
class Auto{
    //array to elements --a1
    public $elements=array(
        "title" =>_TITLE_TEXT,
        "text" =>_DES,
        "space" =>_SPACE,
        "input" =>_INPUT,
        "number" =>_NUMBER_INPUT,
        "word" =>_EDITOR,
        "date" =>_DATE,
        "file" =>_FILE,
        "submit" =>_SUBMIT,
        "select_bool" =>_SELECT_BOOL,
        "select_db"   => _SELECT_DB,
        "select_field_data_group" => _SELECT_FIELD_DATA_GROUP,
        "select_field_data" => _SELECT_FIELD_DATA,
        "select_json" => _SELECT_MANUAL_JSON‌);

    // to make table need this for database in form
    var $perfix_table="form__";

    //history of auto forms 1->add 2->edit 3->delete 4->refer 5->reject 6->accept refer
    public $history=array(
        "1"=> _ADD,
        "2"=> _EDIT,
        "3"=> _DELETE,
        "4"=> _REFER,
        "5"=> _ACCEPT,
        "6"=> _REJECTED,

    );

    //return list of elements--a2
    public function list_elements()
    {
       return $this->elements;
    }
    //-------------state----a3
		function print_state($state)
		{
			switch ($state)
			{
				case 0:
					return _UNREAD;
					break;
				case 1:
					return _ACCEPTED;
					break;
				case 2:
					return _REJECTED;
					break;
				default :_UNDEFINED	;
			}
		}
	//state_end
//---------------------------------------------------make form start
    //render to view form--a4
    public function render_form($form_id,$id_edit=null,$mode="edit")
    {
        $CI =& get_instance();
        $out="<div class=' well row modal-body'>";
        $fields=$this->fields($form_id);
        $CI->load->helper('form');
        $out.=form_open_multipart();
        $out.=form_input("auto_refer",0,array("id"=>"auto_refer","style"=>"display:none"));
        $out.=form_hidden("form_id",$form_id,array("id"=>"form_id"));
        //get value for edit -- edit mode
        if(@$id_edit){
            $name_en=$this->render_name_en_from_form_value_id($id_edit);
            $res=$CI->db->get_where($name_en,"form_value_id=$id_edit")->result_array()[0];
            $out.=form_hidden("form_value_id",$id_edit);

        }

        foreach ($fields as $k => $v)
        {
            $v["value"]="";
            //for edit
            if(@$id_edit)
            {
                $tmp_edit=$this->get_filed_name($v["id"]);
                $v["value"]=(@$res[$tmp_edit])?$res[$tmp_edit]:"";
            }
            $v["form_id"]=$form_id;
            $out.=($mode=="edit")?$this->{$v["type"]}($v):$this->view($v);
        }
        $out.=form_close()."</div>";
        return $out;
    }

    //get form fields from form id --a5
    public function fields($form_id=null)
    {
        $CI =& get_instance();
        $CI->db->select("*");
        if($form_id) $CI->db->where("form_id",$form_id);
        $CI->db->order_by("order_by","ACSC");
        $CI->db->from("auto_forms_fields");
        return $CI->db->get()->result_array();
    }

      //add form
    function add_forms_record($form_id,$edit_id=null)
    {
        $CI =& get_instance();
        $user_id= $CI->system->get_user();
        $data=array();
        $data_form_value=array();
        //get input method and inset into array
        foreach ($CI->input->post(null,true)as $key => $value)
        {
            $tmp=$this->get_filed_name($key);
            if($tmp)
            $data[$tmp]=$value;

        }
//        get files
        foreach ($_FILES as $key => $value)
        {
            $tmp=$this->get_filed_name($key);
            if($tmp)
                $data[$tmp]=$value;
        }

        $data=$this->conver_filed_for_save($data,$form_id);
        //edit mode
        if($edit_id)
        {
            $data_form_value["modify_date"]=time();
            $data_form_value["modifire_id"] = $user_id;
            $CI->db->update('auto_forms_value', $data_form_value,"id=$edit_id");
            $CI->db->update($this->render_name_en($form_id),$data,"form_value_id=$edit_id");
            $main_id=$edit_id;
        }
        else
            {
            $data_form_value["date"]=time();
            $data_form_value["maker_id"] = $user_id;
            $data_form_value["form_id"] = $form_id;
            $data_form_value["number"] = $this->generate_form_number($form_id);
            $CI->db->insert('auto_forms_value', $data_form_value);
            $main_id=$CI->db->insert_id();
            $data['form_value_id']=$main_id;
            $CI->db->insert($this->render_name_en($form_id), $data);
//            $main_id = $CI->db->insert_id();
        }
       //get name of table
       return $main_id;
    }

    //convert fields for save in db
        function conver_filed_for_save($data,$form_id){
            $CI =& get_instance();

            $tmp=$CI->db->get_where("auto_forms_fields","form_id= $form_id")->result_array();

            foreach ($tmp as $key => $value)
            {
                // converting by type
                //exam : if date convert to timetamp
                      switch ($value["type"]){
                          //for date mode
                          case "date":
                              $data[$value["name"]]=strtotime($data[$value["name"]]);
                              break;
                      }
            }
            return $data;

        }

    // make name en for do operation-- renfer name of form
     function render_name_en($id)
     {
         $CI=get_instance();
         $name_en=$CI->db->get_where("auto_forms","id=$id")->result_array()[0]["name_en"];
         return $this->perfix_table.$name_en;
     }
     // make name en for do operation-- renfer name of form from fprm value id
     function render_name_en_from_form_value_id($id)
     {
         $CI=get_instance();
         $res_tmp=$CI->db->get_where("auto_forms_value","id=$id")->result_array()[0];
         return $this->render_name_en($res_tmp["form_id"]);

     }
    // get filed name by id
    function get_filed_name($id)
    {
        $CI=& get_instance();
        $res =$CI->db->select("name")
            ->from("auto_forms_fields")
            ->where("id",$id)
            ->get()->result_array();
        if($res)
            return $res[0]["name"];
        else
            return false;
    }

    //get auto refer
    function get_auto_refer_user($form_id)
    {
        $CI=& get_instance();
        return $CI->db->get_where("auto_auto_refer_user","form_id=$form_id")->result_array();
    }
//generate number for forms number
    function generate_form_number($form_id)
    {
        $fin_id=null;
        $CI =& get_instance();
        $tmp=$CI->system->get_setting("form_number_mode");
        if ($tmp=="iso")
        {
            $CI ->db->select_max('number');
            $fin_id = $CI->db->get('auto_forms_value')->result_array()[0]['number'];
            $fin_id++;
        }
        elseif ($tmp=="normal")
        {
            $CI ->db->select_max('number');
            $CI ->db->where('form_id',$form_id);
            $fin_id = $CI->db->get('auto_forms_value')->result_array()[0]['number'];
            $fin_id++;
        }

        return $fin_id;

    }
    //render validate for auto add if all thing ok return1 else return error
    function add_validate()
    {
        $CI=&get_instance();
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        foreach ($CI->input->post(null,true) as $key => $value)
        {
            $tmp=$CI->db->get_where("auto_forms_fields" , "id = '$key' ")->row();
                //for required
                if(isset($tmp->required) && $value=='')
                {
                    $data['inputerror'][] = $key;
                    $data['error_string'][] = $tmp->des.__. _IS_REQUIRED.'<br>' ;
                    $data['status'] = FALSE;
                }
                //for min
                if(isset($tmp->min) && $tmp->min > 0 && isset($value) && $value < $tmp->min)
                {
                    $data['inputerror'][] = $key;
                    $data['error_string'][] = $tmp->des.__._OUT_OF_RENGE."["._MIN." = ".$tmp->min."]".'<br>' ;
                    $data['status'] = FALSE;
                }
                if(isset($tmp->max) &&  $tmp->max > 0 && isset($value) && $value > $tmp->max)
                {
                    $data['inputerror'][] = $key;
                    $data['error_string'][] =  $tmp->des.__._OUT_OF_RENGE."["._MAX." = ".$tmp->max."]".'<br>' ;
                    $data['status'] = FALSE;
                }
        }

        if($data['status'] === FALSE)
            return $data;
        else
            return 1;
    }

//  add history of auto type= 1->add 2->edit 3->delete 4->refer 5->reject 6->accept refer
    function add_history($form_id,$type=1,$record_id=null,$user_id=null,$params=null)
    {
        $CI=&get_instance();
        $data=array("form_id"=>$form_id,"record_id"=>$record_id,"date"=>time(),"type"=>$type,"params"=>$params);
        if(!isset($user_id))$data["user_id"]=$CI->system->get_user();
        return $CI->db->insert("auto_form_history",$data);
    }
//    get history of form
    function get_history($form_id=null,$type=null,$user_id=null)
    {
        $CI=&get_instance();
        $CI->db->select("*")
            ->from("auto_form_history");
            if($form_id) $CI->db->where("form_id",$form_id);
            if($type) $CI->db->where("type",$type);
            if($user_id) $CI->db->where("user_id",$user_id);
        return $CI->db->get()->result_array();
    }
//  add fields value secend step
    function add_fields_value ($id,$value,$form_value_id,$params=array())
    {
        $CI =& get_instance();
        if ($this->get_fields($id)[0]["type"]=="date") $value=strtotime($value);
        if ($this->get_fields($id)[0]["type"]=="file") {
            $tmp = $CI->element->do_upload($id);
            if($tmp["op"])
            {
                $value=$tmp["upload_data"]["file_name"];
            }
            else{
                return 0;
            }
        }
        $data=array('field_id' => $id
        ,'value' =>$value
        ,'maker_id' => $CI->system->get_user()
        ,'form_value_id' => $form_value_id
        ,'date' => time()
        ,'params' =>json_encode($params));
        return $CI->db->insert("auto_fields_value",$data);

    }

    function get_auto_history_type($type)
    {
        return $this->history[$type];
    }
	//---------------------------------------------------make form end

    //form element start ---------------------------------------------


    //input type
    function view($in)
    {
        $tmp_value=$this->render_view($in["name"],$in["value"]);
        if(!$tmp_value)
            return null;
        else
        $in["value"]=$tmp_value;
        return "<div class='" .$in["parent_class"]." well' > <label>".$in["des"]." </label> : ".$in["value"]. "</div>";
    }

    public function render_view($name_col,$value)
    {
        $CI =& get_instance();
        $CI->load->library('Piero_jdate');
        $arr=$CI->db->get_where("auto_forms_fields","name= '$name_col'")->result_array()[0];
        switch ($arr["type"]){
            case "date":
                return $CI->piero_jdate->jdate("Y/m/d",$value);
                break;
            case "file":
                return $CI->element->view_file($value);
                break;
            case "input":
                return $value;
            case "number":
                    if (is_integer($value))
                        return number_format($value);
                    else
                        return $value;
                break;
            case "select_field_data":
               $tmp= $CI->db->get_where("auto_forms_field_data","id=".$value)->row();
                return (isset($tmp)?$tmp->name:null) ;
                break;
            default:
                return false;
        }
    }


    //
    //title
    function input($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        return "<div  class='".$in["parent_class"]."' > <label>".$in["des"]." </label> ". form_input(array('id'=>$in["id"], 'placeholder' => $in["des"],'name' => $in["id"],'class'=>$in["class"],'style'=>$in["style"],'value'=>$in["value"])) . "</div>";


    }    //title
    function number($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        return "<div class='".$in["parent_class"]."' > <label>".$in["des"]." </label> ". form_input(array('id'=>$in["id"],'type'=>"number","step"=>"4", 'name' => $in["id"],'class'=>$in["class"],'style'=>$in["style"],'value'=>$in["value"])) . "</div>";


    }

    //view title
    function title($in)
    {
        $id=$in["id"];
        $class=$in["class"];
        $style=$in["style"];
        $des=$in["des"];
        $CI =& get_instance();
        $CI->load->helper('form');
        return "<div class='".$in["parent_class"]."' ><h1 id='$id' class='$class' style='$style' > $des </h1> </div>";
    }
    //view text
    function text($in)
    {
        $id=$in["id"];
        $class=$in["class"];
        $style=$in["style"];
        $des=$in["des"];
        $CI =& get_instance();
        $CI->load->helper('form');
        return "<div class='".$in["parent_class"]."' ><span id='$id' class='$class' style='$style' > $des </span> </div>";
    }
    //view SPACE
    function space($in)
    {
        $id=$in["id"];
        $class=$in["class"];
        $style=$in["style"];
        $des=$in["des"];
        $CI =& get_instance();
        $CI->load->helper('form');
        return "<div class='".$in["parent_class"]." $class'  id='$id'  style='$style' > </div>";
    }
    //input type
    function file($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        $out=($in["value"])?$CI->element->view_file($in["value"],"200px"):null;
        $out.= "<div class='".$in["parent_class"]."' > <label>".$in["des"]." </label> ". $CI->element->input_file(array('id'=>$in["id"],'name' => $in["id"],'class'=>$in["class"],'style'=>$in["style"])) . "</div>";
        return $out;

    }
    //load editor word
    function word($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        $CI->load->library("element");
        return $CI->element->load_editor($in["id"]).
            "<div class='".$in["parent_class"]."' > ". form_textarea(array('id'=>$in["id"], 'placeholder' => $in["des"],'name' => $in["id"],'class'=>$in["class"],'style'=>$in["style"],'value'=>$in["value"])) . "</div>";

    }
    //input type
    function date($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        return "<div class='".$in["parent_class"]."' > <label>".$in["des"]." </label> ". $CI->element->input_date($in["id"],$in["value"],$in["class"] , $in["style"])  . "</div>";
    }


    //load submit
    function submit($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        $btn=form_button(array('type' => "button","onclick"=>"submit_auto()", 'class'=>$in["class"]." submit",'style'=>$in["style"]),$in["des"]);
        if($this->get_auto_refer_user($in["form_id"])){
            $btn.=form_button(array('type' => "button","onclick"=>"submit_and_auto_refer()",'class'=>$in["class"]." submit",'style'=>$in["style"]),_SAVE2._AND._SEND);
            $btn.="<div class='loading submitloading' style='display: none'> </div>";
        }
        return "<div class='".$in["parent_class"]."'>".$btn ."</div>";
    }

    //select elements start
    //true or false element
    function select_bool($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');

        $select=form_dropdown($in["id"],array(0=>_FALSE,1=>_TRUE),$in["value"],array('class'=>$in["class"],'style'=>$in["style"]));
        return "<div class='".$in["parent_class"]."' > <label>".$in["des"]." </label> ".$select . "</div>";

    }
    //select from data in params
    function select_json($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        $data=json_decode($in["params"])->data;
        $select=form_dropdown($in["id"],$data,$in["value"],array('class'=>$in["class"],'style'=>$in["style"]));
        return "<div class='".$in["parent_class"]."' > <label>".$in["des"]." </label> ".$select . "</div>";
    }
    //select from table data base
    function select_db($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        $CI->load->library('Element');
        $tmp=json_decode($in["params"]);
        $data=$CI->element->pselect($tmp->table,(isset($tmp->name))?$tmp->name:"name" , (isset($tmp->postfix))?$tmp->postfix:"",(isset($tmp->def))?$tmp->def:_DEF_ELEMENT,(isset($tmp->where))?$tmp->where:"");
        $select=form_dropdown($in["id"],$data,$in["value"],array('class'=>$in["class"],'style'=>$in["style"]));
        return "<div class='".$in["parent_class"]."' > <label>".$in["des"]." </label> ".$select . "</div>";
    }

    //select data base field data
    function select_field_data($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        $CI->load->library('Element');
        $data=$CI->element->pselect("auto_forms_field_data","name",null,_DEF_ELEMENT,"group_id=".json_decode($in["params"])->data_group);
        $select=form_dropdown($in["id"],$data,$in["value"],array('class'=>$in["class"],'style'=>$in["style"]));
        return "<div class='".$in["parent_class"]."' > <label>".$in["des"]." </label> ".$select . "</div>";
    }
    //select data base field data
    function select_field_data_group($in)
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        $CI->load->library('Element');
        $tmp=$CI->db->select("*")
            ->where("parent",json_decode($in["params"])->data_parent)
            ->from("auto_forms_field_data_group")
            ->get()->result_array();

        $arr=array();
        $arr[""]="";
        foreach ($tmp as $k => $v)
        {
            $arr[$v["name"]]=$CI->element->pselect("auto_forms_field_data","name",null,"no","group_id=".$v["id"]);

        }

        $select=form_dropdown($in["id"],$arr,$in["value"],array('class'=>$in["class"],'style'=>$in["style"]));
        return "<div class='".$in["parent_class"]."' > <label>".$in["des"]." </label> ".$select . "</div>";
    }
    //select elements end
    //form element end ---------------------------------------------
    //return details of form value
    function get_form_from_id($id){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->where("id",$id);
        $CI->db->from("auto_forms_value");
        return $CI->db->get()->result_array();
    }

    //manage------------------
    //list of forms from tree id
    function list_forms($group=null)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from("auto_forms");
        if ($group)$CI->db->where('tree_id',$group);
        $CI->db->where('enable',1);
        return $CI->db->get()->result_array();
    }

    function get_form_from_value_id($id)
    {
    	$tmp=$this->get_form_from_id($id)[0]["form_id"];
	    $CI =& get_instance();
	    $CI->db->select('*');
	    $CI->db->where("id",$tmp);
	    $CI->db->from("auto_forms");
	    return $CI->db->get()->result_array();
    }


    //get forms info
    function get_forms($where)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from("auto_forms_value");
        if ($where)$CI->db->where($where);
        return $CI->db->get()->result_array();
    }

    //list of tree
    function list_tree($tree=null)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from("auto_forms_tree");
        if ($tree)$CI->db->where('parent_id',$tree);
        return $CI->db->get()->result_array();
    }


    //list of field_data_group
    function list_field_data_group()
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from("auto_forms_field_data_group");
        return $CI->db->get()->result_array();
    }

    //list of field_data
    function list_field_data($group_id=null,$select="*")
    {
        $CI =& get_instance();
        $CI->db->select($select);
        $CI->db->from("auto_forms_field_data");
        if ($group_id)$CI->db->where('group_id',$group_id);
        return $CI->db->get()->result_array();
    }

    //list of field_from_form_id
    function list_field_from_id($form_id=null,$select="*",$order=array("field"=>"order_by","role"=>"ASC"))
    {
        $CI =& get_instance();
        $CI->db->select($select);
        $CI->db->from("auto_forms_fields");
        $CI->db->order_by($order["field"],$order["role"]);
        if ($form_id)$CI->db->where('form_id',$form_id);
        return $CI->db->get()->result_array();
    }



    function list_value_form()
    {
        $CI =& get_instance();
        $user=$CI->system->get_user();
        $CI->db->select('* , auto_forms_value.id as mainid ,auto_forms_value.maker_id as maker_id')
               ->from("auto_forms_value")
               ->where("auto_forms_value.maker_id",$user)
	           ->order_by("auto_forms_value.id",'DESC')
	           ->limit(200)
               ->join("auto_forms",'auto_forms_value.form_id=auto_forms.id');
        return $CI->db->get()->result_array();
    }

    //get value filled // لیست مقادیر فیلدها
    function get_value_fields($form_id,$field_id=null)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from("tbl_auto_fields_value");
        $CI->db->where("form_value_id",$form_id);
        if ($field_id) $CI->db->where("field_id",$field_id);
        return $CI->db->get()->result_array();
    }
    //show list
    function show_list($id){
        $CI =& get_instance();
        $name_en=$this->render_name_en_from_form_value_id($id);
        $CI->load->library('Piero_jdate');
        $CI->db->select('*')
                ->where('form_value_id',$id)
                ->from($name_en);
//        $CI->db->join('tbl_auto_forms_fields',"auto_fields_value.field_id=tbl_auto_forms_fields.id");
//        $CI->db->where('tbl_auto_forms_fields.show_list',1);

        $tmp=null;
        foreach ($CI->db->get()->result_array()[0] as $k => $v)
        {
            if($k !="id" && $k !="form_value_id")
            $tmp.= " - "."<span data-toggle='tooltip' title='".$k."'>".$this->render_view($k,$v)."</span>";
//            $tmp.= " - "."<span data-toggle='tooltip' title='".$v["des"]."'>". $CI->auto->render_view(array("value"=>$v["value"],"type"=>$v["type"]))."</span>";
        }

        return $tmp;


    }


    // get propertis of fileds from id
    function get_fields($id=null,$id_form=null)
    {
        $CI =& get_instance();
        $CI->db->select('*');
        if($id)$CI->db->where('id',$id);
        if($id_form)$CI->db->where('form_id',$id_form);
        $CI->db->order_by('order_by');
        $CI->db->from('tbl_auto_forms_fields');
        return $CI->db->get()->result_array() ;
    }
    // get propertis of fileds from name
    function get_fields_from_name($name)
    {
        $CI =& get_instance();
        $CI->db->select('*')
        ->where('name',$name)
        ->from('tbl_auto_forms_fields');
        return $CI->db->get()->row() ;
    }


    //delete form value || حذف اطلاعات نامه
    public  function delete_form_value($id){
//    $this->delete_field_value($id);
    $CI =& get_instance();
    $CI->db->where('id',$id);
    return $CI->db->delete('tbl_auto_forms_value');
    }


    //--------------------------------------------refer start

    function get_refer($id){
        $CI =& get_instance();
        return $CI->db->get_where("auto_froms_refer" ,"id=$id")->row();
    }

    //list_of subject refer
    public function list_subject_refer()
	{
		$CI =& get_instance();
		return $CI->db->get('auto_refer_subject')->result_array();

	}


	function add_refer($form_id,$to,$des=null,$subject_id=null,$params=null,$all=false)
	{
		$CI=&get_instance();
		$user_id=$CI->system->get_user();
		$data=array(
			"form_value_id"=>$form_id,
			"from_user_id"=>$user_id,
			"to_user_id"=>$to,
			"des"=>$des,
			"subject_id"=>$subject_id,
			"date"=>time()
		);
		//all can see refers
		$tmp =$CI->db->insert("auto_froms_refer",$data);
		if($tmp)
		{
			$CI->load->library("Alerts_lib");
			$CI->alerts_lib->add_alert(5,array("id"=>$form_id),time(),$des,array( "0" => array("id" => $to)));
			$this->add_history($form_id,4);
			return true;
		}
		else
			return false;
	}

//   automatic refer for users
	function auto_refer($form_id,$form_number)
    {
        $CI=&get_instance();
        $res=$CI->db->get_where("auto_auto_refer_user","form_id=$form_number")->result_array();

        foreach ($res as $key => $value){
            if($value["state"])
            $this->add_refer($form_id,$value["user_id"],$value["des"],1,array(),true);
            $this->add_history($form_id,4);
        }
        return true;

    }
//reject of refer
	function add_reject($refer_id,$des,$params=array())
	{
        $CI=&get_instance();
		$params["date_reject"]=time();
		$params["des_reject"]=$des;
        $params["user_reject"]=$CI->system->get_user();
		$data=array(
			"state"=>2,
			"show"=>false,
			"params"=>json_encode($params)
		);
		$CI->db->where("id",$refer_id);
		$tmp_res= $CI->db->update("auto_froms_refer",$data);
		if($tmp_res){
		    $tmp_refer=$this->get_refer($refer_id);
            $this->add_history($tmp_refer->form_value_id,5);
		    return $CI->alerts_lib->add_alert(6,array("id"=>$tmp_refer->form_value_id),time(),$des,array( "0" => array("id" => $tmp_refer->from_user_id)));
        }
		else
		    return false;

	}
	function refer_accept($refer_id,$params=array())
	{
        $CI=&get_instance();
        $user=$CI->system->get_user();
        $params["date_accept"]=time();
		$params["user_accept"]=$user;
		$data=array(
			"state"=>1,
			"params"=>json_encode($params),


		);
		$CI->db->where("id",$refer_id);
		$tmp_res= $CI->db->update("auto_froms_refer",$data);
		if($tmp_res)
        {
            $tmp_refer=$CI->db->get_where("auto_froms_refer","id=$refer_id")->row();
            $this->add_history($tmp_refer->form_value_id,6);
            return true;
        }

		else
		    return false;


	}

	//set state read for refer
	function refer_read($refer_id)
	{
		$CI=&get_instance();
		if (is_null($CI->db->select("read")->from("auto_froms_refer")->where("id",$refer_id)->get()->result_array()[0]["read"])) {
			$data = array( "read" => time(), );
			$CI->db->where( "id", $refer_id );
			return $CI->db->update( "auto_froms_refer", $data );
		}
		return true;
	}
	//set state show for refer
	function refer_show($refer_id,$state)
	{
		$CI=&get_instance();
		$data=array( "show"=>$state, );
		$CI->db->where("id",$refer_id);
		return $CI->db->update("auto_froms_refer",$data);

	}

	//set state show for refer
	function refer_delete($refer_id)
	{
		$CI=&get_instance();
		$user_id=$CI->system->get_user();
		if( ($this->get_refer($refer_id)->from_user_id != $user_id) && ! $CI->permision->check("auto_refer_delete"))
		    return 0;

		$CI->db->where("id",$refer_id);
		return $CI->db->delete("auto_froms_refer");

	}
    //alowed user to refer
    function list_user_refer()
    {
        $CI=&get_instance();
        $ug=$CI->system->get_user("usergroup");//        self user group
        $father_ug=$CI->db->get_where("usergroup_eemploy","id=$ug")->result_array()[0]["parent"]; // parent of self
        $in=array($father_ug);
        $bro_ug=$CI->db->get_where("usergroup_eemploy","parent=".$father_ug)->result_array(); // parent of self
        $child_ug=$CI->db->get_where("usergroup_eemploy","parent=$ug")->result_array(); // parent of self
        foreach (array_merge($bro_ug,$child_ug) as $key =>$value)
        {
         $in[]=$value["id"];
        }
        $CI->db->select("*")
            ->from("user_eemploy")
            ->where_in("usergroup",$in);
        return $CI->db->get()->result_array() ;

    }

    //list of refer from form value id
    function list_refer_from_id($id,$where=null)
    {
        $CI=&get_instance();
        $CI->db->select("*")
            ->from("auto_froms_refer")
            ->where("form_value_id",$id);
        if($where) $CI->db->where($where);
        return $CI->db->get()->result_array() ;
    }
    //list of refer from form value id
    function list_refer_accepted($id)
    {
        $CI=&get_instance();
        $CI->db->select("*")
        ->from("auto_froms_refer")
        ->where("form_value_id",$id)
        ->where("state",1);
        return $CI->db->get()->result_array() ;
    }
    //--------------------------------------------refer end
    //--------------------------------------------op start

//        function  for operation in auto

// value is array from refer_id ==> id from refer , $main_id ==> form value id  , f_id ==>form_id
//    type for show exit kartable if type == exited dont show btn exit from kartable
    function render_op_refer($refer_id,$type="exited",$style_btn="btn btn-link")
    {
        $CI=&get_instance();
        $user_id=$CI->system->get_user();
        $op=[];

        $data=$this->get_refer($refer_id);
        $main_id=$data->form_value_id;
        $flag_mine=($data->from_user_id==$user_id)?true:false;
        $flag_accept=(count($CI->auto->list_refer_accepted($main_id))>0)?true:false;

        if (($flag_mine && $CI->permision->check("auto_accept") && !$flag_accept) || ($CI->permision->check("auto_accept_all") && !$flag_accept) )
            $op[]=" <a class='$style_btn' id='accept_refer_$refer_id' onclick=\"accept_refer('$refer_id')\"'> <i class='fa fa-check'></i> "._ACCEPT."  </a>";
        //for reject
        //if not accepted and is mine and have permission reject
        if ((!$flag_accept && $flag_mine) || ($CI->permision->check("auto_reject"))  )
            $op[]="<a class='$style_btn' id='reject_$refer_id' onclick=\"reject_refer('$refer_id')\" > <i class='fa fa-share'></i> "._AUTO_REJECT ." </a>";

        //for refer
        //if not accepted and is mine and have permission refer
        if ((!$flag_accept && $flag_mine )|| $CI->permision->check("auto_refer") ){
            $refer_link = site_url("AUTO/Refer/add_refer");
            $op[] = "<a class='$style_btn' id='refer' onclick=load_ajax_popup('$refer_link','form_id=$main_id')> <i class='fa fa-link' ></i> " . _REFER . ' </a>';

        }
        // for edit and delete
        if(($flag_mine && !$flag_accept) || $CI->permision->check("auto_edit_after_accepted") )
        {
            //delete
            $op[]= "<a class='$style_btn' id='delete_$refer_id' onclick='piero_confirm(del_refer,$refer_id)' > <i class='fa fa-close' ></i> "._DELETE. '</a>';

        }

        //            for exit kartable
        if(($flag_mine && $flag_accept ) || $CI->permision->check("auto_edit_after_accepted") )
            if( $type != "exited")
                $op[]="<a class='$style_btn'  onclick=exit_kartable('$refer_id') > <i class='fa fa-close'></i> "._EXIT_FROM_KARTABLE ." </a>";

        return $op;

    }

    function render_op_refer_js()
    {
        ?>
        <script type="text/javascript">
            function reject_refer(_id) {
                (new PNotify({
                    title: '<?=_AUTO_REJECT ?>',
                    text: '<?=_DES.__._AUTO_REJECT ?>',
                    icon: 'fa fa-5x fa-share',
                    hide: false,
                    confirm: {
                        prompt: true,
                        prompt_multi_line: true,

                    },
                    buttons: {
                        closer: false,
                        sticker: false
                    },
                    history: {
                        history: false
                    }
                })).get().on('pnotify.confirm', function(e, notice, val) {

                    $.ajax({
                        url : "<?= site_url("AUTO/Refer/padd_reject") ?>",
                        type: "POST",
                        dataType: "JSON",
                        "data": "refer_id="+_id+"&des="+$('<div/>').text(val).html(),
                        success: function(data)
                        {
                            if(data.status)
                            {
                                piero_message();

                                $("#row_"+_id).hide(1000);
                            }
                            else
                            {
                                piero_alert();

                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            piero_alert("<?=_ERROR ?>","<?=_ERROR_AJAX ?>");
                        }
                    });

                }).on('pnotify.cancel', function(e, notice) {

                });

            }
            function accept_refer(_id) {


                $.ajax({
                    url : "<?= site_url("AUTO/Refer/accept") ?>",
                    type: "POST",
                    dataType: "JSON",
                    "data": "refer_id="+_id,
                    success: function(data)
                    {
                        if(data.status)
                        {
                            piero_message();
                            $("#row_"+_id).css("background","#80CBC4");
                            $("#edit_"+_id).hide(20);
                            $("#delete_"+_id).hide(20);
                            $("#accept_refer_"+_id).hide(20);
                            $("#reject_"+_id).hide(20);

                        }
                        else
                        {
                            piero_alert();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        piero_alert("<?=_ERROR ?>","<?=_ERROR_AJAX ?>");
                    }
                });
            }
            function exit_kartable(_id) {

                $.ajax({
                    url : "<?= site_url("AUTO/Refer/show") ?>",
                    type: "POST",
                    dataType: "JSON",
                    "data": "refer_id="+_id+"&show='false'",
                    success: function(data)
                    {
                        if(data.status)
                        {
                            piero_message();
                            $("#row_"+_id).hide(1000);
                        }
                        else
                        {
                            piero_alert();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        piero_alert("<?=_ERROR ?>","<?=_ERROR_AJAX ?>");
                    }
                });


            }

            //delete aleret
            function del_refer(_id) {
                $.ajax({
                    url: "<?= site_url("/AUTO/refer/delete") ?>",
                    type: "POST",
                    dataType: "JSON",
                    "data": "id=" + _id,
                    success: function (data) {
                        if (data.status) {
                            piero_message();
                            $("#row_" + _id).hide(300);
                        }
                        else {
                            piero_alert();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        piero_alert("<?=_ERROR ?>", "<?=_ERROR_AJAX ?>");
                    }
                });
            }


        </script>

        <?php
    }

//    ------------------------------------------------------------------form

// value is array from refer_id ==> id from refer , $main_id ==> form value id  , f_id ==>form_id
//    type for show exit kartable if type == exited dont show btn exit from kartable
    function render_op_form($value,$style_btn="btn btn-link"){
        $CI=&get_instance();
        $op=[];
			$refer_id=$value["id"];
			$main_id=$value["mainid"];
			$f_id=$value["f_id"];
            $user_id=$CI->system->get_user();

			$revive_user=$this->list_refer_from_id($main_id,"to_user_id=$user_id");
			//is mine refer
            $flag_mine=($revive_user)?true:false;
            //as accepted refer
            $flag_accept=(count($CI->auto->list_refer_accepted($main_id))>0)?true:false;
            //for refer
            //if not accepted and is mine and have permission refer
            if ((!$flag_accept && $flag_mine )|| $CI->permision->check("auto_refer") ){
                $refer_link = site_url("AUTO/Refer/add_refer");
                $op[] = "<a class='$style_btn' id='refer' onclick=load_ajax_popup('$refer_link','form_id=$main_id')> <i class='fa fa-link' ></i> " . _REFER . ' </a>';

            }
            // for edit and delete
            if(($flag_mine && !$flag_accept) || $CI->permision->check("auto_edit_after_accepted") )
            {

                $edit_link = site_url("/AUTO/add_form/edit/$f_id/$main_id");
                $op[]= "<a id='edit_$refer_id' class='$style_btn' href='$edit_link' > <i class='fa fa-edit' ></i> "._EDIT. '</a>';
                //delete
                $op[]= "<a class='$style_btn' id='delete_$refer_id' onclick='piero_confirm(del,$main_id)' > <i class='fa fa-close' ></i> "._DELETE. '</a>';

            }

			//ajax refer
            return $op;


    }

    function render_op_form_js()
    {
        ?>
        <script type="text/javascript">
            //delete aleret
            function del(_id) {
                $.ajax({
                    url: "<?= site_url("/AUTO/add_form/delete") ?>",
                    type: "POST",
                    dataType: "JSON",
                    "data": "id=" + _id,
                    success: function (data) {
                        if (data.status) {
                            piero_message();
                            $('.modal').modal('hide');
                            $("#row_" + _id).hide(500);
                        }
                        else {
                            piero_alert();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        piero_alert("<?=_ERROR ?>", "<?=_ERROR_AJAX ?>");
                    }
                });
            }


        </script>

        <?php
    }
    //--------------------------------------------op end
}
