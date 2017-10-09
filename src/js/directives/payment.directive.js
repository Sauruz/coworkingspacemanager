app.directive('payment', function ($locale, $log, $document, $timeout, $uibModal) {
    return {
        bindToController: {
            paid: '=',
            paymentAt: '@',
            paymentMethod: '@',
            identifier: "@",
            price: "@",
            start: "@",
            end: "@"
        },
        controllerAs: 'vm',
        scope: {},
        controller: function ($scope) {
            var vm = this;

            vm.openModal = function () {
                var modalInstance = $uibModal.open({
                    animation: true,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'paymentModalContent.html',
                    controller: function ($uibModalInstance, membership) {
                        var modal = this;
                        modal.membership = membership;

                        modal.ok = function () {
                            $uibModalInstance.close(modal.membership);
                        };

                        modal.cancel = function () {
                            $uibModalInstance.dismiss('cancel');
                        };
                    },
                    controllerAs: 'Ctrl',
                    windowClass: 'bootstrap-wrapper',
                    appendTo: angular.element($document[0].querySelector('#payment-modal')),
                    resolve: {
                        membership: function () {
                            return {
                                identifier: vm.identifier,
                                price: vm.price,
                                start: vm.start,
                                end: vm.end
                            };
                        }
                    }
                });
                modalInstance.result.then(function () {
                    console.log('init');
                }, function () {
                    $log.info('Modal dismissed at: ' + new Date());
                });

                $timeout(function () {
                    $('#payment_at').datepicker({
                        language: 'en',
                        format: "yyyy-mm-dd",
                        todayHighlight: true,
                        autoclose: true
                    });
                    $('#payment_at').datepicker('setDate', new Date());
                });
            };

            return vm;
        },
        template: '<span ng-if="vm.paid" class="cursor-pointer" ng-click="vm.openModal()"><i class="fa fa-fw fa-lg fa-check-circle text-success" aria-hidden="true"></i> <span ng-bind="vm.paymentAt | date : \'mediumDate\'"></span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:silver" ng-bind="vm.paymentMethod"></span></span>' 
        + '<span ng-if="!vm.paid" class="btn btn-sm btn-default" ng-click="vm.openModal()"><i class="fa fa-fw fa-lg fa-exclamation-triangle text-warning" aria-hidden="true"></i> Register payment</span>'
    };
});