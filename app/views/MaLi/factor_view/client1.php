<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */ ?>
  <div   class="col-sm-<?php echo $width ?>">
<table class="table table-striped">
    <thead>
      <tr>
        <th colspan="2"><?php echo $name ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo _NAME_CLIENT ?></td>
        <td><?php print_r($db[0]->name. " " .$db[0]->lname) ?></td>
      </tr>
        <tr>
        <td><?php echo _AGENT ?></td>
        <td><?php echo $db[0]->agent ?></td>
      </tr>
       </tbody>
        <tr>
        <td><?php echo _ADDRESS ?></td>
        <td><?php echo $db[0]->address ?></td>
      </tr>

        <tr>
        <td><?php echo _COMMERICAL_ID ?></td>
        <td><?php echo $db[0]->comerical_id ?></td>
      </tr>
            </tr>
        <tr>
        <td><?php echo _TELL ?></td>
        <td><?php echo $db[0]->tell ?></td>
      </tr>
            </tr>
        <tr>
        <td><?php echo _MOBILE ?></td>
        <td><?php echo $db[0]->mobile ?></td>
      </tr>
                  </tr>
        <tr>
        <td><?php echo _ID_CLIENT ?></td>
        <td><?php echo $db[0]->id ?></td>
      </tr>
    </table>
</div>
