angular.module('app_web', ['ngRoute','ngResource'])
    .config(['$locationProvider', '$routeProvider', function($locationProvider, $routeProvider) {
       
        $locationProvider.html5Mode(true);
        $routeProvider
            .when('/', {
                templateUrl: 'app_web/src/app/app.component.html',
                controller: 'app_web/src/app/app.component.ts'
            })
            .otherwise({
                redirectTo: '/'
            });
        }])