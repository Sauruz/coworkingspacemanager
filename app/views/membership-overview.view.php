<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Membership Overview:</strong> <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></h1>

    <div class="bootstrap-wrapper">

        <?php include CSM_PLUGIN_PATH . 'app/views/tabbar/member.tabbar.php'; ?>

        <div ng-app="App" ng-controller="ModalPaymentCtrl as Ctrl" class="modal-demo">
            <script type="text/ng-template" id="paymentModalContent.html">
                <form action="" id="register-payment" method="POST">
                <input name="action" type="hidden" value="addpayment">
                <input name="identifier" type="hidden" ng-value="'{{Ctrl.membership.identifier}}'">
                <input name="payment" type="hidden" value="1">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <input type="hidden" name="member_identifier" value="<?php echo $_REQUEST['member_identifier'] ?>" />
                <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Register Payment</h3>
                </div>
                <div class="modal-body" id="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                         <label>Membership Nr.</label><br>
                         <span class="default-control" ng-bind="Ctrl.membership.identifier"></span><br><br>
                        </div>
                        <div class="col-md-6">
                         <label>Price</label><br>
                         <span class="default-control" ng-bind="Ctrl.membership.price | currency : '<?php echo CSM_CURRENCY_SYMBOL;?>'"></span><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                         <label>Membership starts at</label><br>
                         <span class="default-control" ng-bind="Ctrl.membership.start | date : 'mediumDate'"></span><br><br>
                        </div>
                        <div class="col-md-6">
                         <label>Membership ends at</label><br>
                         <span class="default-control" ng-bind="Ctrl.membership.end | date : 'mediumDate'"></span><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                         <label>Membership paid at</label><br>
                         <input id="payment_at" name="payment_at" type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                         <label>Payment method</label><br>
                         <select name="payment_method" class="form-control">
                             <option value="bitcoin">Bitcoin</option>        
                             <option value="cash">Cash</option>       
                             <option value="creditcard">Creditcard</option>
                             <option value="debitcard">Debitcard</option>
                             <option value="paypal">Paypal</option>  
                         </select>            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Register Payment</button>
                <button class="btn btn-default" type="button" ng-click="Ctrl.cancel()">Cancel</button>
                </div>
                </form>
            </script>

            
        <form id="memberships-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <input type="hidden" name="member_identifier" value="<?php echo $_REQUEST['member_identifier'] ?>" />
            <span ng-app="App">
                <?php $MembershipTable->display(); ?>
            </span>
        </form>
            
            <div id="payment-modal"></div>
            
              </div>

    </div>
</div>