<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */

$discount_flag=0;
$client_price_flag=0;
$rowplus_flag=0;
foreach ($db['prd'] as $key => $value){
    $discount_flag=($value["takhfif"] > 0 )?1:$discount_flag;
    $client_price_flag=($value["price_client"] > 0 )?1:$client_price_flag;
    $rowplus_flag=(isset($value["row_plus"])  )?1:$rowplus_flag;
}

?>
<style type="text/css">
    .factor_prd {
  font-family: pieroyekanmix;
  font-size: 9px;
  text-align: center;
 }
 .factor_prd .headfa{
  font-family: pieroyekanmix;
  font-size: 9px;
  text-align: center;
  background-color: #4d4d4d;
  color: #fff;

 }
 .factor_prd .headen{

  font-family: pieroyekanmix;
  font-size: 9px;
  text-align: center;
  background-color: #4d4d4d;
  color: #fff;

 }
  .total{
  font-family: pieroyekanmix;
 background-color: #4d4d4d;
  color: #fff;

 }
 .total td {height: 25px;line-height: 300%;}
 .fa{font-family: yekan;font-size: 11px;text-align: right; line-height: 300%;}
 .en{text-align: left;font-family:pieroyekanmix ;font-size: 11px}
  .bgf2 td {border-top:3px solid #000;}
 .bgc2{background-color: #111;}
 .bgf{background-color: #fff;}
 .bgc{background-color: #e2e2e2;}
.col-sm-3{width: 35%;}
.col-sm-2{width: 12%;}
.col-sm-1{width: 5%;}



</style>
  <div   class="col-sm-<?php echo $width ?> <?php echo $propertis->css ?>" >
    <?php echo $name ?>
<table >
    <?php if(config("title_en")) :?>
       <tr class="headen">
        <?php if(config("show_total_price")) :?>
            <th class="col-sm-2" ><?php echo _PRICE_TOTAL_EN ?></th>
        <?php endif;?>

               <th class="col-sm-2" >
                    <?php
                    if (config("show_client_price") && $client_price_flag) {
                        echo _CLIENT_PRICE_EN ;
                    }
                    else if(config("show_off") && $discount_flag) {
                           echo _TAKHFIF_EN ;

                    }
                    else if($rowplus_flag) {
                         echo _FACTOR_ROW_PLUS_2;
                    }
                    ?>
               </th>

        <?php if(config("show_price")) :?>
            <th class="col-sm-2" ><?php echo _VAHED_EN._PRICE_EN._R_EN ?></th>
        <?php endif;?>

        <?php if(config("show_unit")) :?>
            <th class="col-sm-2" ><?php echo _VAHED_EN?> </th>
        <?php endif;?>

            <?php if(config("show_unit_main")) :?>
               <th class="col-sm-2" ><?php echo _NUM_EN ?> <?php echo config("perfix_main_unit_en")?></th>
            <?php endif;?>
            <?php if(config("show_unit_alt")) :?>
               <th class="col-sm-2" ><?php echo _NUM_EN ?> <?php echo config("perfix_alt_unit_en")?></th>
            <?php endif;?>
        <?php if(config("show_des_prd")) :?>
            <th class="col-sm-3" ><?php echo _DES_EN._KALA_EN ?></th>
        <?php endif;?>
        <?php if(config("show_code_prd")) :?>
            <th class="col-sm-1" ><?php echo _CODE_EN ?></th>
        <?php endif;?>
      </tr>
    <?php endif;?>
    <?php if(config("title_fa")) :?>
      <tr class="headfa">
            <?php if(config("show_total_price")) :?>
             <th class="col-sm-2" ><?php echo _PRICE_TOTAL._R ?></th>
            <?php endif;?>
          <th class="col-sm-2" >
            <?php
            if (config("show_client_price") && $client_price_flag) {
                echo _CLIENT_PRICE ;
            }
            else if(config("show_off") && $discount_flag) {
                  echo _TAKHFIF ;

            }
            else if($rowplus_flag) {
                   echo _FACTOR_ROW_PLUS_;
            }
            ?>
          </th>
            <?php if(config("show_price")) :?>
            <th class="col-sm-2" ><?php echo _PRICE._VAHED._R ?></th>
            <?php endif;?>
            <?php if(config("show_unit")) :?>
             <th class="col-sm-2" ><?php echo _VAHED?></th>
            <?php endif;?>

            <?php if(config("show_unit_main")) :?>
              <th class="col-sm-2" ><?php echo _NUM ?> <?php echo config("perfix_main_unit_fa")?></th>
            <?php endif;?>
            <?php if(config("show_unit_alt")) :?>
              <th class="col-sm-2" ><?php echo _NUM ?> <?php echo config("perfix_alt_unit_fa")?></th>
            <?php endif;?>
            <?php if(config("show_des_prd")) :?>
            <th class="col-sm-3" ><?php echo _DES._KALA ?></th>
            <?php endif;?>
            <?php if(config("show_code_prd")) :?>
            <th class="col-sm-1" ><?php echo _CODE._KALA ?></th>
            <?php endif;?>
      </tr>
    <?php endif;?>

    <tbody>
    <?php
    $i=0;
    $all_totalprd=0;
    $all_totalprd_client=0;

    //for prd
    foreach ($db['prd'] as $key => $value): ?>

        <?php
           $totalprd=$value["price"]*$value["num"]-$value["takhfif"];
           $all_totalprd += $totalprd;
           $i++;
        if($i % 2 ==0) {
            $tblbg='class="bgc"';
        } else {
             $tblbg='class="bgf"';
        }
           //DISCOUNT PRD
        $dis_unt=$value["takhfif"]/$value["num"];
        $tprd=$value["price"]*$value["num"];
        if ($value["price"]>0) {
            $discount_line=price(($value["takhfif"]/$tprd)*100, 1);
        }

           //total client price
           $all_totalprd_client+=($value["price_client"]*$value["num"]);
        ?>
      <tr <?php echo $tblbg ?> >
            <?php if(config("show_total_price")) :?>
            <td><?php echo ($totalprd)?(@$propertis->free == "1")?_FREE:price($totalprd):_FREE  ?></td>
            <?php endif;?>
         <td class="col-sm-2" >
            <?php
            //fro print price of client
            if($value["price_client"]) {
                echo  price($value["price_client"]);
            }
            //for print takhfif
            else if(config("show_off") && $value["takhfif"] >0) {
                echo   $discount_line.  '% -' . price($value["takhfif"]).  '<br>' . price($value["price"] -$dis_unt);


            }
            else if(isset($value["row_plus"])) {
                echo $value["row_plus"];
            }
            ?>

          </td>
            <?php if(config("show_price")) :?>
            <td  ><?php echo ($value["price"]>0)? (isset($propertis->free) && $propertis->free == "1")?_FREE:price($value["price"]): _FREE  ?></td>
            <?php endif;?>
            <?php if(config("show_unit")) :?>
            <td><?php echo $value["vahed_asli_name"] ?></td>
            <?php endif;?>
            <?php if(config("show_unit_main")) :?>
              <td><?php echo $value["num"] ?></td>
            <?php endif;?>
            <?php if(config("show_unit_alt")) :?>
            <td  ><?php echo $alt_num ?></td>
            <?php endif;?>
            <?php if(config("show_des_prd")) :?>
             <td style="text-align: left;" ><?php echo $value["name"] ?></td>
            <?php endif;?>
            <?php if(config("show_code_prd")) :?>
            <td><?php echo $value["prd_id"] ?></td>
            <?php endif;?>
      </tr>

    <?php endforeach ;
      //for kosoorat
    foreach ($db['kosoorat'] as $key => $value): ?>
        <?php
          $totalprd=$value["price"];
          $discount_percent=price(($totalprd/$all_totalprd)*100, 2);
          $all_totalprd -= $totalprd;
          $i++;
        if($i % 2 ==0) {
            $tblbg='class="bgc"';
        } else {
            $tblbg='class="bgf"';
        }
        ?>
      <tr <?php echo $tblbg ?> >

      <td style="height: 22px;line-height: 25px" ><?php echo price($totalprd); ?></td>
      <td  ></td>
      <td style=";height: 22px;line-height: 25px" >-<?php echo ($propertis->free == "1")?_FREE:price($value["price"])  ?></td>
      <td  style=";height: 22px;line-height: 25px;font-size: 11px" ><b><?php echo $discount_percent ?>%</b></td>
      <td></td>
      <td style="text-align: left;height: 22px;line-height: 25px" ><?php echo $value["name"] ?></td>
      <td></td>
      </tr>

    <?php endforeach ;
            //for ezafat
    foreach ($db['ezafat'] as $key => $value): ?>
        <?php
          $totalprd=$value["price"];
          //$discount_percent=number_format(($totalprd/$all_totalprd)*100,2);
          $all_totalprd -= $totalprd;
          $i++;
        if($i % 2 ==0) {
            $tblbg='class="bgc"';
        } else {
            $tblbg='class="bgf"';
        }
        ?>
      <tr <?php echo $tblbg ?> >

      <td style="height: 22px;line-height: 25px" ><?= price($totalprd); ?></td>
      <td  ></td>
      <td  ></td>
<!--      <td style=";height: 22px;line-height: 25px;font-size: 15px" ><b>--><?//= $discount_percent ?><!--% </b></td>-->
      <td  style=";height: 22px;line-height: 25px" >+<?php echo (@$propertis->free == "1")?_FREE:price($value["price"]) ?></td>
      <td></td>
      <td style="text-align: left;height: 22px;line-height: 25px" > <?php echo $value["name"] ?></td>
      <td></td>
      </tr>

    <?php endforeach ?>
        <?php
        $flg=0;
        $numfor=($client_price_flag)?11:12;
        for ($j=$i; $j <=$numfor ; $j++) {
            $i++;
            if($i % 2 ==0) {
                $tblbg='class="bgc';
            } else {
                $tblbg='class="bgf';
            }
            if ($flg==0) {
                $tblbg.=" bgf2 ";
                $flg=1;
            }

            echo '<tr '.$tblbg.'" > <td>  <br><br> </td> <td></td> <td></td>
                    <td></td><td></td><td></td><td></td> </tr>';
        }
        ?>

    <?php if (@$propertis->show_total!="off") : ?>
    <?php if ($client_price_flag) : ?>
        <tr>
            <td colspan="7" class="fa" > <?php echo _PRICE_TOTAL.price($all_totalprd_client) ?> </td>
        </tr>
    <?php endif ?>
      <tr class="total">
        <td class="fa" colspan="4" ><?php echo _LAST_PRICE._R ?>
        <?php echo (@$propertis->free == "1")?_FREE:price($all_totalprd) ?></td>
                 <td> </td>
        <td colspan="2" class="en"><?php echo _SUB_TOTAL_EN ?>  <?php echo (@$propertis->free == "1")?_FREE_OF_CHARGE_EN:_R_EN. price($all_totalprd); ?>  </td>

      </tr>
      <tr >
        <td class="fa" colspan="6" > <?php echo _PRICE_TOTAL_STRING?>:
            <?php echo (@$propertis->free == "1")?_FREE:$this->num2word->convert_number($all_totalprd) ._R ;  ?>  </td>


      </tr>
    <?php endif ?>
   </table>
</div>
