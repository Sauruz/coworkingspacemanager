<div class="wrap">
    <h1 class="wp-heading-inline"><strong><?php echo __('Profile', 'csm');?>:</strong> <?php echo show_a_name($data); ?></h1>

    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/member.tabbar.php'; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" method="post">
                            <input name="action" type="hidden" value="editmember">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 text-center">
                                    <img class="avatar-big" src="<?php echo get_avatar_url($data['id']); ?>">
                                    <hr>
                                </div>
                            </div>
                            <?php include(CSM_PLUGIN_PATH . 'app/views/member-add-edit-table.view.php'); ?>
                            <p class="submit">
                                <input type="submit" name="createuser" id="createusersub" class="btn btn-success btn-block" value="<?php echo __('Save', 'csm');?>">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>