<div class="wrap" ng-app="App" ng-controller="Ctrl as Ctrl">
    <h1 class="wp-heading-inline"><?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>

    <div class="bootstrap-wrapper">
        <ul class="nav nav-tabs">
            <li><a href="?page=<?php echo $_REQUEST['page']; ?>&action=editmember&identifier=<?php echo $data['identifier']; ?>">Profile</a></li>
            <li><a href="?page=<?php echo $_REQUEST['page']; ?>&action=add-membership-plan&identifier=<?php echo $data['identifier']; ?>">Add Membership Plan</a></li>
            <li class="active"><a href="#">Membership History</a></li>
        </ul>
       
         <form id="members-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $MembershipTable->display(); ?>
        </form>
      
    </div>
</div>