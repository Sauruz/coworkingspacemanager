<ul class="nav nav-tabs">
    <li><a href="?page=csm-members"><i class="fa fa-fw fa-arrow-left" aria-hidden="true"></i> <?php echo __('All Members', 'csm');?></a></li>
    <li class="<?php tab_active('csm-member-memberships');?>"><a href="?page=csm-member-memberships&id=<?php echo $data['id']; ?>"><i class="fa fa-fw fa-list" aria-hidden="true"></i> <?php echo __('Membership Overview', 'csm');?></a></li>
    <li class="<?php tab_active('csm-member-membership-add');?>"><a href="?page=csm-member-membership-add&id=<?php echo $data['id']; ?>"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> <?php echo __('New Membership', 'csm');?> <?php echo show_a_name($data); ?></a></li>
    <li class="<?php tab_active('csm-member-profile');?>"><a href="?page=csm-member-profile&id=<?php echo $data['id']; ?>"><i class="fa fa-fw fa-user" aria-hidden="true"></i> <?php echo __('Profile Of', 'csm');?> <?php echo show_a_name($data); ?></a></li>
</ul>