<ul class="nav nav-tabs">
    <li><a href="?page=<?php echo PLUGIN_SLUG; ?>"><i class="fa fa-fw fa-arrow-left" aria-hidden="true"></i> All Members</a></li>
    <li class="<?php tab_active('csm-membership-overview');?>"><a href="?page=csm-membership-overview&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-list" aria-hidden="true"></i> Membership Overview</a></li>
    <li class="<?php tab_active('csm-membership-add');?>"><a href="?page=csm-membership-add&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Membership Plan</a></li>
    <li class="<?php tab_active('csm-edit-member');?>"><a href="?page=csm-edit-member&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-user" aria-hidden="true"></i> Profile of <?php echo $data['first_name']; ?></a></li>
    <li class="<?php tab_active('csm-member-messages');?>"><a href="?page=csm-member-messages&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-comment-o" aria-hidden="true"></i> Messages to <?php echo $data['first_name']; ?></a></li>
</ul>