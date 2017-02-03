(function(){
  angular.module('libraryApp').controller("LoginController", ['$scope', '$http', '$rootScope', '$location', '$localStorage',function($scope, $http, $rootScope, $location, $localStorage){
    
    $scope.fnLogin = function(){
      if ($scope.username==undefined) {
        alert('El campo de Usuario no puede ser vacio');
        return false;
      }
      if ($scope.password==undefined) {
        alert('El campo de Usuario no puede ser vacio');
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
              alert('Usuario/Contraseña incorrectos');
            }
          
      })
      .error(function(data){
          alert('Error al intentar hacer Login!');
      });
    };
    

  }]);
}());
