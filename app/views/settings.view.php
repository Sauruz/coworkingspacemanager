<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Settings</strong></h1>

    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/settings.tabbar.php'; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input name="action" type="hidden" value="change-settings">

                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <?php if($data['csm_logo']) { ?>
                                        <img src="<?php echo $data['csm_logo']; ?>" class="coworking-space-logo">
                                    <?php } else { ?>
                                    <div class="form-control-static"><i><br>No logo uploaded yet</i></div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_logo">Logo Coworking Space</label><br>
                                    <input name="csm_logo" placeholder="Logo Coworking Space" type="file" id="csm_logo" value="<?php form_value($data, 'csm_logo'); ?>"><br>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="csm_name">Name Coworking Space <span class="description">(required)</span></label><br>
                                    <input name="csm_name" class="form-control" placeholder="Name Coworking Space" type="text" id="csm_name" value="<?php form_value($data, 'csm_name'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_address">Address <span class="description">(required)</span></label><br>
                                    <input name="csm_address" class="form-control" placeholder="Address"  type="text" id="csm_address" value="<?php form_value($data, 'csm_address'); ?>"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="csm_zipcode">Zipcode</label><br>
                                    <input name="csm_zipcode" class="form-control" placeholder="Zipcode" type="text" id="csm_zipcode" value="<?php form_value($data, 'csm_zipcode'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_locality">City, State/Province <span class="description">(required)</span></label><br>
                                    <input name="csm_locality" class="form-control" placeholder="City, State/Province"  type="text" id="csm_locality" value="<?php form_value($data, 'csm_locality'); ?>"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="csm_country">Country</label><br>
                                    <input name="csm_country" class="form-control" placeholder="Country" type="text" id="csm_country" value="<?php form_value($data, 'csm_country'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_email">Email <span class="description">(required)</span></label><br>
                                    <input name="csm_email" class="form-control" placeholder="Email" type="text" id="csm_email" value="<?php form_value($data, 'csm_email'); ?>"><br>
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-md-6">
                                    <label for="csm_website">Website</label><br>
                                    <input name="csm_website" class="form-control" placeholder="Website" type="text" id="csm_website" value="<?php form_value($data, 'csm_website'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_currency">Currency</label><br>
                                    <select name="csm_currency" id="csm_currency" class="form-control">
                                        <?php
                                        foreach ($currency_symbols as $k => $symbol) {
                                            $selected = ($data['csm_currency'] === $k) ? "selected" : "";
                                            echo '<option value="' . $k . '" ' . $selected . '>' . $k . ' (' . html_entity_decode($symbol) . ')</option>';
                                        }
                                        ?>
                                    </select><br>
                                </div>
                            </div>


                            <p class="submit">
                                <input type="submit" id="createusersub" class="btn btn-success btn-block" value="Update settings">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>