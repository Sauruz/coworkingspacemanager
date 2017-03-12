app.controller('invoiceModalContent.html', function ($uibModal, $log, $document, $timeout) {
    var Ctrl = this;
    Ctrl.items = ['item1', 'item2', 'item3'];

    Ctrl.animationsEnabled = true;

    Ctrl.open = function (identifier, price, start, end) {

        Ctrl.membership = {
            identifier: identifier,
            price: price,
            start: start,
            end: end
        };


        var modalInstance = $uibModal.open({
            animation: Ctrl.animationsEnabled,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'invoiceModalContent.html',
            controller: 'InvoiceInstanceCtrl',
            controllerAs: 'Ctrl',
            windowClass: 'bootstrap-wrapper',
            appendTo: angular.element($document[0].querySelector('#payment-modal')),
            resolve: {
                membership: function () {
                    return Ctrl.membership;
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

});

// Please note that $uibModalInstance represents a modal window (instance) dependency.
// It is not the same as the $uibModal service used above.

app.controller('InvoiceInstanceCtrl', function ($uibModalInstance, membership) {
    var Ctrl = this;
    Ctrl.membership = membership;

    Ctrl.ok = function () {
        $uibModalInstance.close(Ctrl.membership);
    };

    Ctrl.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});
