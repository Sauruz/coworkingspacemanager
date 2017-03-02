<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Add Plan</strong></h1>

    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'views/backend/tabbar/plans.tabbar.php'; ?>
        
        <?php
        if (empty($workplaces)) {
            csm_error('To add a plan you need at least one workplace. There are no workplaces configurated yet. <a href="?page=csm-workplace-add">Click here</a> to add a workplace.');
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
                                    <label for="name">Name of the plan <span class="description">(required)</span></label><br>
                                    <input name="name" class="form-control" placeholder="eg. Week, Month, Year" type="text" id="name" value="<?php form_value($data, 'name'); ?>"><br>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="workplace_id">Workplace <span class="description">(required)</span></label><br>
                                    <span class="note">You can add workplaces <a href="?page=csm-workplace-add">here</a></span>
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
                                    <label for="days">Length plan <span class="description">(required)</span></label><br>
                                    <input name="days" class="form-control" placeholder="Days" type="number" min="1" id="days" value="<?php form_value($data, 'days'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="price">Total price <span class="description">(required)</span></label><br>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><?php echo CSM_CURRENCY_SYMBOL;?></span>
                                        <input name="price" id="price" type="number" class="form-control" placeholder="Total price in <?php echo CSM_CURRENCY;?>" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>


                            <p class="submit">
                                <input type="submit"class="btn btn-primary btn-block" value="Add Membership plan">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>