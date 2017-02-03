(function () {
  var app = angular.module("libraryApp");
  app.controller("BorrowBooksController",['$scope', '$http', '$rootScope','$location','$localStorage','$uibModal','DTOptionsBuilder','DTColumnBuilder','$q','$compile','$resource','$sce',
      function($scope, $http, $rootScope, $location, $localStorage, $uibModal, DTOptionsBuilder, DTColumnBuilder, $q, $compile,$resource,$sce){
        //-----------------------------------------------------------------------------------------//
        //Globals
        $scope.book = {CatCustomerId:null};
        $scope.bookEdit = {Status:null};
        $scope.arrLendBooks = [];
        $scope.gb_RelBorrowCustomerBookId = null;
        $scope.gb_CatBooksId = null;
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

        $scope.openModalLendBook = function(){
            $scope.book = {
                CatCustomerId:null,
            };
            $scope.arrLendBooks = [];
            $scope.action = {create:true, edit:false};
            $uibModalInstance = $uibModal.open({
                scope: $scope,
                templateUrl: 'templates/operations/modals/modal_lendBook_form.html',
                animation: true,
            });
        }

        $scope.openModalEditStatusLendBook = function(RelBorrowCustomerBookId,CatBooksId){
            $scope.gb_RelBorrowCustomerBookId = RelBorrowCustomerBookId;
            $scope.gb_CatBooksId = CatBooksId;
            $uibModalInstance = $uibModal.open({
                scope: $scope,
                templateUrl: 'templates/operations/modals/modal_lendBookEditStatus_form.html',
                animation: true,
            });
        }
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Retrive all books
        $http({
            method: 'GET',
            url: $rootScope.apiURL+'getAllBooksAvailable/'+$localStorage.token,
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
        //Retrive all borrow books
        $http({
            method: 'GET',
            url: $rootScope.apiURL+'getAllBorrowBooks/'+$localStorage.token,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response){
            if(response.Result === 'SUCCESS'){
                $scope.allBorrowBooks = Object.keys(response.data).map(function (key) {return response.data[key]});
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
        //Retrive all customers
        $http({
            method: 'GET',
            url: $rootScope.apiURL+'getAllCustomers/'+$localStorage.token,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response){
            if(response.Result === 'SUCCESS'){
                $scope.allCustomers = Object.keys(response.data).map(function (key) {return response.data[key]});
            }
        })
        .error(function(data){
            alert('Error al intentar obtener los datos del servidor');
        });
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Books for lend
        $scope.ctrlLendBooks = function(Bool,CatBooksId){
            if(Bool == true){
                var index = $scope.arrLendBooks.indexOf(CatBooksId);
                if(index == -1){
                    $scope.arrLendBooks.push(CatBooksId);
                }
            } else {
                for(var i in $scope.arrLendBooks){
                    if($scope.arrLendBooks[i] == CatBooksId){
                        $scope.arrLendBooks.splice(i,1);
                    }
                }
            }
        };
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Books for lend
        $scope.saveLendBook = function(){
            if($scope.arrLendBooks.length == 0){
                alert('Need select a one book!');
                return false;
            }
            if($scope.book.CatCustomerId == undefined||$scope.book.CatCustomerId == null){
                alert('Need select a one customer!');
                return false;
            }
            if(angular.element('#BeginDate').val() == ''||angular.element('#BeginDate').val() == undefined){
                alert('Need select to begin date!');
                return false;
            }
            if(angular.element('#EndDate').val() == ''||angular.element('#EndDate').val() == undefined){
                alert('Need select to end date!');
                return false;
            }

            $http({
                method: 'POST',
                url: $rootScope.apiURL+'createNewBorrowBook',
                data: $.param({
                    token:$localStorage.token,
                    CatCustomerId:$scope.book.CatCustomerId,
                    BeginDate:angular.element('#BeginDate').val(),
                    EndDate:angular.element('#EndDate').val(),
                    arrBooks:$scope.arrLendBooks
            }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (response) {
                $scope.closeModal();
                if(response.Result === 'SUCCESS'){
                    for(var i in response.data){
                        for(var z in response.data[i]){
                            $scope.allBorrowBooks.push(response.data[i][z]);
                        }
                    }
                    for(var h in $scope.allBooks){
                        for(var i in response.data){
                            for(var z in response.data[i]){
                                if(response.data[i][z].CatBooksId == $scope.allBooks[h].CatBooksId){
                                    $scope.allBooks[h].SysStatusLendBookId = 3;
                                    $scope.allBooks[h].Status = 'BORROWED';
                                    break;
                                }
                            }
                        }
                    };
                } else {
                    alert('Error, When try insert a new Book');
                }
            })
            .error(function(data){
                alert('Something has wrong, try again!');
            });
        }
        //-----------------------------------------------------------------------------------------//

        //-----------------------------------------------------------------------------------------//
        //Books for lend
        $scope.updateStatusBorrowBook = function(){
            $http({
                method: 'POST',
                url: $rootScope.apiURL+'updateStatusBorrowBook',
                data: $.param({
                    token:$localStorage.token,
                    RelBorrowCustomerBookId:$scope.gb_RelBorrowCustomerBookId,
                    CatBooksId:$scope.gb_CatBooksId,
                    Status:$scope.bookEdit.Status
            }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (response) {
                $scope.closeModal();
                if(response.Result === 'SUCCESS'){
                    console.log(response);
                    for(var i in $scope.allBorrowBooks){
                        if($scope.allBorrowBooks[i].RelBorrowCustomerBookId == response.data.row){
                            $scope.allBorrowBooks[i].SysStatusId = response.data.result[0].SysStatusId;
                            $scope.allBorrowBooks[i].Status = response.data.result[0].Status;
                        }
                    }
                    for(var i in $scope.allBooks){
                        if($scope.allBooks[i].CatBooksId == response.data.result[0].CatBooksId){
                            $scope.allBooks[i].Status = response.data.result[0].Status;
                        }
                    }
                } else {
                    alert('Error, When try insert a new Book');
                }
            })
            .error(function(data){
                alert('Something has wrong, try again!');
            });
        };
        //-----------------------------------------------------------------------------------------//

  }]);
})();

