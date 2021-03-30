<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$CI =& get_instance();
$CI->load->library('Piero_jdate');
$total_price=0;
$total_pay=0;
$total_com=0;
$last_factor=0;
?>

<table class=" table table-hover table-striped" >

    <thead>
    <td><?php echo _NAME.__._KARSHENAS ?></td>
    <td><?php echo _COMMISSION . _R?></td>
    <td><?php echo _MABLAGH.__._KOL.__._FOROOSH._R?></td>
    <td><?php echo _MABLAGH.__._FOROOSH.__._PERIOD._R?></td>
    <td><?php echo _MABLAGH.__._DARIAFTI._R?></td>
    <td><?php echo _LAST." "._FACTOR?></td>
    <td></td>
    </thead>
<?php foreach ($res as $key => $value):
    $total_com +=$value['commission'];
    $total_price +=$value['factor_total'];
    $total_pay +=$value['total_pay'];
        $last_factor=($last_factor<$value['last_date'])?$value['last_date']:$last_factor;
    ?>

<tr>

    <td  >
        <p data-toggle="tooltip" data-placement="bottom"  title="<?php echo $value['address'] . " - " .$value['tell'] ?>" >
        <?php echo $value['name'] ?>

        </p>
    </td>

    <td>
        <a TARGET="<?php echo $this->system->get_setting("my_eemploy_target") ?>" href="<?php echo site_url('MaLi/factor_sell/manage_factor/this_month/'.$value['id']); ?>" >
        <?php echo number_format($value['commission'])  ?>
        </a>
    </td>
    <td>
        <?php echo number_format($value['factor_total'])  ?>
    </td>
    <td>


        <a TARGET="<?php echo $this->system->get_setting("my_eemploy_target") ?>" href="<?php echo site_url('MaLi/factor_sell/manage_factor/this_month/'.$value['id']); ?>" >
        <?php $limit_sell= number_format($value['sell_price']- $this->system->get_user_admin_from_id($value['id'], "limit_sell"));
        $strng_title=_REMIND.__._MIN_LIMIT_SELL." = ".$limit_sell." | "._MIN_LIMIT_SELL."=".number_format($this->system->get_user_admin_from_id($value['id'], "limit_sell"));
        $strng_title.=($this->system->get_setting("salary_this_mount_percent")>0)?'|' . _SALARY_THIS_MOUNTH.$value['sell_price']*$this->system->get_setting("salary_this_mount_percent"):"";
        echo "<p data-toggle='tooltip' data-placement='bottom' title='$strng_title' > <i class='fa fa-dot-circle-o' > </i> ".number_format($value['sell_price'])." </p> ";
        ?>
        </a>

    </td>

    <td>
        <?php echo number_format($value['total_pay'])  ?>
    </td>

    <td>

        <?php echo ($value['last_date']!=0) ?$CI->piero_jdate->jdate("Y/m/d", $value['last_date']):0;   ?>
    </td>

        <td>
            <a TARGET="<?php echo $this->system->get_setting("my_eemploy_target") ?>" href="<?php echo site_url('CRM/my_client/index')."/".$value['id']; ?>" class="btn btn-default">
              <i class="fa fa-users" ></i>  <?php echo _CLIENT_LIST?>

            </a>


            <a TARGET="<?php echo $this->system->get_setting("my_eemploy_target") ?>" href="<?php echo site_url('MaLi/factor_sell/manage_factor/index/public/'.$this->system->get_setting("main_factor_level").'/'.$value['id']); ?>" class="btn btn-default">
              <i class="fa fa-list" ></i>  <?php echo _FACTOR_SELL?>

            </a>

            <a TARGET="<?php echo $this->system->get_setting("my_eemploy_target") ?>" href="<?php echo site_url('CRM/Promoter/manage/'.$value['id']); ?>" class="btn btn-default">
              <i class="fa fa-money" ></i>  <?php echo _PROMOTER?>

            </a>

        </td>
</tr>


<?php endforeach; ?>
  <tr>
      <tfoot>
      <td><?php echo _TOTAL_PLUS ?></td>
      <td><?php echo number_format($total_com)  ?></td>
      <td><?php echo number_format($total_price)  ?></td>
      <td><?php echo number_format($total_pay)  ?></td>
        <td></td>
      <td> <?php echo ($last_factor!=0) ?$CI->piero_jdate->jdate("Y/m/d", $last_factor):0;   ?></td>
      <td>
          <a TARGET="<?php echo $this->system->get_setting("my_eemploy_target") ?>" href="<?php echo site_url('MaLi/pusers/users/manage_all'); ?>" class="btn btn-danger">
              <i class="fa fa-users" ></i>  <?php echo _LIST._ALL._CLIENTS?>

          </a>


          <a href="<?php echo site_url('MaLi/factor_sell/manage_factor/index/public/'.$this->system->get_setting("main_factor_level")); ?>" class="btn btn-danger">
              <i class="fa fa-list" ></i>  <?php echo _LIST._ALL._FACTOR_SELL?>

          </a>


      </td>
      </tr>
      </tfoot>

</table>
