app.factory('Services', function ($http, $timeout) {
    var factory = {};

    factory.membershipplans = function () {
        return $http.get('admin-ajax.php?action=csmmembershipplans').then(function (result) {
            return result.data;
        });
    };
    
    factory.members = function () {
        return $http.get('admin-ajax.php?action=csmmembers').then(function (result) {
            return result.data;
        });
    };

    return factory;
});