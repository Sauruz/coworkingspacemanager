<ul class="nav nav-tabs">
    <li class="<?php activeSlug($currentSlug, 'memberships'); ?>"><a href="<?php echo csm_permalink_url('memberships');?>"><i class="fa fa-fw fa-list" aria-hidden="true"></i> Overview</a></li>
    <?php if ($data['csm_frontend_membership']) { ?>
    <li class="<?php activeSlug($currentSlug, 'membership-add'); ?>"><a href="<?php echo csm_permalink_url('membership-add');?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Membership Plan</a></li>
    <?php } ?>
</ul>