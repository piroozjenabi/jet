<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Prd_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }

    //add prd
    public function add_prd($id="")
    {

        $data= array( );
        $data["id"]=$id;
        $data["name"]=$this->input->post("name", true);
        $data["price1"]=$this->input->post("price1", true);
        $data["price2"]=$this->input->post("price2", true);
        $data["price3"]=$this->input->post("price3", true);
        $data["price4"]=$this->input->post("price4", true);
        $data["group_id"]=$this->input->post("group_id", true);
        $data["state"]="1";
        $data["vahed_asli"]=$this->input->post("vahed_asli", true);
        $data["url"]=$this->input->post("url", true);
        $data["tax"]=$this->input->post("tax", true);
        $data["company"]=$this->input->post("company_maker", true);
        $data["pic"]=$this->input->post("pic", true);
        $data["file"]=$this->input->post("file", true);
        $data["fani_number"]=$this->input->post("fani_number", true);
        $data["barcode"]=$this->input->post("barcode", true);
        $data["country"]=$this->input->post("country_maker", true);
        if (!$id) {
            $this->permision->check("prd_add", true);
            return $this->db->insert('prd', $data);
        }
        else{
            $this->permision->check("prd_edit", true);
            $this->db->where("id", $id);
            return $this->db->update('prd', $data);
        }

    }

    //manage user model
    public function manage_prd()
    {
        $this->db->select("*");
        $this->db->from('prd');
        return $this->db->get()->result_array();
    }

    //manage prd group
    public function manage_groups()
    {
        $this->db->select("*");
        $this->db->from('prd_group');
        return $this->db->get()->result_array();
    }

    //delete prd
    public function manage_delete($prd_id=0)
    {
        $this->permision->check("prd_delete", true);
        $this->db->where('id', $prd_id);
        return     $this->db->delete('prd');
    }

    //edit prd
    public function edit_prd($id)
    {
        $this->db->select("*");
        $this->db->from('prd');
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }
}
