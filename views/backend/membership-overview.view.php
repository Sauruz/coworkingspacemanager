<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Membership Overview:</strong> <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>

    <div class="bootstrap-wrapper">
        
        <?php include CSM_PLUGIN_PATH . 'views/backend/tabbar/member.tabbar.php';?>
       
         <form id="memberships-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <input type="hidden" name="member_identifier" value="<?php echo $_REQUEST['member_identifier'] ?>" />
            <?php $MembershipTable->display(); ?>
        </form>
      
    </div>
</div>