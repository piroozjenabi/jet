<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Media_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function manage($maker=0,$type=0,$id=0){
        if($maker=="mine") $maker = $this->system->get_user();
        $this->db->select("*")->from("media")->order_by("date","desc");
        if($maker) $this->db->where("maker_id",$maker);
        if($type) $this->db->where("type",$type);
        if($id) $this->db->where("type_id",$id);
        return $this->db->get()->result();  
    }
    // add emedia to database
    // TODO add full data  
    function add($data,$type=0,$id=0){
        $data = array(
            'file' => $data['file_name'],
            'maker_id'=>$this->system->get_user(),
            'type'=>$type,
            'type_id'=>$id,
        );
        return  $this->db->insert("media",$data);           
    }

    //get full detail about  upload document
    function getDetails($id){
        $this->db->select("media.*")
                 ->from('media')
                 ->where("media.id",$id);
                 
        return $this->db->get()->row();         
    }

    function edit_media($id,$post){
       return  $this->db->where("id",$id)->update("media",[
           "des" => $post["des"],
           "group_id" => $post["group"]
       ]);
    }
    /**
     * for get detial of related of media
     * if setted type in language and have table automaticaly get feail
     * 
     * @param string $type name of table on const in language file
     * @param int $id
     * @return array of name of lang and table value of name in table and des from table 
     */
    function get_type($type,$id){
        
        $name = $value = $des = null;
        if ( $type && constant("_".strtoupper($type))) $name=constant("_".strtoupper($type)); else $name = $type;
        if($this->db->table_exists($type)){
            $res = $this->db->get_where($type,"id=$id")->row();
            if (isset($res->name) && !is_null($res->name) ) $value = $res->name;
            if (isset($res->des) && !is_null($res->des) ) $des = $res->des;
        }
        return ["name" => $name , "value" => $value , "des" => $des] ;
    }

}
