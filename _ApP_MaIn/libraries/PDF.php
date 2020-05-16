<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

 require_once APPPATH.'/third_party/tcpdf/tcpdf.php';

class PDF extends TCPDF
{
    function __construct()
    {
        parent::__construct();

    }


}
