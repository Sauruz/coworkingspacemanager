<div class="wrap">
    <h1 class="wp-heading-inline">Members</h1>
    <a href="?page=csm-add-member" class="page-title-action">Add Member</a>

    <form id="members-filter" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php $membersTable->display(); ?>
    </form>
</div>