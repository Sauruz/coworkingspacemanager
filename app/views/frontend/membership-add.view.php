<?php include('layout/header.view.php'); ?>
<?php include('layout/navbar.view.php'); ?>

<div class="container">
    <div class="row">
        <div class="panel col-md-12">
            <div class="panel-body">

                <?php include('tabbar/memberships.tabbar.php'); ?>

                <?php if (!empty($update)) { ?>
                    <div class="alert alert-success"><?php echo $update; ?></div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-6">
                        <member-membership-add ajax-base-url="<?php echo admin_url(); ?>">
                            <form action="" method="post">
                                <input name="action" type="hidden" value="member-membership-add">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="plan_id">Membership plan <span class="description">(required)</span></label><br>
                                        <select class="form-control" id="plan_id" name="plan_id"
                                                ng-options="plan.workplace_name + ' &bull; ' + plan.plan_name for plan in vm.plans track by plan.plan_id"
                                                ng-model="vm.selectedPlan">
                                        </select><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="plan_start">Start date <span class="description">(required)</span></label><br>
                                        <input name="plan_start" class="form-control" type="text" id="plan_start" placeholder="yyyy-mm-dd"><br>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="plan_start">End date</label><br>
                                        <div class="form-control-static" ng-bind="vm.endDate | date : 'mediumDate'"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12"><hr></div>
                                    <div class="col-md-6">
                                        <label>Total days</label><br>
                                        <div class="form-control-static">
                                            <span ng-bind="vm.selectedPlan.days"></span>
                                            <span ng-bind="vm.selectedPlan.days > 1 ? 'days' : 'day'"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Total price</label><br>
                                        <div class="form-control-static" ng-bind="vm.selectedPlan.price | currency : '<?php echo CSM_CURRENCY_SYMBOL; ?>'"></div>
                                    </div>
                                </div>

                                <p class="submit">
                                    <input type="submit" name="addmembership" id="createusersub" class="btn btn-success btn-block" value="Add Membership">
                                </p>
                            </form>
                        </member-membership-add>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.view.php'); ?>
                