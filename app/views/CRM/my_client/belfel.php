<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$all_price=0;
?>

<table class=" table table-hover table-striped" >
    <thead>
<td><?=_ID ?></td>
<td><?=_NAME ?></td>
<td><?=_TOTAL_PLUS." "._FACTOR._S ?></td>
<td><?= _DATE.__._LAST.__._FACTOR ?></td>
<td><?= _MAKER ?></td>
    <td></td>
    </thead>
    <tbody>
    <?php foreach ($res as $key => $value):
//    print_r($value);
        $all_price +=$value['total_price']
        ?>

        <tr>
            <td><?= $value['perfix_code'] ?><?= $value['id'] ?></td>
            <td  >
                <p  data-placement="bottom" data-toggle="tooltip" data-original-title="<?= $value['address'] . " - " .$value['tell']. " - " .$value['mobile'] ?>" >
                    <?= $value['name'] ?>
                    <?php if($value["agent"])
                        echo  "-". $value['agent'];
                    ?>
                </p>
            </td>
            <td><?= number_format($value['total_price'])._R ?></td>
            <td><?=$this->piero_jdate->jdate("Y/m/d",$value['last_date']);  ?></td>
            <td><?= $this->system->get_user_eemploy_from_id($value['maker_id']) ;  ?></td>
            <td><a class='btn btn-info' href='<?= site_url("CRM/my_client/tracks/".$value["id"]) ?>'> <i class="fa fa-list-alt"></i> <?= _PEIGIRI._S ?> </a></td>
        </tr>


    <?php endforeach; ?>
    <tfoot>
        <td></td>
        <td><?= _TOTAL_PLUS ?></td>
        <td> <?= number_format($all_price)._R ?></td>
    </tfoot>
    </tbody>
</table>
