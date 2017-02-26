<div class="wrap">
    <h1 class="wp-heading-inline">Members</h1>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">Members</a></li>
        <li><a href="?page=csm-add-member">Add Member</a></li>
    </ul>

    <form id="members-filter" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php $membersTable->display(); ?>
    </form>
</div>