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
                         <label><?php echo __('Membership Nr.', 'csm');?></label><br>
                         <span class="default-control" ng-bind="Ctrl.membership.identifier"></span><br><br>
                        </div>
                        <div class="col-md-6">
                         <label><?php echo __('Price', 'csm');?></label><br>
                         <span class="default-control" ng-bind="Ctrl.membership.price | currency : '<?php echo CSM_CURRENCY_SYMBOL;?>'"></span><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                         <label><?php echo __('Membership starts at', 'csm');?></label><br>
                         <span class="default-control" ng-bind="Ctrl.membership.start | date : 'mediumDate'"></span><br><br>
                        </div>
                        <div class="col-md-6">
                         <label><?php echo __('Membership ends at', 'csm');?></label><br>
                         <span class="default-control" ng-bind="Ctrl.membership.end | date : 'mediumDate'"></span><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                         <label><?php echo __('Membership paid at', 'csm');?></label><br>
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
                <button class="btn btn-success" type="submit">Register Payment</button>
                <button class="btn btn-default" type="button" ng-click="Ctrl.cancel()">Cancel</button>
                </div>
                </form>
            </script>

            <script type="text/ng-template" id="invoiceModalContent.html">
                <form action="" id="register-payment" method="POST">
                <input name="action" type="hidden" value="sendinvoice">
                <input name="identifier" type="hidden" ng-value="'{{Ctrl.membership.identifier}}'">
                <input name="invoice_sent" type="hidden" value="1">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <input type="hidden" name="id" value="{{Ctrl.membership.id}}" />
                <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Send invoice to {{Ctrl.membership.firstName}}</h3>
                </div>
                <div class="modal-body" id="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                         <span class="default-control">
                              <?php echo $invoiceTemplate['template']; ?>
                         </span><br><br>
                        </div>
                        <div class="col-md-12">
                            <textarea name="invoice" class="form-control" style="display: none;"><?php echo $invoiceTemplate['template']; ?>  </textarea>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                <button class="btn btn-success" type="submit">Send Invoice</button>
                <button class="btn btn-default" type="button" ng-click="Ctrl.cancel()">Cancel</button>
                </div>
                </form>
            </script>