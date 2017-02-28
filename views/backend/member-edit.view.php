<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>
    
    <div class="bootstrap-wrapper">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">Profile</a></li>
        <li><a href="?page=<?php echo $_REQUEST['page'];?>&action=add-membership-plan&identifier=<?php echo $data['identifier'];?>">Add Membership Plan</a></li>
        <li><a href="?page=<?php echo $_REQUEST['page'];?>&action=membership-history&identifier=<?php echo $data['identifier'];?>">Membership History</a></li>
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
</div>