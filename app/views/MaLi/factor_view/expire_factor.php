<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */ ?>
<style type="text/css">
 .factor_first_col_fa{
  font-family: yekan;
  font-size: 9px;
  text-align: right;

 }
  .factor_first_col_en{
  font-family: franklin;
  font-size: 9px;
  text-align: right;
 }
.factor_first_col_fa tr td{
border-bottom: 1px solid #ccc;
}
</style>
  <div   class="col-sm-<?php echo $width ?> <?php echo $propertis->css ?>"  >
<table class="table table-striped">

      <tr>
         <td ><?php echo $name ?></td>
         <td><?php echo $db ?></td>
      </tr>




   </table>
</div>
