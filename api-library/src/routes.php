<?php
// Routes

$app->options('/(:name+)', function () use ($app) {});

/*-------API -> login-------*/
$app->post('/login',function ($request, $response){
  $inputs = $request->getParsedBody();
  $params = array(
    "user" => filter_var($inputs['user'],FILTER_SANITIZE_STRING),
    "pass" => filter_var($inputs['pass'],FILTER_SANITIZE_STRING)
  );
  if($params['user']!=null&&$params['pass']!=null){
    $user = CModelUsers::getUserLogin($this->db,$params['user'],$params['pass']);
    if(count($user)>0){
      $CSystemToken = new CSystemToken();
      $token = $CSystemToken->GenerateToken();
      $id = null;
      $name = null;
      $mail = null;
      $arrDataUser = [];
      foreach($user as $val){
        $id = $val["SecUserId"];
        $name = $val["Name"];
        $mail = $val['Email'];
      }
      $arrDataUser = ['id'=>$id,'name'=>$name,'mail'=>$mail];
      $datetime = date('Y-m-d H:i:s');

      $queryUpdTk = $this->db->prepare("UPDATE SecUser SET Token = :token, LastLogin=:datetime WHERE SecUserId=:id");
      $queryUpdTk->bindParam(":token",$token);
      $queryUpdTk->bindParam(":id",$id);
      $queryUpdTk->bindParam(":datetime",$datetime);
      $queryUpdTk->execute();

      $arrResponse = ['result'=>'LOGIN_SUCCESS','data'=>$arrDataUser,'token'=>$token];
    } else {
      $arrResponse = ['result'=>'ERROR_LOGIN'];
    }
  } else {
    $arrResponse = ['result'=>'ERROR_NULL_DATA'];
  }
  return $response->withJson($arrResponse);
});
/*-------API -> login-------*/

/*----------------------------------------------------BOOKS----------------------------------------------------*/
/*----------------------------------------------------BOOKS----------------------------------------------------*/
/*----------------------------------------------------BOOKS----------------------------------------------------*/
/*
 * getAllBooks
 */
//Retrive all records of the books
$app->get('/getAllBooks/{token}',function ($request, $response, $args){
  $token = filter_var($args['token'],FILTER_SANITIZE_STRING);
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $books = CModelCatalogs::ApiGetAllBooks($this->db,1);

      $arrResponse = ['Result'=>'SUCCESS','data'=>$books];
    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});

/*
 * createBook
 */
//Method for create a new books
$app->post('/createBook',function ($request, $response){
  $inputs = $request->getParsedBody();
  $params = array(
    "token" => filter_var($inputs['token'],FILTER_SANITIZE_STRING),
    "Name" => filter_var($inputs['Name'],FILTER_SANITIZE_STRING),
    "Author" => filter_var($inputs['Author'],FILTER_SANITIZE_STRING),
    "CatCategoryId" => filter_var($inputs['CatCategoryId'],FILTER_SANITIZE_STRING),
    "PublishDate" => filter_var($inputs['PublishDate'],FILTER_SANITIZE_STRING),
  );
  $token = $params['token'];
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $data = CModelCatalogs::ApiCreateBook($this->db,$params);
      $arrResponse = ['Result'=>'SUCCESS','data'=>$data];

    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});

/*
 * updateBook
 */
//Method for update books
$app->post('/updateBook',function ($request, $response){
  $inputs = $request->getParsedBody();
  $params = array(
    "token" => filter_var($inputs['token'],FILTER_SANITIZE_STRING),
    "id" => filter_var($inputs['id'],FILTER_SANITIZE_STRING),
    "Name" => filter_var($inputs['Name'],FILTER_SANITIZE_STRING),
    "Author" => filter_var($inputs['Author'],FILTER_SANITIZE_STRING),
    "CatCategoryId" => filter_var($inputs['CatCategoryId'],FILTER_SANITIZE_STRING),
    "PublishDate" => filter_var($inputs['PublishDate'],FILTER_SANITIZE_STRING),
  );
  $token = $params['token'];
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $data = CModelCatalogs::ApiUpdateBook($this->db,$params);
      $arrResponse = ['Result'=>'SUCCESS','data'=>$data];

    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});

/*
 * updateStatusBook
 */
//Method for update books
$app->post('/updateStatusBook',function ($request, $response){
  $inputs = $request->getParsedBody();
  $params = array(
    "token" => filter_var($inputs['token'],FILTER_SANITIZE_STRING),
    "id" => filter_var($inputs['id'],FILTER_SANITIZE_STRING),
    "Status" => filter_var($inputs['Status'],FILTER_SANITIZE_STRING),
  );
  $token = $params['token'];
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $data = CModelCatalogs::ApiUpdateStatusBook($this->db,$params);
      $arrResponse = ['Result'=>'SUCCESS','data'=>$data];

    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});

/*----------------------------------------------------BOOKS----------------------------------------------------*/
/*----------------------------------------------------BOOKS----------------------------------------------------*/
/*----------------------------------------------------BOOKS----------------------------------------------------*/

/*----------------------------------------------------BORROW BOOKS----------------------------------------------------*/
/*----------------------------------------------------BORROW BOOKS----------------------------------------------------*/
/*----------------------------------------------------BORROW BOOKS----------------------------------------------------*/
/*
 * getAllBorrowBooks
 */
//Retrive all records of the books
$app->get('/getAllBorrowBooks/{token}',function ($request, $response, $args){
  $token = filter_var($args['token'],FILTER_SANITIZE_STRING);
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $data = CModelOperations::ApiGetAllBorrowBooks($this->db);

      $arrResponse = ['Result'=>'SUCCESS','data'=>$data];
    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});

/*
 * getAllBooksAvailable
 */
//Retrive all records of the books
$app->get('/getAllBooksAvailable/{token}',function ($request, $response, $args){
  $token = filter_var($args['token'],FILTER_SANITIZE_STRING);
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $data = CModelOperations::ApiGetAllBooksAvailable($this->db);

      $arrResponse = ['Result'=>'SUCCESS','data'=>$data];
    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});

/*
 * createNewBorrowBook
 */
//Method for create a new books
$app->post('/createNewBorrowBook',function ($request, $response){
  $inputs = $request->getParsedBody();
  $params = array(
    "token" => filter_var($inputs['token'],FILTER_SANITIZE_STRING),
    "CatCustomerId" => filter_var($inputs['CatCustomerId'],FILTER_SANITIZE_STRING),
    "BeginDate" => filter_var($inputs['BeginDate'],FILTER_SANITIZE_STRING),
    "EndDate" => filter_var($inputs['EndDate'],FILTER_SANITIZE_STRING),
    "arrBooks" => $inputs['arrBooks']
  );
  $token = $params['token'];
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $data = CModelOperations::ApiCreateNewBorrowBook($this->db,$params);
      $arrResponse = ['Result'=>'SUCCESS','data'=>$data];

    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});

/*
 * updateStatusBorrowBook
 */
//Method for create a new books
$app->post('/updateStatusBorrowBook',function ($request, $response){
  $inputs = $request->getParsedBody();
  $params = array(
    "token" => filter_var($inputs['token'],FILTER_SANITIZE_STRING),
    "RelBorrowCustomerBookId" => filter_var($inputs['RelBorrowCustomerBookId'],FILTER_SANITIZE_STRING),
    "CatBooksId" => filter_var($inputs['CatBooksId'],FILTER_SANITIZE_STRING),
    "Status" => filter_var($inputs['Status'],FILTER_SANITIZE_STRING),
  );
  $token = $params['token'];
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $data = CModelOperations::ApiUpdateStatusBorrowBook($this->db,$params);
      $arrResponse = ['Result'=>'SUCCESS','data'=>$data];

    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});
/*----------------------------------------------------BORROW BOOKS----------------------------------------------------*/
/*----------------------------------------------------BORROW BOOKS----------------------------------------------------*/
/*----------------------------------------------------BORROW BOOKS----------------------------------------------------*/

/*----------------------------------------------------CATEGORIES----------------------------------------------------*/
/*----------------------------------------------------CATEGORIES----------------------------------------------------*/
/*----------------------------------------------------CATEGORIES----------------------------------------------------*/
/*
 * getAllCategories
 */
//Retrive all records of the books
$app->get('/getAllCategories/{token}',function ($request, $response, $args){
  $token = filter_var($args['token'],FILTER_SANITIZE_STRING);
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $data = CModelCatalogs::ApiGetAllCategories($this->db,1);

      $arrResponse = ['Result'=>'SUCCESS','data'=>$data];
    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});
/*----------------------------------------------------CATEGORIES----------------------------------------------------*/
/*----------------------------------------------------CATEGORIES----------------------------------------------------*/
/*----------------------------------------------------CATEGORIES----------------------------------------------------*/

/*----------------------------------------------------CUSTOMERS----------------------------------------------------*/
/*----------------------------------------------------CUSTOMERS----------------------------------------------------*/
/*----------------------------------------------------CUSTOMERS----------------------------------------------------*/
/*
 * getAllCustomers
 */
//Retrive all records of the customers
$app->get('/getAllCustomers/{token}',function ($request, $response, $args){
  $token = filter_var($args['token'],FILTER_SANITIZE_STRING);
  if($token!=null){
    $isTokenExist = CModelUsers::chkToken($this->db,$token);
    if(count($isTokenExist)===1){
      
      $data = CModelCatalogs::ApiGetAllCustomers($this->db);

      $arrResponse = ['Result'=>'SUCCESS','data'=>$data];
    } else {
      $arrResponse = ['Result'=>'ERROR_INVALID_TOKEN'];
    }
  } else {
    $arrResponse = ['Result'=>'ERROR_NULL_TOKEN'];
  }
  return $response->withJson($arrResponse);
});
/*----------------------------------------------------CUSTOMERS----------------------------------------------------*/
/*----------------------------------------------------CUSTOMERS----------------------------------------------------*/
/*----------------------------------------------------CUSTOMERS----------------------------------------------------*/

/*
 * logout
 */
//Method for logout 
$app->get('/logout/{token}',function ($request, $response, $args){
  $token = filter_var($args['token'],FILTER_SANITIZE_STRING);
    $chkToken = new CModelUsers();
    $chkToken->logout($this->db,$token);
    $arrResponse = ['Result'=>'SUCCESS'];
  return $response->withJson($arrResponse);
});
















