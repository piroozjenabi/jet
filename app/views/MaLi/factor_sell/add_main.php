<?php defined('BASEPATH') or exit('No direct script access allowed');

$attributes = array('class' => 'form', 'id' => 'form');
$def_css_class = "spcell";
$data = array('class' => $def_css_class);

$this->load->helper('form');
echo form_open('MaLi/factor/add/' . @$detail_factor[0]["id_factor"], $attributes);
//FACTOR HEADER
$factor_client = $this->element->user_select("user", "user", $def_css_class, @$detail_factor[0]['user_id'], "onchange=checkuser()");
$level_factor = form_dropdown('level_id', $this->element->pselect("factor_level"), @$detail_factor[0]["level_id"], array("required" => "required", "class" => $def_css_class));
//date setting
$factor_date = $this->element->input_date("factor_date", time());
$factor_date_expire = $this->element->input_date("expire_factor", strtotime("+" . (int)$this->system->get_setting("factor_day_expire_date") . " days"));

//factor prd
$radif_prd = form_input(array('id' => 'radif[1]', 'value' => '[1]', 'name' => 'radif[1]', 'class' => $def_css_class));
$name_prd = $this->element->price_select("prd[1]", "prd[1]", $def_css_class);
$num_prd = form_input(array('id' => 'numprd[1]', 'value' => '1', 'name' => 'numprd[1]', 'class' => $def_css_class, "onkeyup" => "price_prd(1)", "onchange" => "price_prd(1)"));
$price_prd = form_input(array('id' => 'price[1]', 'name' => 'price[1]', 'onkeyup' => 'price_prd(1)', 'onchange' => 'price_prd(1)', 'class' => $def_css_class));
$takhfif_prd = form_input(array('id' => 'takhfif[1]', 'name' => 'takhfif[1]', 'onkeyup' => 'total_price(1)', 'onchange' => 'total_price(1)', 'class' => $def_css_class, 'value' => 0));
$total_prd_main = form_input(array('id' => 'total_main[1]', 'name' => 'total_main[1]', 'onkeyup' => 'total_price(1)', 'onchange' => 'total_price(1)', 'disabled' => 'disabled', 'class' => $def_css_class));
$total_prd = form_input(array('id' => 'total[1]', 'name' => 'total[1]', 'onkeyup' => 'total_price(1)', 'onchange' => 'total_price(1)', 'disabled' => 'disabled', 'class' => $def_css_class));
//des
$des = form_textarea(array('id' => 'des', 'name' => 'des', "style" => "height:100px", "placeholder" => _DES_INVOICE_PH, 'value' => @$detail_factor[0]['des'], 'class' => $def_css_class));
//total
$total_prd_end = form_input(array('id' => 'total_prd_end', 'readonly' => 'readonly', 'name' => 'total_prd_end', 'class' => $def_css_class));
$total_num_end = form_input(array('id' => 'total_num_end', 'name' => 'total_num_end', 'readonly' => 'readonly', 'class' => $def_css_class));
?>
<style type="text/css">
  input {
    direction: ltr !important;
  }

  .h1ads {
    display: none
  }
</style>
<div class="modal-body">
  <div class='row well'>
    <button class="btn btn-success" style="width:20%" type="submit"> <?= _SAVE ?> </button>
    <div class="btn-group">
      <button type="button" class="btn" onclick="$('#desInvoice').toggle(50);$('#des').val('');$(this).toggleClass('btn-info')"> <i class='fa fa-cog'> </i> <?= _FACTOR_DES ?> </button>
    </div>
  </div>
  <div class="row well" id="desInvoice" style="display:none">
    <?php echo $des ?>
  </div>
  <div class="row well">
    <div class="col-sm-4"><label for="type"><?php echo _FACTOR_CLIENT ?> </label><?php echo $factor_client ?></div>
    <div class="col-sm-4"><label for="type"><?php echo _FACTORـTYPE ?></label><?php echo $level_factor ?> </div>
    <div class="col-sm-2"><label for="type"><?php echo _FACTORـDATE ?></label><?= $factor_date ?></div>
    <?php if ($this->system->get_setting("enable_factor_expire_date")) : ?>
      <div class="col-sm-2"><label for="type"><?php echo _EXPIRE_FACTOR ?></label><?= $factor_date_expire ?></div>
    <?php endif; ?>
    <div class="col-sm-12" id="user_details" style="text-align: center;padding-top: 15px"> </div>

  </div>

  <div class="row well">
    <table id="prd_tbl" class="table table-striped table-bordered">
      <tr style="background-color: #1f1f1f;color: #ffffee;text-align: center">
        <td style="width: 5%">#</td>
        <td style="width: 30%"><?php echo _NAME . ' ' . _PRD ?></td>
        <td style="width: 5%"> <?php echo _NUM ?></td>
        <td><?php echo _PRICE_MAIN . _R ?></td>
        <td><?php echo _TAKHFIF_KHATI ?></td>
        <td><?php echo _PRICE_TOTAL . _R ?></td>
      </tr>
      <?php if (isset($mode) && @$mode = "edit" && @$detail_factor[0]["id"]) {
        $c = 1;
        foreach (@$detail_factor as $key => $value) {
          echo "<tr>";
          echo "<td>" . form_input(array('id' => "radif[$c]", 'value' => $value["radif"], 'name' => "radif[$c]", 'class' => $def_css_class)) . "</td>";
          echo "<td>" . $this->element->price_select("prd[$c]", "prd[$c]", $def_css_class, $value["id_prd"]) . "</td>";
          echo "<td>" . form_input(array('id' => "numprd[$c]", 'value' => $value["num"], 'name' => "numprd[$c]", 'class' => $def_css_class, "onkeyup" => "price_prd($c)", "onchange" => "price_prd($c)")) . "</td>";
          echo "<td>" . form_input(array('id' => "price[$c]", 'name' => "price[$c]", 'value' => $value["price"], 'onkeyup' => "price_prd($c)", 'onchange' => "price_prd($c)", 'class' => $def_css_class)) . "</td>";
          $tmp_dis_price = ($tmp_tot_prd - $value["takhfif"]) / $value["num"];
          echo "<td>" . form_input(array('id' => "takhfif[$c]", 'name' => "takhfif[$c]", 'onkeyup' => "total_price($c)", 'onchange' => "total_price($c)", 'class' => $def_css_class, 'value' => $value["takhfif"])) . "</td>";
          echo "<td>" . form_input(array('id' => "total_main[$c]", 'name' => "total_main[$c]", 'onkeyup' => "total_price($c)", 'value' => $tmp_tot_prd, 'onchange' => "total_price($c)", 'disabled' => 'disabled', 'class' => $def_css_class));
          echo "</tr>";
          $c++;
        }
      } else {
      ?>
        <tr id="prd_row">
          <td><?php echo $radif_prd ?></td>
          <td><?php echo $name_prd ?></td>
          <td><?php echo $num_prd ?></td>
          <td><?php echo $price_prd ?></td>
          <td><?php echo $takhfif_prd ?><div id="perfix_takhfif"> </div>
          </td>
          <td><?php echo $total_prd_main ?></td>
        <?php } ?>
        </tr>
    </table>
    <table class="table table-striped table-bordered">
      <tr>

        <td><?php echo _NUM_TOTAL ?></td>
        <td><?php echo $total_num_end ?> </td>
        <td><?php echo _PRICE_TOTAL . _R ?></td>
        <td><?php echo $total_prd_end ?> </td>
      </tr>

    </table>
  </div>
  <!-- INCREMENT OF FACTOR -->
  <div class="row ">
    <?php if ($this->system->get_setting("enable_kosoorat")) : ?>
      <div class="col-sm-6 well">
        <div class="panel panel-default">
          <div class="panel-heading"> <i class="fa fa-minus"> </i> <?= _KOSOORAT ?></div>
          <div class="panel-body">
            <table id="prd_tbl" class="table table-striped table-bordered">
              <tr>
                <td> <?php echo _NAME . _R ?> </td>
                <td> <?php echo _PRICE_TOTAL . _R ?> </td>
              </tr>
              <?php foreach ($additions as $key => $value) : if ($value->mode == '-') { ?>
                  <tr>
                    <td> <?= pl($value->name) ?> </td>
                    <td> <?= form_input("adds[{$value->id}]", 0, ["class" => $def_css_class . ' amines', 'onkeyup' => "total_price()"])  ?> </td>
                  </tr>
              <?php }
              endforeach; ?>
              <tr>
              </tr>
            </table>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <!-- DECREMENT OF FACTOR -->

    <?php if ($this->system->get_setting("enable_ezafat")) : ?>
      <div class="col-sm-6 well">

        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-plus"> </i> <?= _EZAFAT ?></div>
          <div class="panel-body">
            <table id="prd_tbl" class="table table-striped table-bordered">
              <tr>
                <td> <?php echo _NAME . _R ?> </td>
                <td> <?php echo _PRICE_TOTAL . _R ?> </td>
              </tr>
              <?php foreach ($additions as $key => $value) : if ($value->mode == '+') { ?>
                  <tr>
                    <td> <?= pl($value->name) ?> </td>
                    <td> <?= form_input("adds[{$value->id}]", 0, ["class" => $def_css_class . ' aplus', 'onkeyup' => "total_price()"])  ?> </td>
                  </tr>
              <?php }
              endforeach; ?>
              <tr>
              </tr>
            </table>
          </div>

        </div>
      </div>
    <?php endif; ?>
  </div>
  <?php echo form_close(); ?>
</div>

<script type="text/javascript">
  //get row number 
  var _row = getrow();

  function getrow() {
    _row = 0;
    do {
      _row++
    } while (document.getElementById('radif[' + _row + ']'));
    _row--;
    return _row;
  }

  function price_prd(_ele) {
    _price = document.getElementById("price[" + _ele + "]").value;
    total_price();
  }
  //for main
  function total_price() {
    var i = 1;
    var _maintotal = 0;
    var _mainnum = 0;
    for (i; i <= _row; i++) {
      var strrow = i.toString();
      var price = document.getElementById('price[' + strrow + ']').value;
      var num = document.getElementById('numprd[' + strrow + ']').value;
      var takhfif = document.getElementById('takhfif[' + strrow + ']').value;
      takhfif = percent('takhfif[' + i + ']', total);
      var total = price * num - takhfif;
      document.getElementById('total_main[' + strrow + ']').value = total;
      _maintotal = _maintotal + parseInt(total);
      _mainnum = parseInt(_mainnum) + parseInt(num);
    }
    if (price != "") add_row()

    _maintotal = calcAdditionls(_maintotal);
    document.getElementById('total_prd_end').value = _maintotal;
    document.getElementById('total_num_end').value = _mainnum;
  }

  function percent(_element, total) {
    var _value = document.getElementById(_element).value;
    var _op_value = _value.search("%");
    if (_op_value >= 1) {
      _value = _value.replace("%", "");
      _value = parseInt(total) * (parseInt(_value) / 100);
      document.getElementById(_element).value = _value;
      return _value;
    } else return _value;
  }

  function add_row() {
    _row++;
    $("#prd_tbl").append('<tr>   <td> <?php echo $this->element->rep_ele($radif_prd, "1", "'+_row+'") ?> </td> <td> <?php echo $this->element->rep_ele($name_prd, "1", "'+_row+'") ?></td>  <td> <?php echo $this->element->rep_ele($num_prd, "1", "'+_row+'") ?> </td><td> <?php echo $this->element->rep_ele($price_prd, "1", "'+_row+'") ?> </td> <td> <?php echo $this->element->rep_ele($takhfif_prd, "1", "'+_row+'") ?> </td> <td> <?php echo $this->element->rep_ele($total_prd_main, "1", "'+_row+'") ?> </td></tr>');
    $("select").select2({
      dir: "<?= _DIRECTION ?>"
    });
  }

  function disprice(_ele) {
    _price = document.getElementById("price[" + _ele + "]").value;
    _num = document.getElementById("numprd[" + _ele + "]").value
    _final_dis = _price - _dis;
    _final_dis *= _num;

    document.getElementById("takhfif[" + _ele + "]").value = _final_dis;
  }

  function calcAdditionls(tot) {
    $('.aplus').each(function(e, i) {
      tot += parseInt($(this).val())
    });
    $('.amines').each(function(e, i) {
      tot -= parseInt($(this).val())
    });
    return tot;
  }

  //fill user detail
  function checkuser() {
    var e = document.getElementById("user");
    var _str = e.options[e.selectedIndex].id;
    document.getElementById("user_details").innerHTML = _str;
  }

  function setPrice(_this) {
    var price = _this.options[_this.selectedIndex].id;
    if (price > 0) document.getElementById(_this.id.replace('prd', 'price')).value = price;
  }
</script>