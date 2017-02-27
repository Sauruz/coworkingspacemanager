app.directive('addMembershipPlan', function ($locale, $timeout) {
    return {
        scope: true,
        controllerAs: 'vm',
        controller: function ($scope) {
            var vm = this;
            vm.plans = MembershipPlans;
            vm.selectedPlan = vm.plans[0];
            vm.startDate = moment().format('YYYY-MM-DD');
            vm.endDate = moment(vm.startDate).add(vm.selectedPlan.days, 'days').format('YYYY-MM-DD');

            $('#plan_start').datepicker({
                language: 'en',
                format: "yyyy-mm-dd",
                startDate: vm.startDate,
                todayHighlight: true,
                autoclose: true,
                container: '.bootstrap-wrapper'
            }).on('changeDate', function (e) {
                $timeout(function () {
                    var startDate = moment(e.date).format('YYYY-MM-DD');
                    vm.endDate = moment(startDate).add(vm.selectedPlan.days, 'days').format('YYYY-MM-DD');
                });
            });
            
            $scope.$watch('vm.selectedPlan.days', function(newValue, oldValue) {
                vm.endDate = moment(vm.startDate).add(vm.selectedPlan.days, 'days').format('YYYY-MM-DD');
            });

            return vm;
        }
    };
});