<ul class="nav nav-tabs">
    <li class="<?php tab_active('csm-workplaces'); ?>"><a href="?page=csm-workplaces"><i class="fa fa-fw fa-desktop" aria-hidden="true"></i> Workplaces</a></li>
    <li class="<?php tab_active('csm-workplace-add'); ?>"><a href="?page=csm-workplace-add"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Workplace</a></li>
    <?php if($_GET['page'] === 'csm-workplace-edit') {?>
    <li class="<?php tab_active('csm-workplace-edit'); ?>"><a href="?page=csm-workplace-edit"><i class="fa fa-fw fa-edit" aria-hidden="true"></i> Edit Workplace</a></li>
    <?php }?>

</ul>