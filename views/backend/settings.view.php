<div class="wrap">
    <h1 class="wp-heading-inline"><strong>General Settings</strong></h1>

    <div class="bootstrap-wrapper">
        <ul class="nav nav-tabs">
            <li class="active"><a href="?page=csm-settings"><i class="fa fa-fw fa-cogs" aria-hidden="true"></i> General Settings</a></li>
            <li><a href="?page=csm-settings-plans"><i class="fa fa-fw fa-clock-o" aria-hidden="true"></i> Plans</a></li>
            <li><a href="?page=csm-settings-workplaces"><i class="fa fa-fw fa-desktop" aria-hidden="true"></i> Workplaces</a></li>
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