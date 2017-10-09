app.directive('invoice', function ($locale, $log, $document, $timeout, $uibModal, $filter) {
    return {
        bindToController: {
            invoiceSent: '=',
            invoiceSentAt: '@',
            paymentAt: '@',
            paymentMethod: '@',
            identifier: "@",
            price: "@",
            currencySymbol: "@",
            start: "@",
            end: "@",
            id: "@", 
            firstName: "@",
            lastName: "@",
            workplaceName: "@",
            planName: "@",
            days: "@",
            company: "@",
            address: "@",
            locality: "@",
            country: "@",
            csmName: "@",
            csmAddress: "@",
            csmZipcode: "@",
            csmLocality: "@",
            csmCountry: "@",
            csmEmail: "@",
            csmWebsite: "@"
        },
        controllerAs: 'vm',
        scope: {},
        controller: function ($scope) {
            var vm = this;
            console.log(vm);

            vm.openModal = function () {
                var modalInstance = $uibModal.open({
                    animation: true,
                    ariaLabelledBy: 'modal-title',
                    ariaDescribedBy: 'modal-body',
                    templateUrl: 'invoiceModalContent.html',
                    controller: function ($uibModalInstance, membership) {
                        var modal = this;
                        modal.membership = membership;
                        modal.membership.currentDate = $filter('date')(moment().format('YYYY-MM-DD'), 'mediumDate');
                        modal.membership.start = $filter('date')(modal.membership.start, 'mediumDate');
                        modal.membership.end = $filter('date')(modal.membership.end, 'mediumDate');
                        modal.membership.priceFormatted = $filter('currency')(modal.membership.price, modal.membership.currencySymbol);
                        
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
                            return vm;
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
        template: '<span ng-if="vm.invoiceSent"><i class="fa fa-fw fa-lg fa-check-circle text-success" aria-hidden="true"></i> <span ng-bind="vm.invoiceSentAt | date : \'mediumDate\'"></span></span>'
                + '<span ng-if="!vm.invoiceSent" class="btn btn-sm btn-default" ng-click="vm.openModal()"><i class="fa fa-fw fa-lg fa-exclamation-triangle text-warning" aria-hidden="true"></i> Send invoice</span>'
    };
});