<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>

    <div class="bootstrap-wrapper">
        <ul class="nav nav-tabs">
            <li class="active"><a href="?page=csm-membership-overview&member_identifier=<?php echo $data['identifier']; ?>">Membership Overview</a></li>
            <li><a href="?page=csm-membership-add&member_identifier=<?php echo $data['identifier']; ?>">Add Membership Plan</a></li>
            <li><a href="?page=csm-edit-member&member_identifier=<?php echo $data['identifier']; ?>">Profile of <?php echo $data['first_name'];?></a></li>
        </ul>
       
         <form id="members-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $MembershipTable->display(); ?>
        </form>
      
    </div>
</div>