<div class="wrap">
    <h1 class="wp-heading-inline">Edit member <?php echo $data['first_name'] . ' ' .  $data['last_name']; ?></h1>
    
    <form action="" method="post">
         <input name="action" type="hidden" value="editmember">
        <?php include(CSM_PLUGIN_PATH . 'views/backend/member-add-edit-table.view.php'); ?>
        <p class="submit">
            <input type="submit" name="createuser" id="createusersub" class="button button-primary" value="Edit Member">
        </p>
    </form>
</div>