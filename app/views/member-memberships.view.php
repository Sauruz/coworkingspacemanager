<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Membership Overview:</strong> <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>

    <div class="bootstrap-wrapper">

        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/member.tabbar.php'; ?>

        <div ng-app="App" ng-controller="ModalPaymentCtrl as Ctrl" class="modal-demo">
            <?php include CSM_PLUGIN_PATH . 'app/views/angular-templates.php'; ?>

            <form id="memberships-filter" method="get">
                <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <input type="hidden" name="member_identifier" value="<?php echo $_REQUEST['member_identifier'] ?>" />
                <span ng-app="App">
                    <?php $MembershipTable->display(); ?>
                </span>
            </form>
            <div id="payment-modal"></div>
        </div>

    </div>
</div>