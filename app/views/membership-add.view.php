<div class="wrap" ng-app="App" ng-controller="Ctrl as Ctrl">
    <h1 class="wp-heading-inline"><strong>New Membership</strong></h1>
    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/memberships.tabbar.php'; ?>

        <?php
        if (empty($plans)) {
            csm_error('To give ' . $data['first_name'] .' a new membership you need to configure at least one plan. There are no plans configurated yet. <a href="?page=csm-plan-add">Click here</a> to add a plan.');
        } else {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="" method="post" membership-add>
                                <input name="action" type="hidden" value="membership-add">
                                <input name="vat" type="hidden" value="0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="user_id">Member <span class="description">(required)</span></label><br>
                                        <select class="form-control" id="user_id" name="user_id" ng-model="vm.selectedMember">
                                            <option value=""> -- Select a member -- </option>
                                            <option ng-repeat="member in vm.members" value="{{member.ID}}">{{member.display_name}}</option>
                                        </select><br>
                                    </div>
                                    <div class="col-md-6">
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
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>