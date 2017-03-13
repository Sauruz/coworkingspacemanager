app.factory('Services', function ($http, $timeout) {
    var factory = {};

    factory.membershipplans = function () {
        return $http.get('admin-ajax.php?action=membershipplans').then(function (result) {
            return result.data;
        });
    };

    return factory;
});