<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Add Member</strong></h1>

    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/members.tabbar.php'; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" method="post">
                            <input name="action" type="hidden" value="addmember">
                            <?php include(CSM_PLUGIN_PATH . 'app/views/member-add-edit-table.view.php'); ?>
                            <p class="submit">
                                <input type="submit" name="createuser" id="createusersub" class="btn btn-primary btn-block" value="Add New Member">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>