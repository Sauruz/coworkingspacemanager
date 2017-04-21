app.factory('Services', function ($http, $timeout) {
    var factory = {};

    factory.membershipplans = function (base) {
        return $http.get(base + 'admin-ajax.php?action=csmmembershipplans').then(function (result) {
            return result.data;
        });
    };
    
    factory.members = function () {
        return $http.get('admin-ajax.php?action=csmmembers').then(function (result) {
            
            result.data.forEach(function(v) {
                if (v.first_name && v.last_name) {
                    v.display_name = v.last_name + ', ' + v.first_name;
                }
                else if (v.last_name) {
                    v.display_name = v.last_name;
                }
            });
            
            return result.data;
        });
    };

    return factory;
});