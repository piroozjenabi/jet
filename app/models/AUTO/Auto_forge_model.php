<?php
class Auto_forge_model extends CI_Model
{

    // get elements from auto table and sync via below params
    public $elements=array(
        "title" =>null,
        "text" => null,
        "space" =>null,
        "input" =>array("type"=>"VARCHAR", 'constraint' => '255'),
        "number" =>array("type"=>"VARCHAR", 'constraint' => '255'),
        "word" =>array("type"=>"TEXT"),
        "date" =>array("type"=>"VARCHAR", 'constraint' => '80'),
        "file" =>array("type"=>"VARCHAR", 'constraint' => '100'),
        "submit" =>null,
        "select_bool" =>array("type"=>"INT", 'constraint' => '2'),
        "select_db"   => array("type"=>"INT", 'constraint' => '11'),
        "select_field_data_group" => array("type"=>"INT", 'constraint' => '11'),
        "select_field_data" => array("type"=>"INT", 'constraint' => '11'),
        "select_json" => array("type"=>"TEXT"));

    function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
        $this->load->library("auto");
    }


    //    ------------------------------table/start
    //add form to make database with name_en
    function add_form($id=null)
    {
        $fields=array(
            "form_value_id"=>array("TYPE"=>"int",'constraint' => '11'),
        );
        $this->dbforge->add_field("id");
        $this->dbforge->add_field($fields);
        $name_en=(isset($id))?$this->auto->render_name_en($id):$this->auto->perfix_table.post("name_en", true);
        $name_en=$this->rep_spc($name_en);
        return $this->dbforge->create_table($name_en, true);
    }
    //delete form --from database
    function delete_form($id)
    {
        $name_en=$this->auto->render_name_en($id);
        $name_en=$this->rep_spc($name_en);
        return $this->dbforge->drop_table($name_en, true);
    }
    //edit form -- rename table
    function edit_form($id)
    {
        $name_en=$this->auto->render_name_en($id);
        $name_en=$this->rep_spc($name_en);
        $this->dbforge->rename_table($name_en, $this->auto->perfix_table.post('name_en'));
        return true;
    }
    //    ------------------------------table/end

    //    ------------------------------field/start

    function add_field($form_id=null,$arr=null)
    {
        $name_en=$this->auto->render_name_en((isset($form_id))?$form_id:post("form_id"));
        $name_en=$this->rep_spc($name_en);
        $tmp=(isset($arr))?$arr:post();
        if (isset($this->elements[$tmp["type"]])) {
            $field = array(
                $this->rep_spc($tmp["name"]) => $this->rep_spc($this->elements[$tmp["type"]])
            );
            $this->dbforge->add_field($field);
            $this->dbforge->add_column($name_en, $field);
        }
    }
    //delete field
    function delete_field($id)
    {
        $res=$this->db->get_where("auto_forms_fields", "id=$id")->result_array()[0];
        if($this->elements[$res["type"]]) {
            $name_en=$this->auto->render_name_en($res["form_id"]);
            $this->dbforge->drop_column($name_en, $res["name"]);
        }


    }
    //    edit field
    function edit_field($id)
    {
        //list of value of field
        $res=$this->db->get_where("auto_forms_fields", "id=$id")->result_array()[0];
        $tmp=post();
        $name_en=$this->auto->render_name_en($tmp["form_id"]);
        $name_en=$this->rep_spc($name_en);
        if (isset($this->elements[$tmp["type"]])) {
            $tmparr=$this->elements[$tmp["type"]];
            $tmparr["name"]=$tmp["name"];
            $field = array(
                $this->rep_spc($res["name"]) => $this->rep_spc($tmparr)
            );
            $this->dbforge->modify_column($name_en, $field);
        }
        return true;

    }

    //delete space and replace with under line
    function rep_spc($in)
    {
        return str_replace(" ", "_", $in);
    }
    //    ------------------------------field/end


    function del_cr_forms($id)
    {
        $this->delete_form($id);
        if(!$this->add_form($id)) {
            return false;
        }
        $res= $this->db->get_where("auto_forms_fields", "form_id=$id")->result_array();
        foreach($res as $key => $value){
            $this->add_field($id, array("name"=>$value["name"],"type"=>$value["type"]));
        }
        return true;
    }
}
