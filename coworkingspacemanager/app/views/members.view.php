<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Members</strong></h1>
    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/members.tabbar.php'; ?>

        <form id="members-filter" method="get">
            <p class="search-box">
                <label class="screen-reader-text" for="post-search-input">Search Members:</label>
                <input type="search" id="post-search-input" name="s" value="<?php echo isset($_GET['s']) ? $_GET['s'] : '';?>" />
                <input type="submit" id="search-submit" class="button" value="Search Members"  />
            </p>

            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <span ng-app="App">
                <?php $membersTable->display(); ?>
            </span>
        </form>
    </div>
</div>