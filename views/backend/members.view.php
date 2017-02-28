<div class="wrap">
    <h1 class="wp-heading-inline">Members</h1>
    <div class="bootstrap-wrapper">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#"><i class="fa fa-fw fa-users" aria-hidden="true"></i> All Members</a></li>
            <li><a href="?page=csm-add-member"><i class="fa fa-plus" aria-hidden="true"></i> Add Member</a></li>
        </ul>

        <form id="members-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $membersTable->display(); ?>
        </form>
    </div>
</div>