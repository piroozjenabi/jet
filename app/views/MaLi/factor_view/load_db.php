<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */?>
<style type="text/css">
  .factor_pre_client_fa * {
  position: absolute;
  text-align: right;
  float: right;
  font-size: 9px;
  font-family: yekan;
  padding: 2px;
  background-color: #fff;
}
.factor_pre_client_fa tr td , {
border-bottom: 1px solid #ccc;

}


.factor_pre_client_fa tr .val ,.factor_pre_client_en tr .val {
width: 75%;}
.factor_pre_client_fa tr .key ,.factor_pre_client_en tr .key {
width: 25%;}

.factor_pre_client_fa tr .valmix ,.factor_pre_client_en tr .valmix {
width: 75%;font-family: pieroyekanmix;}
.factor_pre_client_en * {
  font-family: franklin;
  text-align: left;
  float: left !important ;
  direction: ltr;
  padding: 2px;
  direction: ltr !important ;
    font-size: 9px;

}
.factor_pre_client_en tr td , {
border-bottom: 1px solid #ccc;
float: left;

}
</style>
    <?php // @@ baraie tashkhis tarkibat mixi ba estefade az ++ mibashad
?>
  <div   class="<?php echo $propertis->css ?>"  >
<table class="table table-striped <?php echo $propertis->css ?> ">

      <tr >
        <th colspan="2"><?php echo $name ?></th>
      </tr>
    <?php foreach ($db as $key => $value): ?>
      <tr>
            <?php  if($dir=="rtl") :  ?>
          <td class="key" ><?php echo $key ?></td>
            <?php if(strpos($value, "@@")  ) :
                $value=str_replace("@@", "", $value);
            ?>
        <td class="valmix"><?php echo $value ?></td>
            <?php else: ?>
        <td class="val"><?php echo $value ?></td>
            <?php endif ?>

            <?php  endif; ?>
            <?php  if($dir=="ltr") :  ?>
            <?php if(strpos($value, "@@")  ) :
                $value=str_replace("@@", "", $value);
            ?>
        <td class="valmix"><?php echo $value ?></td>
            <?php else: ?>
        <td class="val"><?php echo $value ?></td>
            <?php endif ?>
          <td class="key" ><?php echo $key ?></td>
            <?php  endif; ?>

      </tr>
    <?php endforeach ?>

   </table>
</div>
