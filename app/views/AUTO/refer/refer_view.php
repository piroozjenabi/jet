<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
$this->load->library("Auto");
$list_type=$this->auto->list_subject_refer();
//trace($forms);
?>
    <h2 class="page-header"> <?php echo _REFER ._S?> </h2>
    <table class="table table-hover table-striped dataTbl"  >
        <thead>
        <tr>
            <td>#</td>
            <td><?php echo _ID?></td>
            <td><?php echo _NUMBER?></td>
            <td><?php echo _DES.__._REFER?></td>
            <td><?php echo _DATE.__._REFER?></td>
            <td><?php echo _REFER_TO?></td>
            <td><?php echo _TYPE.__._FORM?></td>
            <td><?php echo _SUBJECT_REFER?></td>
            <td><?php echo _STATE.__._REFER?></td>
            <td><?php echo _MORE_INFO?></td>
        </tr>
        </thead>
<tbody>
<?php $c=1;
$atts["class"]='btn btn-info';
foreach ($forms as $key => $value):
    $tmp=null;
    switch ($value['state'])
    {
    case 1:
        $tmp="style='background:#80CBC4'";
        break;
    case 2:
        $tmp="style='background:#ffcdd2'";
        break;
    }
    ?>
    <tr id="row-<?php echo $value["id"]?>" <?php echo $tmp?> ondblclick="load_ajax_popupfull('<?php echo site_url("AUTO/Manage/show_form") ?>','id=<?php echo $value["mainid"] ?>')" >
    <?php $form_id=$value["form_value_id"];
    $main_id=$value["mainid"];
            $show_link= site_url("AUTO/Manage/show_form");

            ?>
        <td><?php echo $c; ?></td>
        <td><?php echo $value["id"] ?></td>
        <td><?php echo "<a class='btn btn-default' onclick=load_ajax_popupfull('$show_link','id=$main_id')>". $value["form_value_id"] ."</a>" ?></td>
        <td><?php echo $value["des"] ?>
            <?php echo ($value["state"]==2)?"<br>"._DES.__._AUTO_REJECT.":".json_decode($value["params"])->des_reject." --- "._DATE.__._AUTO_REJECT.":".$this->piero_jdate->jdate("Y/m/d", json_decode($value["params"])->date_reject):null; ?>
        </td>
        <td><?php echo $this->piero_jdate->jdate("Y/m/d", $value["date"])  ?></td>
        <td><?php echo $this->system->get_user_admin_from_id($value["to_user_id"]) ?></td>
        <td><?php echo $this->auto->get_form_from_value_id($form_id)[0]["name"] ?></td>
        <td><?php echo $value["subject_name"] ?></td>
        <td><?php echo $this->auto->print_state($value["state"]) ?></td>
        <td><?php echo $this->auto->show_list($value["mainid"]) ?></td>

    </tr>
    <?php $c++;
endforeach; ?>
</tbody>
</table>
