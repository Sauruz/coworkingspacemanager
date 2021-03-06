<div class="wrap" ng-app="App" ng-controller="Ctrl as Ctrl">
    <h1 class="wp-heading-inline"><strong><?php echo __('New Membership', 'csm');?>:</strong> <?php echo show_a_name($data); ?></h1>
    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/member.tabbar.php'; ?>

        <?php
        if (empty($plans)) {
            csm_error('To give ' . $data->first_name . ' a new membership you need to configure at least one plan. There are no plans configurated yet. <a href="?page=csm-plan-add">Click here</a> to add a plan.');
        } else {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-body">

                            <member-membership-add ajax-base-url="<?php echo admin_url();?>">
                                <form action="" method="post">
                                    <input name="action" type="hidden" value="member-membership-add">
                                    <input name="vat" type="hidden" value="0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="plan_id"><?php echo __('Membership plan', 'csm');?> <span class="description">(required)</span></label><br>
                                            <select class="form-control" id="plan_id" name="plan_id"
                                                    ng-options="plan.workplace_name + ' &bull; ' + plan.plan_name for plan in vm.plans track by plan.plan_id"
                                                    ng-model="vm.selectedPlan">
                                            </select><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="plan_start"><?php echo __('Start date', 'csm');?> <span class="description">(required)</span></label><br>
                                            <input name="plan_start" class="form-control" type="text" id="plan_start" placeholder="yyyy-mm-dd"><br>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="plan_start"><?php echo __('End date', 'csm');?></label><br>
                                            <div class="form-control-static" ng-bind="vm.endDate | date : 'mediumDate'"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6" ng-init="membershipPaid = 0">
                                            <label for="payment"><?php echo __('Membership paid', 'csm');?></label><br>
                                            <input type="hidden" name="payment" value="{{membershipPaid}}">
                                            <select class="form-control" id="payment" ng-model="membershipPaid">
                                                <option ng-value="0" value="0">No</option>
                                                <option ng-value="1" value="1">Yes</option>
                                            </select><br>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="payment_method"><?php echo __('Payment method', 'csm');?></label><br>
                                            <select class="form-control" id="payment_method" name="payment_method" ng-disabled="membershipPaid === 0 ? true : false">
                                                <option> -- Select a payment method -- </option>     
                                                <option value="bitcoin">Bitcoin</option>        
                                                <option value="cash">Cash</option>       
                                                <option value="creditcard">Creditcard</option>
                                                <option value="debitcard">Debitcard</option>
                                                <option value="paypal">Paypal</option>  
                                            </select><br>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12"><hr></div>
                                        <div class="col-md-6">
                                            <label><?php echo __('Total days', 'csm');?></label><br>
                                            <div class="form-control-static">
                                                <span ng-bind="vm.selectedPlan.days"></span>
                                                <span ng-bind="vm.selectedPlan.days > 1 ? 'days' : 'day'"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label><?php echo __('Total price', 'csm');?></label><br>
                                            <div class="form-control-static" ng-bind="vm.selectedPlan.price | currency : '<?php echo CSM_CURRENCY_SYMBOL; ?>'"></div>
                                        </div>
                                    </div>

                                    <p class="submit">
                                        <input type="submit" name="addmembership" id="createusersub" class="btn btn-success btn-block" value="<?php echo __('Add Membership', 'csm');?>">
                                    </p>
                                </form>
                            </member-membership-add>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>