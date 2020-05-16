<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Page
{

    public $count_allpg=200;
    public $limit_allpg=0;

    public function __construct()
    {
        $CI =& get_instance();
        $this->limit_allpg=$CI->system->get_setting("limit_show_list");
    }


    //    load from model
    public function result_db()
    {

        $CI =& get_instance();
        $limit=$this->limit_allpg;
        $page=$CI->input->post("pg_nav");
        //        $query= $CI->db->get_compiled_select();
        //        echo $query;
        //        $query= strpos($query,"select",1);
        //        echo $query;

        //        echo $query;
        //        $this->count_allpg= $CI->db->count_all('factor');
        //        echo $CI->db->count_all("factor");

        //        echo  $this->count_allpg;

        //        $CI->db->limit($limit,$limit*$page);
        //       $res =$CI->db->query($query)->result_array();
        //        return $res;
    }

    //show number for view

    public function show_link()
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        $count_all=$this->count_allpg;
        $limit=$CI->system->get_setting("limit_show_list");
        $page=($CI->input->post("pg_nav"))?$CI->input->post("pg_nav"):1;
        $numpage=ceil($count_all/$limit);
        echo "<form action='#' id='form_pg' method='post'>";
        echo form_input("pg_nav", $page, array("id"=>"page","style"=>"display:none"));
        //        echo form_input("lmt_nav",$limit);
        echo form_close();
        echo '<ul class="pagination" style="margin-right: auto;margin-left: auto">';
        for ($i=1;$i<=$numpage;$i++){
            if($i!=$page) {
                echo "<li style='cursor: pointer' onclick='paging($i)' ><a> $i </a></li>";
            } else {
                echo "<li><a style='font-weight:bolder;color:#000' > $i </a></li>";
            }

        }
        echo '</ul>';


    }
    public function show_link_ajax()
    {
        $CI =& get_instance();
        $CI->load->helper('form');
        $count_all=$this->count_allpg;
        $limit=$CI->system->get_setting("limit_show_list");
        $numpage=ceil($count_all/$limit);
        for ($i=1;$i<=$numpage;$i++){
                echo "<a class='btn  btn-lg  btn-warning'   onclick='paging($i)'>$i</a>";
        }
    }
}
