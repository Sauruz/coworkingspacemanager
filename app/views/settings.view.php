<div class="wrap">
    <h1 class="wp-heading-inline"><strong><?php echo __('Settings', 'csm');?></strong></h1>

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
                                    <div class="form-control-static"><i><br><?php echo __('No logo uploaded yet', 'csm');?></i></div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_logo"><?php echo __('Logo Coworking Space', 'csm');?></label><br>
                                    <input name="csm_logo" placeholder="<?php echo __('Logo Coworking Space', 'csm');?>" type="file" id="csm_logo" value="<?php form_value($data, 'csm_logo'); ?>"><br>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="csm_name"><?php echo __('Name Coworking Space', 'csm');?> <span class="description">(required)</span></label><br>
                                    <input name="csm_name" class="form-control" placeholder="<?php echo __('Name Coworking Space', 'csm');?>" type="text" id="csm_name" value="<?php form_value($data, 'csm_name'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_address"><?php echo __('Address', 'csm');?> <span class="description">(required)</span></label><br>
                                    <input name="csm_address" class="form-control" placeholder="<?php echo __('Address', 'csm');?>"  type="text" id="csm_address" value="<?php form_value($data, 'csm_address'); ?>"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="csm_zipcode"><?php echo __('Zipcode', 'csm');?></label><br>
                                    <input name="csm_zipcode" class="form-control" placeholder="<?php echo __('Zipcode', 'csm');?>" type="text" id="csm_zipcode" value="<?php form_value($data, 'csm_zipcode'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_locality"><?php echo __('City, State/Province', 'csm');?> <span class="description">(required)</span></label><br>
                                    <input name="csm_locality" class="form-control" placeholder="<?php echo __('City, State/Province', 'csm');?>"  type="text" id="csm_locality" value="<?php form_value($data, 'csm_locality'); ?>"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="csm_country"><?php echo __('Country', 'csm');?></label><br>
                                    <input name="csm_country" class="form-control" placeholder="<?php echo __('Country', 'csm');?>" type="text" id="csm_country" value="<?php form_value($data, 'csm_country'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_email"><?php echo __('Email', 'csm');?> <span class="description">(required)</span></label><br>
                                    <input name="csm_email" class="form-control" placeholder="<?php echo __('Email', 'csm');?>" type="text" id="csm_email" value="<?php form_value($data, 'csm_email'); ?>"><br>
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-md-6">
                                    <label for="csm_website"><?php echo __('Website', 'csm');?></label><br>
                                    <input name="csm_website" class="form-control" placeholder="<?php echo __('Website', 'csm');?>" type="text" id="csm_website" value="<?php form_value($data, 'csm_website'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="csm_currency"><?php echo __('Currency', 'csm');?></label><br>
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

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="csm_frontend_membership"><?php echo __('Users can add their own membership in the members area', 'csm');?></label><br>
                                    <select name="csm_frontend_membership" id="csm_frontend_membership" class="form-control">
                                        <option value="true" <?php echo $data['csm_frontend_membership'] ? "selected" : ""; ?>><?php echo __('Yes', 'csm');?></option>
                                        <option value="false" <?php echo !$data['csm_frontend_membership'] ? "selected" : ""; ?>><?php echo __('No', 'csm');?></option>
                                    </select><br>
                                </div>
                            </div>

                            <p class="submit">
                                <input type="submit" id="createusersub" class="btn btn-success btn-block" value="<?php echo __('Update settings', 'csm');?>">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>