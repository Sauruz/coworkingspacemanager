<ul class="nav nav-tabs">
    <li class="<?php tab_active('csm-plans'); ?>"><a href="?page=csm-plans"><i class="fa fa-fw fa-clock-o" aria-hidden="true"></i> <?php echo __('Plans', 'csm');?></a></li>
    <li class="<?php tab_active('csm-plan-add'); ?>"><a href="?page=csm-plan-add"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> <?php echo __('Add plan', 'csm');?></a></li>
    <?php if($_GET['page'] === 'csm-plan-edit') {?>
    <li class="<?php tab_active('csm-plan-edit'); ?>"><a href="?page=csm-plan-edit"><i class="fa fa-fw fa-edit" aria-hidden="true"></i> <?php echo __('Edit Plan', 'csm');?></a></li>
    <?php }?>
</ul>