<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_factor extends CI_Controller
{

    public function index($type = "private", $level = 0, $user_id = 0)
    {
        $level = ($level) ? $level : $this->system->get_setting("deafult_factor_level");
        $this->main($level, $type, $user_id);
    }

    public function main($level, $type = "private", $user_id = 0, $month_ago = 0, $type_date = "date", $type_in = "", $output = "", $sort = "")
    {
        $this->load->library("Factor");
        $data = array("level" => $level, "month_ago" => $month_ago, "user_id" => $user_id, "type_date" => $type_date, "type_in" => $type_in, "type" => $type);
        $this->template->load('MaLi/factor_sell/manage_list', $data);

    }
    //ajax list
    public function ajax_list()
    {
        $type_date = ($this->input->post("type_date", true)) ? $this->input->post("type_date", true) : "date";
        $type_in = ($this->input->post("type_in", true)) ? $this->input->post("type_in", true) : "";
        $type = ($this->input->post("type", true)) ? $this->input->post("type", true) : "";
        $user_id = $this->input->post("user_id", true);
        $sort = $this->input->post("sort", true);
        $level = $this->input->post("level", true);
        $mont_ago = ($this->input->post("month_ago", true)) ? $this->input->post("month_ago", true) : 0;
        $data = $this->level($level, $type, $user_id, $mont_ago, $type_date, $type_in, $type_date, $sort);
        $this->template->load_ajax("MaLi/factor_sell/ajax_list", $data);
    }
    //view level
    public function level($level, $type = "private", $user_id = 0, $month_ago = 0, $type_date = "date", $type_in = "", $output = "", $sort = "")
    {
        //load def library

        $this->load->model('MaLi/Factor_sell_model');
        $this->load->model('MaLi/Comission_model');
        $this->load->library('Piero_jdate');
        $this->load->library("Factor");
        $pay_flag = $this->system->get_setting("show_pay_on_factor_list");
        $com_flag = $this->system->get_setting("show_comision_list_factor");
        $level = ($level) ? $level : $this->system->get_setting("main_factor_level");
        //get result array
        $result = $this->Factor_sell_model->manage_list($level, $type, $user_id, $month_ago, $type_date, $type_in, $sort);
        //define
        $comtot = 0;
        $tot = 0;
        $get = 0;
        $get_tot = 0;
        //formules
        foreach ($result as $key => &$value) {
            //total price op
            $price = $this->Factor_sell_model->show_total_price($value["id"]);
            $tot += $price;
            $value["total_factor"] = $price;
            //comission
            if ($com_flag) {
                $comission = $this->Comission_model->commison_factor($value["id"]);
                $comtot += $comission;
                $value["com"] = $comission;
            }
            if ($pay_flag) {
                //money get op
                $get = $this->factor->geted_money_factor($value["id"]);
                $get_tot += $get;
                $value["get"] = $get;
            }
            if ($type_in == "list_bedehkar" || $type_in == "expire_all") {
                if ($get >= $price) {

                    unset($result[$key]);
                }
            }
        }
        $data = array('db' => $result, "comtot" => $comtot, "tot" => $tot, "level" => $level, "month_ago" => $month_ago, "user_id" => $user_id, "gettot" => $get_tot, "type_date" => $type_date, "type_in" => $type_in);
        if ($output == "data") {
            return $data;
        }
        $this->template->load('MaLi/factor_sell/manage_list', $data);
    }

    //delete factor
    public function manage_delete($factor_id = 0)
    {
        $this->load->model('MaLi/Factor_sell_model');
        if ($result = $this->Factor_sell_model->manage_delete($factor_id)) {
            $this->system->message(_FACTOR_DELETED);
        }
        redirect("/MaLi/factor_sell/manage_factor");
    }
    public function manage_changelevel($factor_id = 0, $level = 0)
    {
        $this->load->model('MaLi/Factor_sell_model');
        $this->load->library("Factor");
        $this->factor->render_level($factor_id, $level);
        redirect("/MaLi/factor_sell/manage_factor");
    }

    //edit factor
    public function edit($id)
    {
        $this->load->model('MaLi/Factor_sell_model');
        $ret = $this->Factor_sell_model->edit_factor($id);
        //        time
        $this->load->library('Piero_jdate');
        $def_time = $this->piero_jdate->jdate("Y/m/d", $ret[0]["date"]);
        $def_time_expire = $this->piero_jdate->jdate("Y/m/d", $ret[0]["expire_date"]);
        //convert persian number to english
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        $ret[0]["date"] = str_replace($persian, $num, $def_time);
        $ret[0]["expire_date"] = str_replace($persian, $num, $def_time_expire);
        @$ret[0]["delivery_address1"] = json_decode($ret[0]["params"])->delivery_address1;
        @$ret[0]["delivery_address2"] = json_decode($ret[0]["params"])->delivery_address2;
        $this->template->load('MaLi/factor_sell/add_main', array("detail_factor" => $ret));
    }
    public function pedit($id)
    {
        $this->load->model('MaLi/Factor_sell_model');
        echo $this->Factor_sell_model->add_($id);
        $this->Factor_sell_model->message(_FACTOR . _EDITED);
        redirect("MaLi/factor_sell/manage_factor/level/" . $this->input->post("level_id", true));
    }

    public function add_all_factor_to_alert()
    {
        if (!$this->permision->is_admin()) {
            die("access denied !!");
        }
        $this->load->model('MaLi/Factor_sell_model');
        $this->Factor_sell_model->add_all_factor_to_alert();
    }

    public function show_details($id_factor)
    {

    }
    //reject form
    public function rejectform()
    {
        $id = $this->input->post("id", true);
        $this->load->model('MaLi/Factor_sell_model');
        $ret = $this->Factor_sell_model->edit_factor($id);

        $this->template->load_popup("MaLi/factor_sell/reject_form", _REJECT_FORM, array("detail_factor" => $ret, "factor_id" => $id));
    }
    public function rejectformpadd($id)
    {
        $this->load->model('MaLi/Factor_sell_model');

        if ($this->Factor_sell_model->reject_factor_add($id)) {
            $this->system->message(_FACTOR_ADDED);
        }
        redirect("MaLi/factor_sell/manage_factor/level/4");
    }

    //show details
    public function view_details()
    {
        $id = $this->input->post("id", true);
        $this->load->model('MaLi/Factor_sell_model');
        $ret = $this->Factor_sell_model->edit_factor($id);
        $retoth = $this->Factor_sell_model->list_other_pay($id);
        $this->template->load_popup("MaLi/factor_sell/show_details", _VIEW_DETAILS . __ . _FACTOR, array("detail_factor" => $ret, "factor_id" => $id, "other_pay" => $retoth));
    }

    //show factor this month
    public function this_month($user_id = 0, $mount_ago = 0, $type = "public")
    {
        $user_id = ($user_id) ? $user_id : $this->system->get_user();
        $this->main($this->system->get_setting("main_factor_level"), $type, $user_id, ++$mount_ago);
    }
    public function list_bedehkar($user_id = 0)
    {
        $this->main($this->system->get_setting("main_factor_level"), "public", $user_id, 0, 0, "list_bedehkar");
    }
    public function list_trans($user_id = 0)
    {
        $this->main($this->system->get_setting("main_factor_level"), "public", $user_id, 0, 0, "list_trans");
    }
    //show factor this mounth
    public function this_month_expire($user_id = 0, $mount_ago = 0)
    {
        $user_id = ($user_id) ? $user_id : $this->system->get_user();
        $type = ($this->permision->check("dashboard_expirefactor_all")) ? "public" : "private";
        $this->main($this->system->get_setting("main_factor_level"), $type, $user_id, ++$mount_ago, "expire_date");

    }

    //show factor all expired
    public function expire_all($user_id = 0, $mount_ago = 0)
    {
        $user_id = ($user_id) ? $user_id : $this->system->get_user();
        $this->main($this->system->get_setting("main_factor_level"), "public", $user_id, 0, "expire_date", "expire_all");
    }

    //factor pay
    public function get_money()
    {
        $id = $this->input->post("id", true);
        $this->load->model('MaLi/Factor_sell_model');
        $ret = $this->Factor_sell_model->edit_factor($id);

        $this->template->load_popup("MaLi/factor_sell/get_money", _REJECT_FORM, array("detail_factor" => $ret, "factor_id" => $id));
    }
    public function get_moneypadd($id)
    {
        $this->load->model('MaLi/Factor_sell_model');

        if ($this->Factor_sell_model->get_money_add($id)) {
            $this->system->message(_SUC_OP);
        }
        redirect("MaLi/factor_sell/manage_factor/level/1");
    }

    //other pay
    public function other_pay()
    {
        $id = $this->input->post("id", true);
        $this->load->model('MaLi/Factor_sell_model');
        $ret = $this->Factor_sell_model->edit_factor($id);
        $this->template->load_popup("MaLi/factor_sell/other_pay", _OTHER_PAY, array("detail_factor" => $ret, "factor_id" => $id));
    }
    public function other_paypadd($id)
    {
        $this->load->model('MaLi/Factor_sell_model');
        if ($this->Factor_sell_model->other_pay_add($id)) {
            $this->system->message(_SUC_OP);
        }
        redirect("MaLi/factor_sell/manage_factor/list_trans");
    }

    ##############################################################################3
    public function manage()
    {
        $this->load->library("Crud");
        $this->crud->table = "factor";
        $this->crud->title = _MANAGE_INVOICE;
        $this->crud->column_order = array("factor_prd.id_factor", "level_id", "user_id", "date", "expire_date", "sum(price*num-takhfif)", "sum(takhfif)", "sum(num)", "sum(value)");
        $this->crud->column_title = array(_ID, _TYPE, _CLIENT, _DATE, _EXPIRE_FACTOR, _PRICE_FACTOR, _TAKHFIF, _NUM_PRD,"inc");
        $this->crud->join[] = array("factor_prd", "factor.id = factor_prd.id_factor","left");
        $this->crud->join[] = array("factor_additions", "factor.id = factor_additions.id_factor","left");
        $this->crud->group_by = "factor.id";
        $this->crud->permision = array("add" => false, "edit" => false, "delete" => false);
        $tmp_selectdb = array("select_db", "user", "name");
        $tmp_selectdbtype = array("select_db", "factor_level", "name");
        $this->crud->column_type = array("hide", json_encode($tmp_selectdbtype), json_encode($tmp_selectdb), "date", "date", "number", "number", "number","number");
        $this->crud->actions = "<a class='btn btn-info  ' href='" . site_url("MaLi/pusers/users/manage") . "' > <i class='fa fa-users' ></i>" . _MANAGE_CLIENTS . ' </a>';
        $this->crud->order = array("factor.date", "DESC");
        $this->crud->render();
    }

    // crud for manage factor levels
    public function manage_level(){
        $this->load->library("Crud");
        $this->crud->table          = "factor_level";
        $this->crud->title          = _MANAGE_FACTOR_LEVELS;
        $this->crud->column_order   = array("name", "des", "next_levels", "get_id", "expirable", "removable", "editable", "show_details", "alert_self_make", "alert_usergroups_make", "alert_self_expire","alert_usergroup_expire","stock_in","stock_out", "bed","bes","factor_preview_id","reject_form","other_pay","stock_in_recepie");
        $this->crud->column_list    = array("name", "des", "next_levels", "get_id", "expirable", "removable", "editable","show_details","bed","bes");
        $this->crud->column_require = array(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $this->crud->column_title   = array(_NAME, _DES, _FACTOR_NEXT_LEVEL, _FACTOR_GET_ID, _FACTOR_EXPIREABLE,_FACTOR_REMOVABLE, _FACTOR_EDITABLE, _FACTOR_PRINTABLE, _FACTOR_ALERT_SELF, _FACTOR_ALERT_SELF_GROUP, _FACTOR_EXPIRE_ALERT_SELF, _FACTOR_EXPIRE_ALERT_SELF_GROUP, _FACTOR_STOCK_IN, _FACTOR_STOCK_OUT, _FACTOR_BED, _FACTOR_BES, _FACTOR_PREVID, _FACTOR_REJECTABLE, _FACTOR_OTHER_PAY, _FACTOR_STOCK_RECEPIE);
        $this->crud->permision      = array("add" => true, "edit" => true, "delete" => true);
        $this->crud->column_type    = array( "input", "input", json_encode(["select_db", "factor_level", "name"]), "bool", "bool", "bool", "bool", "bool", "bool","bool", "bool", "bool", "bool", "bool","bool", "bool", "bool", "bool", "bool","bool","bool");
        $this->crud->actions        = "<a class='btn btn-info  ' href='" . site_url("MaLi/factor_sell/manage_factor/manage_level") . "' >" . _MANAGE_INVOICE . ' </a>';
        $this->crud->order          = array("factor.date", "DESC");
        $this->crud->render();
    }
}
