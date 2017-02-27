<div class="wrap">
    <h1 class="wp-heading-inline">Edit member <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>
    <ul class="nav nav-tabs">
        <li><a href="?page=<?php echo PLUGIN_SLUG;?>">Members</a></li>
        <li><a href="?page=csm-add-member">Add Member</a></li>
        <li class="active"><a href="#">Edit member <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></a></li>
    </ul>
    
    <div class="row">
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-body">
                    <form action="" method="post">
                        <input name="action" type="hidden" value="editmember">
                        <?php include(CSM_PLUGIN_PATH . 'views/backend/member-add-edit-table.view.php'); ?>
                        <p class="submit">
                            <input type="submit" name="createuser" id="createusersub" class="btn btn-primary btn-block" value="Edit Member">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>