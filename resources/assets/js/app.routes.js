angular.module('routing', ['ngRoute'])
.config(['$routeProvider', '$locationProvider',
  function($routeProvider, $locationProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/home.html',
        controller: 'homeController',
        controllerAs: 'home'
      })
    $locationProvider.html5Mode(true);
}])