<ul class="nav nav-tabs">
    <li><a href="?page=<?php echo PLUGIN_SLUG; ?>"><i class="fa fa-fw fa-arrow-left" aria-hidden="true"></i> All Members</a></li>
    <li class="<?php tab_active('csm-member-memberships');?>"><a href="?page=csm-member-memberships&id=<?php echo $data->id; ?>"><i class="fa fa-fw fa-list" aria-hidden="true"></i> Membership Overview</a></li>
    <li class="<?php tab_active('csm-member-membership-add');?>"><a href="?page=csm-member-membership-add&id=<?php echo $data->id; ?>"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> New Membership <?php echo $data->first_name; ?></a></li>
    <li class="<?php tab_active('csm-member-profile');?>"><a href="?page=csm-member-profile&id=<?php echo $data->id; ?>"><i class="fa fa-fw fa-user" aria-hidden="true"></i> Profile Of <?php echo $data->first_name; ?></a></li>
</ul>