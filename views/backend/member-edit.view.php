<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>
    
    <div class="bootstrap-wrapper">
    <ul class="nav nav-tabs">
        <li><a href="?page=csm-membership-overview&member_identifier=<?php echo $data['identifier'];?>">Membership Overview</a></li>
        <li><a href="?page=csm-membership-add&member_identifier=<?php echo $data['identifier'];?>">Add Membership Plan</a></li>
        <li class="active"><a href="?page=csm-edit-member&member_identifier=<?php echo $data['identifier'];?>">Profile of <?php echo $data['first_name'];?></a></li>
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