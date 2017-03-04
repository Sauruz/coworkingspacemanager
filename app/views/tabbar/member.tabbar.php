<ul class="nav nav-tabs">
    <li><a href="?page=<?php echo PLUGIN_SLUG; ?>"><i class="fa fa-fw fa-arrow-left" aria-hidden="true"></i> All Members</a></li>
    <li class="<?php tab_active('csm-membership-overview');?>"><a href="?page=csm-membership-overview&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-list" aria-hidden="true"></i> Memberships Overview</a></li>
    <li class="<?php tab_active('csm-membership-add');?>"><a href="?page=csm-membership-add&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> New Membership <?php echo $data['first_name']; ?></a></li>
    <li class="<?php tab_active('csm-profile');?>"><a href="?page=csm-profile&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-user" aria-hidden="true"></i> Profile Of <?php echo $data['first_name']; ?></a></li>
</ul>