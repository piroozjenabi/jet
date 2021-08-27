<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
//print_r($detail_factor);
$CI = &get_instance();
$CI->load->library('factor');
$CI->load->library('bed_beslib');
//get levels
$levelsar = $CI->factor->get_level_list("bed_bes");
$c = $radif = $tbed = $tbes = $remind = 0;
$bilar = array();
$show_link = site_url("MaLi/factor_sell/manage_factor/view_details");

?>

<div class="col-sm-6  " style="width: 50%;float: right">
    <table class="table table-hover table-striped cleartbl">
        <tr>
            <td><?= _NAME . __ . _FACTOR_CLIENT ?> : </td>
            <td><?= $detail_users[0]["name"]  ?></td>
        </tr>
        <tr>
            <td> <?= _AGENT ?> : </td>
            <td><?= $detail_users[0]["agent"] ?></td>
        </tr>
        <tr>
            <td><?= _ADDRESS ?> : </td>
            <td><?= $detail_users[0]["address"] ?></td>
        </tr>
        <tr>
            <td><?= _COMMERICAL_ID ?> : </td>
            <td><?= $detail_users[0]["comerical_id"] ?></td>
        </tr>
        <tr>
            <td><?= _TELL ?> : </td>
            <td><?= $detail_users[0]["tell"] ?></td>
        </tr>
        <tr>
            <td><?= _MOBILE ?> : </td>
            <td><?= $detail_users[0]["mobile"] ?></td>
        </tr>
        <tr>
            <td><?= _CODE . __ . _CLIENT ?> : </td>
            <td><?= $detail_users[0]["perfix_code"] . $detail_users[0]["id"] ?></td>
        </tr>
    </table>
</div>

<div class="col-sm-6  left " style="width: 50% ;float: left ">
    <table class="table table-hover table-striped cleartbl">
        <tr>
            <td>Name : </td>
            <td><?= $detail_users[0]["extra1"]  ?></td>
        </tr>
        <tr>
            <td>Contact person : </td>
            <td><?= $detail_users[0]["extra2"] ?></td>
        </tr>
        <tr>
            <td>Address : </td>
            <td><?= $detail_users[0]["extra3"] ?></td>
        </tr>
        <tr>
            <td>City,State,Zip : </td>
            <td><?= $detail_users[0]["extra4"] ?></td>
        </tr>
        <tr>
            <td>Country : </td>
            <td><?= $detail_users[0]["extra5"] ?></td>
        </tr>
        <tr>
            <td>Email : </td>
            <td><?= $detail_users[0]["email"] ?></td>
        </tr>
        <tr>
            <td>Business ID : </td>
            <td><?= $detail_users[0]["perfix_code"] . $detail_users[0]["id"] ?></td>
        </tr>
    </table>
</div>


<!--------------------factors -------------------->
<?php foreach ($levelsar as $k => $v) {

    //----------------for factors
    $tmp = $CI->factor->get_list_factor_from_user($detail_users[0]["id"], $v["id"]);
    if (count($tmp)) {
        foreach ($tmp as $key => $value) {
            $bilar[$c]["id"] = $value["id"];
            $bilar[$c]["date"] = $value["date"];
            $bilar[$c]["expire"] = $value["expire_date"];
            $bilar[$c]["des"] = $v["des"] . ' ( ' . $value["factor_id"] . ' ) ';
            $bilar[$c]["op"] = "<a class=' btn btn-default ' onclick=load_ajax_popup('$show_link','id=" . $value["id"] . "','normal')> <i class='fa fa-eye' ></i> " . _VIEW_FACTOR . ' </a>';
            $bilar[$c]["bed"] = ($CI->factor->price($value["id"]) > 0) ? $CI->factor->price($value["id"]) : 0;
            $bilar[$c]["bes"] = ($CI->factor->price($value["id"]) < 0) ? $CI->factor->price($value["id"]) * -1 : 0;
            $c++;
        }
    }
}
//------------------for pays
$tmp = $CI->bed_beslib->get_list_bes_from_user($detail_users[0]["id"]);
if (count($tmp)) {
    foreach ($tmp as $key => $value) {
        if ($value["enable"]) {
            $bilar[$c]["id"] = $value["id"];
            $bilar[$c]["des"] = $value["des"];
            $bilar[$c]["bed"] = 0;
            $bilar[$c]["bes"] = $value["price"];
            $bilar[$c]["date"] = $value["date"];
            $bilar[$c]["expire"] = (@json_decode($value["params"])->checku) ? json_decode($value["params"])->checku : null;
            $bilar[$c]["op"] = null;
            $c++;
        }
    }
}
//sort
usort(
    $bilar,
    function ($a, $b) {
        return $a['date'] - $b['date'];
    }
);
?>

<table class=" table table-hover table-striped">

    <thead>
        <tr>
            <td><?= _ID ?></td>
            <td><?= _DATE ?></td>
            <td><?= _DATE . __ . _EXPIRE ?></td>
            <td><?= _DES ?></td>
            <td><?= _BEDEHKAR . _R ?></td>
            <td><?= _BESTANKAR . _R ?></td>
            <td><?= _REMIND . _R ?></td>
            <td>!</td>
            <td class="dis_print"> </td>
        </tr>
    </thead>
    <?php foreach ($bilar as $key => $value) :
        $tbed += $value["bed"];
        $tbes += $value["bes"];
        $remind = $remind + $value["bed"] - $value["bes"];

        if ($remind > 0) $typ = _BED;
        else if ($remind < 0) $typ = _BES;
        else $typ = "";

    ?>
        <tr>
            <td><?= $value["id"] ?></td>
            <td><?= ($value["date"]) ? printDate($value["date"]) : null; ?></td>
            <td><?= ($value["expire"]) ? printDate($value["expire"]) : null; ?></td>
            <td><?= $value["des"] ?></td>
            <td><?= price($value["bed"]) ?></td>
            <td><?= price($value["bes"]) ?></td>
            <td><?= price(($remind >= 0) ? $remind : $remind * -1)  // if manfi not show manfi
                ?></td>
            <td><?= $typ ?></td>
            <td class="dis_print"><?= $value["op"] ?></td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <td> # </td>
            <td> </td>
            <td> </td>
            <td><?= _TOTAL_PLUS ?></td>
            <td><?= price($tbed) ?></td>
            <td><?= price($tbes) ?></td>
            <td><?= price($remind) ?></td>
            <td><?= $typ ?></td>
            <td class="dis_print"> </td>

        </tr>
    </tfoot>

</table>
<table class=" table table-hover table-striped">

    <thead>
        <tr>
            <td></td>
            <td><?= _REMIND ?></td>
            <td><?= price($remind) ?></td>
        </tr>
    </thead>


</table>