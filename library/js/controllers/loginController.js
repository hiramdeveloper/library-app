(function(){
  angular.module('libraryApp').controller("LoginController", ['$scope', '$http', '$rootScope', '$location', '$localStorage',function($scope, $http, $rootScope, $location, $localStorage){
    
    $scope.fnLogin = function(){
      if ($scope.username==undefined) {
        alert('The username field cant empty');
        return false;
      }
      if ($scope.password==undefined) {
        alert('The password field cant empty');
        return false;
      }

      $http({
          method: 'POST',
          url: $rootScope.apiURL+'login',
          data: $.param({
              user:$scope.username,
              pass:$scope.password
          }),
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).success(function (response) {
          
            console.log(response);
            if(response.result === 'LOGIN_SUCCESS'){
              $localStorage.token = response.token;
              $localStorage.userData = response.data;
              $localStorage.nameUser = response.data.name;
              $location.url('dashboard/home');
            } else {
              $localStorage.token = null;
              alert('Username/Password are incorrect');
            }
          
      })
      .error(function(data){
          alert('Error, cant to conect to with app!');
      });
    };
    

  }]);
}());
