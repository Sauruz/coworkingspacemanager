<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Add Member</strong></h1>

    <div class="bootstrap-wrapper">
        <ul class="nav nav-tabs">
            <li><a href="?page=<?php echo PLUGIN_SLUG; ?>"><i class="fa fa-fw fa-users" aria-hidden="true"></i> All Members</a></li>
            <li class="active"><a href="?page=csm-add-member"><i class="fa fa-plus" aria-hidden="true"></i> Add Member</a></li>
        </ul>

        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" method="post">
                            <input name="action" type="hidden" value="addmember">
                            <?php include(CSM_PLUGIN_PATH . 'views/backend/member-add-edit-table.view.php'); ?>
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