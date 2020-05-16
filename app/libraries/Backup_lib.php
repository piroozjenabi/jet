<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Backup_lib
{

    //backup data base
    public function db_bkp()
    {
        $CI = &get_instance();
        $CI->load->dbutil();
        $prefs = array(
            'format' => 'zip',
            'filename' => 'jetcandodump.sql'
        );
        $bkp = $CI->dbutil->backup($prefs);
        $fileName = 'jetcando-backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        $save = 'bkp/' . $fileName;
        $CI->load->helper('file');
        write_file($save, $bkp);
        $CI->load->helper('download');
        force_download($fileName, $bkp);
    }
    //    restore database
    public function db_rstr()
    {
        $isi_file = file_get_contents('');
        $string_query = rtrim($isi_file, "\n;");
        $array_query = explode(";", $string_query);
        foreach ($array_query as $query) {
            $this->db->query($query);
        }

    }

    //TODO fill this for email backup
    public function email_bkp()
    {

    }
    //TODO fill this for ftp backup
    public function ftp_bkp()
    {

    }

}
