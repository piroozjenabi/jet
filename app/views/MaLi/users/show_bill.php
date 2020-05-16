<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$radif=0;
//print_r($detail_factor);
$CI =& get_instance();
$CI->load->library('Piero_jdate');
$CI->load->library('factor');
$CI->load->library('bed_beslib');
//get levels
$levelsar=$CI->factor->get_level_list("bed_bes");
$tbed=0;
$tbes=0;
$remind=0;
$bilar=array();
$c=0;
$show_link= site_url("MaLi/factor_sell/manage_factor/view_details");

?>

<div class="col-sm-6  " style="width: 50%;float: right">
<table class="table table-hover table-striped cleartbl" >
    <tr>
        <td><?php echo _NAME.__._FACTOR_CLIENT?>  : </td>
        <td><?php echo $detail_users[0]["name"]  ?></td>
    </tr>
    <tr>
        <td> <?php echo _AGENT ?>  : </td>
        <td><?php echo $detail_users[0]["agent"] ?></td>
    </tr>
    <tr>
        <td><?php echo _ADDRESS ?> : </td>
        <td><?php echo $detail_users[0]["address"] ?></td>
    </tr>
    <tr>
        <td><?php echo _COMMERICAL_ID ?> : </td>
        <td><?php echo $detail_users[0]["comerical_id"] ?></td>
    </tr>
    <tr>
        <td><?php echo _TELL ?> : </td>
        <td><?php echo $detail_users[0]["tell"] ?></td>
    </tr>
    <tr>
        <td><?php echo _MOBILE?> : </td>
        <td><?php echo $detail_users[0]["mobile"] ?></td>
    </tr>
    <tr>
        <td><?php echo _CODE.__._CLIENT ?> : </td>
        <td><?php echo $detail_users[0]["perfix_code"].$detail_users[0]["id"] ?></td>
    </tr>
</table>
</div>

<div class="col-sm-6  left " style="width: 50% ;float: left ">
<table class="table table-hover table-striped cleartbl"  >
    <tr>
        <td>Name : </td>
        <td><?php echo $detail_users[0]["extra1"]  ?></td>
    </tr>
    <tr>
        <td>Contact person : </td>
        <td><?php echo $detail_users[0]["extra2"] ?></td>
    </tr>
    <tr>
        <td>Address : </td>
        <td><?php echo $detail_users[0]["extra3"] ?></td>
    </tr>
    <tr>
        <td>City,State,Zip : </td>
        <td><?php echo $detail_users[0]["extra4"] ?></td>
    </tr>
    <tr>
        <td>Country : </td>
        <td><?php echo $detail_users[0]["extra5"] ?></td>
    </tr>
    <tr>
        <td>Email : </td>
        <td><?php echo $detail_users[0]["email"] ?></td>
    </tr>
    <tr>
        <td>Business ID : </td>
        <td><?php echo $detail_users[0]["perfix_code"].$detail_users[0]["id"] ?></td>
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
            $bilar[$c]["bed"] = ($CI->factor->price($value["id"])>0)?$CI->factor->price($value["id"]):0;
            $bilar[$c]["bes"] = ($CI->factor->price($value["id"])<0)?$CI->factor->price($value["id"])*-1:0;
            $c++;
        }
    }
}
    //------------------forpays
            $tmp=$CI->bed_beslib->get_list_bes_from_user($detail_users[0]["id"]);
if(count($tmp)) {
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
    $bilar, function ($a, $b) {
        return $a['date'] - $b['date'];
    }
);
            ?>

<table  class=" table table-hover table-striped" >

    <thead>
    <tr>
        <td><?php echo _ID ?></td>
        <td><?php echo _DATE ?></td>
        <td><?php echo _DATE.__._EXPIRE ?></td>
        <td><?php echo _DES ?></td>
        <td><?php echo _BEDEHKAR._R ?></td>
        <td><?php echo _BESTANKAR._R ?></td>
        <td><?php echo _REMIND._R ?></td>
        <td>!</td>



        <td class="dis_print" > </td>
    </tr>
    </thead>
    <?php  foreach ($bilar as $key => $value):
        $tbed+=$value["bed"];
        $tbes+=$value["bes"];
        $remind=$remind+$value["bed"]-$value["bes"];
        //--- for bed or bes per line
        if ($remind >0 ) {
            $typ=_BED;
        }
        else if($remind <0 ) {
            $typ=_BES;
            //            $remind*=-1;
        }
        else {
            $typ="";
        }
        ?>
        <tr>
            <td><?php echo $value["id"] ?></td>
            <td><?php echo ($value["date"])? $CI->piero_jdate->jdate("Y/m/d", $value["date"]):null; ?></td>
            <td><?php echo ($value["expire"])? $CI->piero_jdate->jdate("Y/m/d", $value["expire"]):null;?></td>
            <td><?php echo $value["des"] ?></td>
            <td><?php echo number_format($value["bed"])?></td>
            <td><?php echo number_format($value["bes"])?></td>
            <td><?php echo number_format(($remind>=0)?$remind:$remind*-1)  // if manfi not show manfi?></td>
            <td><?php echo $typ ?></td>
            <td class="dis_print" ><?php echo $value["op"]?></td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
    <tr>
        <td> # </td>
        <td>  </td>
        <td>  </td>
        <td> <?php echo _TOTAL_PLUS ?></td>
        <td><?php echo number_format($tbed) ?></td>
        <td><?php echo number_format($tbes) ?></td>
        <td><?php echo number_format($remind) ?></td>
        <td><?php echo $typ ?></td>
        <td class="dis_print">  </td>

    </tr>
    </tfoot>

</table>
<table  class=" table table-hover table-striped" >

    <thead>
    <tr>
        <td></td>
        <td><?php echo _REMIND ?></td>

        <td>  <?php echo number_format($remind)._R ?></td>


    </tr>
    </thead>


</table>
