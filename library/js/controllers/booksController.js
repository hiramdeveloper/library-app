(function () {
  var app = angular.module("libraryApp");
  app.controller("BooksController",['$scope', '$http', '$rootScope','$location','$localStorage','$uibModal','DTOptionsBuilder','DTColumnBuilder','$q','$compile','$resource','$sce',
      function($scope, $http, $rootScope, $location, $localStorage, $uibModal, DTOptionsBuilder, DTColumnBuilder, $q, $compile,$resource,$sce){
        //-----------------------------------------------------------------------------------------//
        //Globals
        $scope.book = {
            Name:null,
            Author:null,
            CatCategoryId:null,
            PublishDate:null
        };
        $scope.gb_CategoriaId = null;
        $scope.gb_PublishDate = '';
        $rootScope.nameUser;
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Modals
        $scope.closeModal = function(){
            $uibModalInstance.close();
        };

        $scope.openModalAlert = function(){
            $uibModalInstance = $uibModal.open({
                scope: $scope,
                templateUrl: 'templates/common/modals/modal_alert_form.html',
                animation: true,
            });
        };

        $scope.openModalBook = function(){
            $scope.book = {
                Name:null,
                Author:null,
                CatCategoryId:null,
                PublishDate:null
            };
            $scope.gb_PublishDate = '';

            $scope.action = {create:true, edit:false};
            $uibModalInstance = $uibModal.open({
                scope: $scope,
                templateUrl: 'templates/catalogos/modals/modal_book_form.html',
                animation: true,
            });
        };

        $scope.openModalEditBook = function(id){
            $scope.gb_BookId = id;
            for(var i in $scope.allBooks){
                if($scope.allBooks[i].CatBooksId == id){
                    $scope.book = $scope.allBooks[i];
                    $scope.gb_PublishDate = $scope.allBooks[i].PublishDate;
                    break;
                }
            };

            $scope.action = {create:false, edit:true};
            $uibModalInstance = $uibModal.open({
                scope: $scope,
                templateUrl: 'templates/catalogos/modals/modal_book_form.html',
                animation: true,
            });
        };
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Retrive all books
        $http({
            method: 'GET',
            url: $rootScope.apiURL+'getAllBooks/'+$localStorage.token,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response){
            if(response.Result === 'SUCCESS'){
                $scope.allBooks = Object.keys(response.data).map(function (key) {return response.data[key]});
            }
        })
        .error(function(data){
            alert('Error al intentar obtener los datos del servidor');
        });
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Retrive all categories
        $http({
            method: 'GET',
            url: $rootScope.apiURL+'getAllCategories/'+$localStorage.token,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response){
            if(response.Result === 'SUCCESS'){
                $scope.allCategories = Object.keys(response.data).map(function (key) {return response.data[key]});
            }
        })
        .error(function(data){
            alert('Error al intentar obtener los datos del servidor');
        });
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Save new book
        $scope.saveBook = function(){
            $http({
                method: 'POST',
                url: $rootScope.apiURL+'createBook',
                data: $.param({
                    token:$localStorage.token,
                    Name:$scope.book.Name,
                    Author:$scope.book.Author,
                    CatCategoryId:$scope.book.CatCategoryId,
                    PublishDate:angular.element('#PublishDate').val()
            }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (response) {
                $scope.closeModal();
                if(response.Result === 'SUCCESS'){
                    $scope.gb_Title = 'SUCCESS';
                    $scope.gb_Alert = 'Book added successfully';
                    $scope.openModalAlert();
                    $scope.allBooks.push(response.data[0]);
                } else {
                    alert('Error, When try insert a new Book');
                }
            })
            .error(function(data){
                alert('Something has wrong, try again!');
            });
        };
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Update book
        $scope.updateBook = function(){
            $http({
                method: 'POST',
                url: $rootScope.apiURL+'updateBook',
                data: $.param({
                    token:$localStorage.token,
                    id:$scope.gb_BookId,
                    Name:$scope.book.Name,
                    Author:$scope.book.Author,
                    CatCategoryId:$scope.book.CatCategoryId,
                    PublishDate:angular.element('#PublishDate').val()
            }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (response) {
                $scope.closeModal(); 
                if(response.Result === 'SUCCESS'){

                    for(var i in $scope.allBooks){
                        if($scope.allBooks[i].CatBooksId == $scope.gb_BookId){
                            $scope.allBooks[i].PublishDate = response.data[0].PublishDate;
                            $scope.gb_PublishDate = response.data[0].PublishDate;
                            break;
                        }
                    };

                    $scope.gb_Title = 'SUCCESS';
                    $scope.gb_Alert = 'Book updated successfully';
                    $scope.openModalAlert();
                } else {
                    alert('Error, When try update a Book');
                }
            })
            .error(function(data){
                alert('Something has wrong, try again!');
            });
        };
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Update status book
        $scope.changeStatus = function(CatBooksId,SysStatusId){
            var newStatus;
            if(SysStatusId==1){
                newStatus = 6;
            } else if(SysStatusId==6){
                newStatus = 1;
            }

            $http({
                method: 'POST',
                url: $rootScope.apiURL+'updateStatusBook',
                data: $.param({
                    token:$localStorage.token,
                    id:CatBooksId,
                    Status:newStatus
            }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (response) {
                if(response.Result === 'SUCCESS'){

                    for(var i in $scope.allBooks){
                        if($scope.allBooks[i].CatBooksId == CatBooksId){
                            $scope.allBooks[i].SysStatusId = newStatus;
                            $scope.allBooks[i].Status = response.data[0].Status;
                            break;
                        }
                    };

                    $scope.gb_Title = 'SUCCESS';
                    $scope.gb_Alert = 'Book updated successfully';
                    $scope.openModalAlert();
                } else {
                    alert('Error, When try update a Book');
                }
            })
            .error(function(data){
                alert('Something has wrong, try again!');
            });
        };
        //-----------------------------------------------------------------------------------------//

  }]);
})();

