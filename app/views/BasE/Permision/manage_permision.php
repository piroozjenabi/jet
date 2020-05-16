<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: lotus
 * Date: 8/31/16
 * Time: 5:33 PM
 */
$this->load->helper('form');
$list_permision_usergroup=$this->permision->list_cat_permision();
echo form_open('eemploy/eemploy_user_group/change_permision/'.$user_group_id); ?>
<div class="container">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <?php
            $c=0; //counter for color
            $active="";
            foreach ($list_permision_usergroup as $key => $value):
                $active=($c ==0) ? "active" : "";
                $c++;
                ?>

                <li class="<?php echo $active ?>" ><a data-toggle="pill"   href="#<?php echo $value["name"] ?>"><?php echo $value["des"] ?></a></li>
                <?php

            endforeach; ?>
            <li ><button type="submit" id="submit"  class="btn btn-success btn-block"  ><?php echo _SAVE ?></button type="submit">

            </li>
        </ul>
    </div>
    <div class="tab-content col-md-9">
        <?php
        $c=0; //counter for color
        $active="";
        foreach ($list_permision_usergroup as $key => $value):
            $active=($c ==0)?"active":"";
            if($c %2 == 0) {$bgcolor="#ecf0f1";
                $color="#000";
            }
            else
            {$color="#000";
                $bgcolor="#CFD8DC";
            }
            $c++
            ?>
            <div id="<?php echo $value["name"] ?>" class="tab-pane fade in <?php echo $active ?>" style="width: 100%;background-color: <?php echo $bgcolor ?>;color:<?php echo $color ?>;border-radius: 3px;padding: 10px; ">
                <h3><?php echo $value["des"] ?></h3>
                <div class="container" >
                <?php foreach ($this->permision->list_permision_usergroup($user_group_id, $value["id"])as $key2 => $value2): ?>
                    <div> <label> <input type="checkbox" name="perm[<?php echo $value2["id"] ?>]"   <?php echo ($value2["active"])? "checked='checked'":"" ?>> <?php echo $value2["des"] ?>

                            <?php
                            //if have menu
                            if($value2["menu"]) {
                                echo " <span class='label label-success'>"._MENU." </span> ";
                            }
                            //if have dashboard
                            if(count($this->permision->is_module($value2["id"]))) {
                                echo " <span class='label label-primary'>"._DASHBOARD." </span> ";
                            }
                                ?>


                        </label> </div>
                <?php  endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php echo $this->element->load_ajax_submit("form", 'eemploy/eemploy_user_group/change_permision/'.$user_group_id); ?>
