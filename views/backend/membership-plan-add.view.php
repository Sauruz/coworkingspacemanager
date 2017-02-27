<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>
    
    <div class="bootstrap-wrapper">
    <ul class="nav nav-tabs">
        <li><a href="?page=<?php echo $_REQUEST['page'];?>&action=editmember&identifier=<?php echo $data['identifier'];?>">Profile</a></li>
        <li class="active"><a href="#">Add Membership Plan</a></li>
        <li><a href="?page=<?php echo $_REQUEST['page'];?>&action=membershiphistory&identifier=<?php echo $data['identifier'];?>">Membership History</a></li>
    </ul>
    
    <div class="row">
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-body">
                    <form action="" method="post">
                        <input name="action" type="hidden" value="membershipnew">
                        
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