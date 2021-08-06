<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$this->load->helper('form');
$attributes = array('class' => 'form', 'id' => 'form');
echo form_open("#", $attributes);

//type product
$def_css_class = "form-control";
$data = array('class' => $def_css_class);
$group_prd = form_dropdown('group_id', $this->element->pselect("prd_group"), $detail_prd[0]["group_id"], $data);
$name = form_input(array('value' => $detail_prd[0]["name"], 'id' => 'name', 'placeholder' => _NAME, 'required' => 'required', 'name' => 'name', 'class' => $def_css_class));
$idE  = form_hidden("id", $detail_prd[0]["id"]);

$vahed_asli = form_dropdown('vahed_asli', $this->element->pselect("mali_prd_unit"), $detail_prd[0]["vahed_asli"], $data);
$company_maker = form_input(array('value' => $detail_prd[0]["company"], 'id' => 'company_maker', 'placeholder' => _COMPANY_MAKER, 'name' => 'company_maker', 'class' => $def_css_class));
$barcode = form_input(array('value' => $detail_prd[0]["barcode"], 'id' => 'barcode', 'placeholder' => _BARCODE, 'name' => 'barcode', 'class' => $def_css_class));
$country_maker = form_input(array('value' => $detail_prd[0]["country"], 'id' => 'country_maker', 'placeholder' => _COUNTRY_MAKER, 'name' => 'country_maker', 'class' => $def_css_class));
//price1 to 6
$price1 = form_input(array('value' => $detail_prd[0]["price1"], 'id' => 'price1', 'placeholder' => _PRICE . "1", 'name' => 'price1', 'class' => $def_css_class));
$price2 = form_input(array('value' => $detail_prd[0]["price2"], 'id' => 'price2', 'placeholder' => _PRICE . "2", 'name' => 'price2', 'class' => $def_css_class));
$price3 = form_input(array('value' => $detail_prd[0]["price3"], 'id' => 'price3', 'placeholder' => _PRICE . "3", 'name' => 'price3', 'class' => $def_css_class));
$price4 = form_input(array('value' => $detail_prd[0]["price4"], 'id' => 'price4', 'placeholder' => _PRICE . "4", 'name' => 'price4', 'class' => $def_css_class));
//end price
//advanced setting
$tax = form_input(array('value' => $detail_prd[0]["tax"], 'id' => 'tax', 'placeholder' => _TAX, 'name' => 'tax', 'class' => $def_css_class));
$file = form_input(array('value' => $detail_prd[0]["file"], 'id' => 'file', 'placeholder' => _FILE, 'name' => 'file', 'class' => $def_css_class));
$url = form_input(array('value' => $detail_prd[0]["url"], 'id' => 'url', 'placeholder' => _URL,'type' => 'url', 'name' => 'url', 'class' => $def_css_class));


$savebtn = form_button(array('type' => "submit", 'id' => 'submit', 'class' => 'btn btn-success btn-block .btn-lg '), _SAVE);
?>

<div class="row well">
  <div class="col-sm-8 "><label for="name"><?php echo _NAME . " " . _PRD ?></label><?php echo $name ?></div>
  <div class="col-sm-4"><label for="type"><?php echo _GROUP_PRD ?></label><?php echo $group_prd ?></div>
  <div class="col-sm-4 "><label for="vahed_asli"><?php echo _VAHED_ASLI ?></label><?php echo $vahed_asli ?></div>
  <div class="col-sm-4 "><label for="company_maker"><?php echo _COMPANY_MAKER ?></label><?php echo $company_maker ?></div>
  <div class="col-sm-4 "><label for="barcode"><?php echo _BARCODE ?></label><?php echo $barcode ?></div>
</div>

<div class="row well">
  <h3> <?= _ADVANCED_SETTING ?> </h3>
  <div class="col-sm-3 "><label for="contry_maker"><?php echo _COUNTRY_MAKER ?></label><?php echo $country_maker ?></div>
  <div class="col-sm-3 "><label for="tax"><?php echo _TAX ?></label><?php echo $tax ?></div>
  <div class="col-sm-3 "><label for="file"><?php echo _FILE ?></label><?php echo $file ?></div>
  <div class="col-sm-3 "><label for="url"><?php echo _URL ?></label><?php echo $url ?></div>
</div>
<?php if ($this->system->get_setting('enable_prd_pricing')) : ?>
  <div class="row well">
    <h3> <?= _PRICE_SETTING ?> </h3>
    <div class="col-sm-3 "><label for="price1"><?php echo _PRICE . "1" ?></label><?php echo $price1 ?></div>
    <div class="col-sm-3 "><label for="price2"><?php echo _PRICE . "2" ?></label><?php echo $price2 ?></div>
    <div class="col-sm-3 "><label for="price3"><?php echo _PRICE . "3" ?></label><?php echo $price3 ?></div>
    <div class="col-sm-3 "><label for="price4"><?php echo _PRICE . "4" ?></label><?php echo $price4 ?></div>

  </div>
<?php endif; ?>

<button class="col-sm-12 row well" style="padding:19px;" type="submit">
  <?php echo $idE ?>
  <?php echo $savebtn ?>
</button>

<?php echo form_close(); ?>
<?php echo $this->element->load_ajax_submit("form", 'MaLi/pprd/prd/pedit'); ?>