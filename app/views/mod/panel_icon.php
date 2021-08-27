
<div style="height: 200px;overflow: hidden" class="<?= $propertis->root_css ?>" >
<div  class="<?= $propertis->css ?>">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3">
                <i class="<?= $propertis->icon ?>"></i>
            </div>
            <div class="col-xs-9 text-left">
                <div class="huge"><?= $db["num"]?></div>
                <div><?= $des ?></div>
            </div>
        </div>
    </div>
    <a  TARGET="<?= config("dashboard_target") ?>" href="<?= site_url($propertis->link) ?>">
        <div class="panel-footer">
            <span class="pull-left"><?= _VIEW_DETAILS ?></span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
    </a>
</div>
</div>