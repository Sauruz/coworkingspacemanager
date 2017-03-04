<div class="wrap" ng-app="App" ng-controller="Ctrl as Ctrl">
    <h1 class="wp-heading-inline"><strong>New Membership:</strong> <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>
    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/member.tabbar.php'; ?>

        <?php
        if (empty($plans)) {
            csm_error('To give ' . $data['first_name'] .' a new membership you need to configure at least one plan. There are no plans configurated yet. <a href="?page=csm-plan-add">Click here</a> to add a plan.');
        } else {
            ?>
            <script>
                    MembershipPlans = [
                        <?php foreach ($plans as $plan) { ?>
                                            {
                                            plan_id : <?php echo $plan['plan_id']; ?>,
                                                    plan_name : '<?php echo $plan['plan_name']; ?>',
                                                    workplace_name : '<?php echo $plan['workplace_name']; ?>',
                                                    price : <?php echo $plan['price']; ?>,
                                                    days : <?php echo $plan['days']; ?>,
                                            },
                        <?php } ?>
                    ];
            </script>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="" method="post" add-membership-plan>
                                <input name="action" type="hidden" value="add-membership-plan">
                                <input name="vat" type="hidden" value="0">
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
                                    <input type="submit" name="addmembership" id="createusersub" class="btn btn-primary btn-block" value="Add Membership">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>