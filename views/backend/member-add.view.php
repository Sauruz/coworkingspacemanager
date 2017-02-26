<div class="wrap">
    <h1 class="wp-heading-inline">Add member</h1>
    
    <form action="" method="post">
         <input name="action" type="hidden" value="addmember">
        <?php include(CSM_PLUGIN_PATH . 'views/backend/member-add-edit-table.view.php'); ?>
        <p class="submit">
            <input type="submit" name="createuser" id="createusersub" class="button button-primary" value="Add New Member">
        </p>
    </form>
</div>