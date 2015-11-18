'use strict';

angular.module('mongodemo', ['ngRoute'])
  .config(['$routeProvider', function (routeProvider) {
    routeProvider
      .when('/', {
        templateUrl: 'partials/main.html',
        controller: 'MainCtrl'
      })
       .when('/analysis', {
        templateUrl: 'partials/analysis.html',
        controller: 'MainCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  }]);
