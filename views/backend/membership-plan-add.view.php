<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>

    <div class="bootstrap-wrapper">
        <ul class="nav nav-tabs">
            <li><a href="?page=<?php echo $_REQUEST['page']; ?>&action=editmember&identifier=<?php echo $data['identifier']; ?>">Profile</a></li>
            <li class="active"><a href="#">Add Membership Plan</a></li>
            <li><a href="?page=<?php echo $_REQUEST['page']; ?>&action=membershiphistory&identifier=<?php echo $data['identifier']; ?>">Membership History</a></li>
        </ul>

        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" method="post">
                            <input name="action" type="hidden" value="add-membership-plan">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="plan_id">Membership plan <span class="description">(required)</span></label><br>
                                    <select class="form-control" id="plan_id" name="plan_id">
                                        <?php foreach($plans as $plan) {
                                          echo '<option value="' . $plan['plan_id']  . '">' . $plan['workplace_name']  . ' &bull; ' . $plan['plan_name'] . '</option>';
                                        }
                                        ?>
                                    </select><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="plan_start">Start date <span class="description">(required)</span></label><br>
                                    <input name="plan_start" class="form-control" type="text" id="plan_start" value="<?php form_value($data, 'plan_start'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="plan_start">End date</label><br>
                                    <div class="form-control-static">2017-02-30</div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <label for="price">Price <span class="description">(required)</span></label><br>
                                    <input name="price" class="form-control" type="text" id="price" value="<?php form_value($data, 'price'); ?>"><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="vat">VAT </label><br>
                                    <input name="vat" class="form-control" type="text" id="vat" value="<?php form_value($data, 'vat'); ?>"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label >Total days</label><br>
                                    <div class="form-control-static">1</div>
                                </div>
                                <div class="col-md-6">
                                    <label>Total price</label><br>
                                    <div class="form-control-static">1</div>
                                </div>
                            </div>

                            <p class="submit">
                                <input type="submit" name="createuser" id="createusersub" class="btn btn-primary btn-block" value="Add Membership Plan">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>