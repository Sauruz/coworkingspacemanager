<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Membership Overview:</strong> <?php echo show_a_name($data); ?></h1>

    <div class="bootstrap-wrapper">

        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/member.tabbar.php'; ?>

        <div ng-app="App" ng-controller="Ctrl as Ctrl">
            <?php include CSM_PLUGIN_PATH . 'app/views/angular-templates.php'; ?>
            <form id="memberships-filter" method="get" action="">
                <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>" />
                <span ng-app="App">
                    <?php $MembershipTable->display(); ?>
                </span>
            </form>
            <div id="payment-modal"></div>
        </div>

    </div>
</div>