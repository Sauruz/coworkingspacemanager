<div class="wrap">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel">
                <div class="panel-heading">
                    <h1>Add member</h1>
                </div>
                <div class="panel-body">
                    <form action="" method="post">
                        <input name="action" type="hidden" value="addmember">
                        <?php include(CSM_PLUGIN_PATH . 'views/backend/member-add-edit-table.view.php'); ?>
                        <p class="submit">
                            <input type="submit" name="createuser" id="createusersub" class="btn btn-primary btn-block" value="Add New Member">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>