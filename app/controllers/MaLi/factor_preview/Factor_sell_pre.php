<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Factor_sell_pre extends CI_Controller
{

    public function index($id_factor=0,$print_format=0)
    {
        $this->template->load_bootstrapjs();
        $this->template->load_bootstrapcss();

        $this->load->model('MaLi/Factor_sell_pre_model');
        $result= $this->Factor_sell_pre_model->get_all($id_factor, $print_format);
        $this->render($result, $id_factor, $print_format);
    }




    public function render($result,$id_factor,$print_format)
    {

        $this->load->library("Factor");
        //get level from factor id
        $level_pro=$this->factor->get_level_info_from_factor_id($id_factor);
        //put  factor preview id in here and get propertis
        $print_format=($print_format)?$print_format:$level_pro["factor_preview_id"];
        $factor_pre=$this->factor->get_factor_preview($print_format);

        $this->load->library('PDF');
        $pdf = new PDF('P', 'mm', $factor_pre["size"], true, $factor_pre["encoding"], false);
        $pdf->setFontSubsetting(false);
        $pdf->setRTL(true);
        $pdf->SetTitle($factor_pre["title"]);
        $pdf->SetHeaderMargin(10);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(7);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetPrintHeader(false);//*setting header
        $pdf->SetPrintFooter(false);//*setting footer
        $pdf->SetAuthor($factor_pre["Author"]);
        $pdf->SetDisplayMode('real', 'default');
        $pdf->AddPage();
        //header image
        $pdf->Image(config("deafult_folder_img")."/".$factor_pre["header_pic"], 200, 10, 190, 21, 'JPG', $factor_pre["url_header"], '', false, 150, '', false, false, 0, false, false, false); // * setting header
            $ws=0;
        //render html
        foreach ($result as $key => $value)
        {
            $value["propertis"]=json_decode($this->element->deln($value["propertis"]));
            $w=$value["width"];//width of cell
            $h=$value["height"];//height of cell
            $x=$value["x"];//x of cell
            $y=$value["y"];//y of cell

            if ($value["load_type"]) {
                $value["db"]=$this->Factor_sell_pre_model->{$value["load_type"]}($value, $id_factor);
                $html =$this->load->view("MaLi/factor_view/".$value["load_type"], $value, true);
                $pdf->writeHTMLCell($w, $h, $x, $y, $html, 0, 0, 0, 0, 0, 0);
                $ws += $w;
            }

        }

        $pdf->Output($_SERVER['DOCUMENT_ROOT']."crmpdf/lotus-$id_factor.pdf", 'FI');



    }




}
