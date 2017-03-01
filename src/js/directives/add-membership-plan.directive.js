app.directive('addMembershipPlan', function ($locale, $timeout) {
    return {
        scope: true,
        controllerAs: 'vm',
        controller: function ($scope) {
            var vm = this;
            vm.plans = MembershipPlans;
            vm.selectedPlan = vm.plans[0];
            vm.startDate = moment().format('YYYY-MM-DD');
            vm.endDate = moment(vm.startDate).add(vm.selectedPlan.days, 'days').format();
            
            vm.vatPercentages = [0, 6, 21];
            vm.vat = vm.vatPercentages[0];
            
            vm.selectedPlan.total_price = vm.selectedPlan.price + ((vm.selectedPlan.price / 100) * vm.vat);

            $('#plan_start').datepicker({
                language: 'en',
                format: "yyyy-mm-dd",
                startDate: vm.startDate,
                todayHighlight: true,
                autoclose: true
            }).on('changeDate', function (e) {
                $timeout(function () {
                    vm.startDate = moment(e.date).format('YYYY-MM-DD');
                    vm.endDate = moment(vm.startDate).add(vm.selectedPlan.days, 'days').format();
                    vm.selectedPlan.total_price = vm.selectedPlan.price + ((vm.selectedPlan.price / 100) * vm.vat);
                });
            });
            $('#plan_start').datepicker('setDate', new Date());
            
            $scope.$watch('vm.selectedPlan.days', function(newValue, oldValue) {
                vm.endDate = moment(vm.startDate).add(vm.selectedPlan.days, 'days').format();
                vm.selectedPlan.total_price = vm.selectedPlan.price + ((vm.selectedPlan.price / 100) * vm.vat);
            });
            
            $scope.$watch('vm.vat', function(newValue, oldValue) {
                vm.selectedPlan.total_price = vm.selectedPlan.price + ((vm.selectedPlan.price / 100) * vm.vat);
            });

            return vm;
        }
    };
});