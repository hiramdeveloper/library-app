//run.$inject = ['$rootScope'];

var app = angular.module('libraryApp',['ui.router','ui.bootstrap','ngStorage','ngAnimate','datatables','ngSanitize','ngResource','datatables.buttons','localytics.directives','ui.date']);

app.config(function($stateProvider, $urlRouterProvider){
  
  $urlRouterProvider.otherwise("/");

  $stateProvider
    .state('login', {
      url: "/",
      templateUrl: "templates/login/login.html"
    })

    .state('dashboard', {
   		abstract: true,
      	url: "/dashboard",
      	templateUrl: "templates/common/content.html"
    })
    .state('dashboard.home', {
        url: "/home",
        templateUrl: "templates/dashboard/index.html"
    })

    .state('catalogs', {
        abstract: true,
        url: "/catalogs",
        templateUrl: "templates/common/content.html"
    })
    .state('catalogs.books', {
      url: "/books",
      templateUrl: "templates/catalogos/books.html",
    })

    .state('operations', {
      abstract: true,
        url: "/operations",
        templateUrl: "templates/common/content.html"
    })
    .state('operations.borrow_books', {
      url: "/borrow_books",
      templateUrl: "templates/operations/borrow_books.html",
    });

});

app.run(function($rootScope,DTDefaultOptions,DTOptionsBuilder,$localStorage,$window,$location,$http,$timeout){
	$rootScope.apiURL = 'http://localhost/library/api-library/public/';

  $rootScope.dataTableOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers').withDOM('frtip')
    .withOption('responsive', true).withDisplayLength(10)
    .withButtons([
        'copy',
        'print',
        'excel'
    ]);

  $rootScope.logout = function(){
    $http({
          method: 'GET',
          url: $rootScope.apiURL+'logout/'+$localStorage.token,
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).success(function(response){
          if(response.Result === 'SUCCESS'){
            console.log(response.Result);
            $localStorage.$reset();
            $location.path('/');
          }
      })
      .error(function(data){
          alert('Error al intentar salir del sistema');
      });
  }

  $rootScope.imgLogo = imgBase64.imgLogo;
  $rootScope.nameUser = $localStorage.nameUser;

  $rootScope.dateOptions = {
    changeYear: true,
    changeMonth: true,
    yearRange: '1900:-0',
    format:'yyyy-mm-dd'   
  };

});

/*app.directive('datepicker', function() {
   return function(scope, element, attrs) {
       element.datepicker({
           inline: true,
           dateFormat: 'yyyy-mm-dd',
           onSelect: function(dateText) {
               var modelPath = $(this).attr('ng-model');
               putObject(modelPath, scope, dateText);
               scope.$apply();
           }
       });
   }
});*/

app.directive('loading',   ['$http' ,function ($http)
    {
        return {
            restrict: 'A',
            link: function (scope, elm, attrs)
            {
                scope.isLoading = function () {
                    return $http.pendingRequests.length > 0;
                };

                scope.$watch(scope.isLoading, function (v)
                {
                    if(v){
                        elm.show();
                    }else{
                        elm.hide();
                    }
                });
            }
        };
    }]);
