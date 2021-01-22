<legend><?php echo _MANAGE.__._STOCK._S ?></legend>
<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->library("element");
echo  $CI->element->quick_add("Stock/Stock/padd", array("0"=>array("name"=>"name","placeholder"=>_NAME , "type" => "input"),"1"=>array("name"=>"des","placeholder"=>_DES , "type" => "input"),"2"=>array("name"=>"parent","data" =>$this->element->pselect("stock") ,"placeholder"=>_PARENT_STOCK , "type" => "dropdown")));
?>
<table class=" table table-hover table-striped" >
    <thead >
    <tr >
        <td><?php echo _ID?></td>
        <td><?php echo _NAME?></td>
        <td><?php echo _DES?></td>
        <td><?php echo _PARENT_STOCK?></td>

        <td></td>
    </tr>
    </thead>


    <?php foreach ($db as $key => $value):?>
    <tr>
    <td><?php echo $value["id"] ?></td>
    <td>
        <?php echo $this->element->edit_text($value["id"], $value["name"], "stock", "name", "text") ?>
    </td>
        <td>
        <?php echo $this->element->edit_text($value["id"], $value["des"], "stock", "des", "text") ?>
    </td>

        <td><?php echo ($value["parent"])?getQuick("stock", $value["parent"], 'name'):""  ?></td>
        <td>

        </td>


    </tr>
    <?php endforeach; ?>

</table>
