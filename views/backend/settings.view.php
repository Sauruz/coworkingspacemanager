<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Settings</strong></h1>

    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'views/backend/tabbar/settings.tabbar.php'; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" method="post">
                            <input name="action" type="hidden" value="change-settings">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="currency">Currency</label><br>
                                    <select name="currency" id="currency" class="form-control">
                                        <?php
                                        $current_currency = get_option('csm-currency');
                                        foreach ($currency_symbols as $k => $symbol) {
                                            $selected = ($current_currency === $k) ? "selected" : "";
                                            echo '<option value="' . $k . '" ' . $selected . '>' . $k . ' (' . html_entity_decode($symbol) . ')</option>';
                                        }
                                        ?>
                                    </select><br>
                                </div>
                            </div>


                            <p class="submit">
                                <input type="submit" name="createuser" id="createusersub" class="btn btn-primary btn-block" value="Update settings">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>