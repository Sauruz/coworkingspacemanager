<div class="wrap">
    <h1 class="wp-heading-inline"><strong><?php echo __('Plans', 'csm');?></strong></h1>

    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/plans.tabbar.php'; ?>

        <form id="members-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <span ng-app="App">
                <?php $plansTable->display(); ?>
            </span>
        </form>
    </div>
</div>