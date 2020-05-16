<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$prdlist=$this->element->list_db("prd", "id,name_shop,name", "order_by");
//print_r($res);
$flgtabactive="active";
?>
<div style="background-color: #cccccc">

<ul class="nav nav-tabs " >




<?php foreach ($prdlist as $key => $value):
    ?>
    <li><a data-toggle="tab" href="#<?php echo $value['id'] ?>"><?php echo $value['name_shop'] ?></a></li>


<?php endforeach; ?>
</ul>

<div class="tab-content" >

    <?php foreach ($prdlist as $key => $value):
    ?>



            <div id="<?php echo $value['id'] ?>" class="tab-pane fade in <?php echo $flgtabactive ;$flgtabactive="";  ?>  ">

                <h3><?php echo $value['name'] ?></h3>
<br>
                <table class=" table table-hover table-striped" >
                    <tr>

                        <td ><?php echo _FROM._R ?></td>
                        <td ><?php echo _TO._R ?></td>
                        <td ><?php echo _COMMISSION ?></td>
                    </tr>
                    <?php foreach ($res as $key3 => $value3):?>
                    <?php if($value3['prd'] == $value["id"]) : ?>
                        <tr>

                            <td ><?php echo number_format($value3['fromc']) ?></td>
                            <td ><?php echo number_format($value3['toc']) ?></td>
                            <td ><?php echo $value3['value_percent'] ?> % </td>
                        </tr>

                    <?php endif; ?>
                    <?php endforeach; ?>
                </table>



            </div>




    <?php endforeach; ?>

</div>
</div>
