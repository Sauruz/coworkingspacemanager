<div class="wrap">
    <h1 class="wp-heading-inline"><strong><?php echo __('Add plan', 'csm');?></strong></h1>

    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/plans.tabbar.php'; ?>
        
        <?php
        if (empty($workplaces)) {
            csm_error(__('To add a plan you need at least one workplace. There are no workplaces configurated yet. <a href="?page=csm-workplace-add">Click here</a> to add a workplace.'));
        } else {
            ?>

        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" method="post">
                            <input name="action" type="hidden" value="addplan">
                                
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name"><?php echo __('Name of the plan', 'csm');?> <span class="description">(required)</span></label><br>
                                    <input name="name" class="form-control" placeholder="<?php echo __('eg. Week, Month, Year', 'csm');?>" type="text" id="name" value="<?php form_value($data, 'name'); ?>"><br>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="workplace_id"><?php echo __('Workplace', 'csm');?> <span class="description">(required)</span></label><br>
                                    <span class="note"><?php echo __('You can add workplaces <a href="?page=csm-workplace-add">here</a>', 'csm');?> </span>
                                    <select name="workplace_id" id="workplace_id" class="form-control">
                                        <?php
                                        foreach ($workplaces as $k => $v) {
                                            echo '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
                                        }
                                        ?>
                                    </select><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="days"><?php echo __('Length plan', 'csm');?> <span class="description">(required)</span></label><br>
                                    <input name="days" class="form-control" placeholder="<?php echo __('Days', 'csm');?>" type="number" min="1" id="days" value="<?php form_value($data, 'days'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="price"><?php echo __('Total price', 'csm');?> <span class="description">(required)</span></label><br>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><?php echo CSM_CURRENCY_SYMBOL;?></span>
                                        <input name="price" id="price" type="number" class="form-control" placeholder="<?php echo __('Total price in', 'csm');?> <?php echo CSM_CURRENCY;?>" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>


                            <p class="submit">
                                <input type="submit"class="btn btn-success btn-block" value="<?php echo __('Add Membership plan', 'csm');?>">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>