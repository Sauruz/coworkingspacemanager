<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>

    <div class="bootstrap-wrapper">
        <ul class="nav nav-tabs">
            <li class="active"><a href="?page=csm-membership-overview&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-list" aria-hidden="true"></i> Membership Overview</a></li>
            <li><a href="?page=csm-membership-add&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Membership Plan</a></li>
            <li><a href="?page=csm-edit-member&member_identifier=<?php echo $data['identifier']; ?>"><i class="fa fa-fw fa-user" aria-hidden="true"></i> Profile of <?php echo $data['first_name'];?></a></li>
        </ul>
       
         <form id="memberships-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <input type="hidden" name="member_identifier" value="<?php echo $_REQUEST['member_identifier'] ?>" />
            <?php $MembershipTable->display(); ?>
        </form>
      
    </div>
</div>