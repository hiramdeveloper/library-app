<?php

class CModelOperations
{

	//RelBorrowCustomerBook
	static public function ApiGetAllBorrowBooks($db){
		$querySel = $db->prepare("SELECT rbc.*, ccr.Name AS Customer, cbt.Name AS Book, ccy.Name AS Category, sss.Name AS Status
								  FROM RelBorrowCustomerBook AS rbc
								  JOIN CatCustomer AS ccr ON rbc.CatCustomerId = ccr.CatCustomerId
								  JOIN CatBooks AS cbt ON rbc.CatBooksId = cbt.CatBooksId
								  JOIN CatCategory AS ccy ON cbt.CatCategoryId = ccy.CatCategoryId
								  JOIN SysStatus AS sss ON rbc.SysStatusId = sss.SysStatusId
								  WHERE cbt.SysStatusId = 1 AND rbc.SysStatusId = 3");
	  	$querySel->execute();
	  	$result = $querySel->fetchAll();
	  	return $result;
	}

	static public function ApiGetAllBooksAvailable($db){
		$querySel = $db->prepare("SELECT cb.*, cc.Name AS Category, ss.Name AS Status
								  FROM CatBooks AS cb
								  JOIN CatCategory AS cc ON cb.CatCategoryId = cc.CatCategoryId
								  JOIN SysStatus as ss ON cb.SysStatusLendBookId = ss.SysStatusId
								  WHERE cb.SysStatusId = 1");
	  	$querySel->execute();
	  	$result = $querySel->fetchAll();
	  	return $result;
	}

	static public function ApiCreateNewBorrowBook($db,$params){
		$result = [];
		$borrowStatus = 3;
		foreach($params['arrBooks'] as $val){
			$query = $db->prepare("INSERT INTO RelBorrowCustomerBook (CatCustomerId,CatBooksId,SysStatusId,BeginDate,EndDate,CreatedDate) VALUES (:CatCustomerId,:CatBooksId,:SysStatusId,:BeginDate,:EndDate,:CreatedDate)");
			$query->bindParam(":CatCustomerId",$params['CatCustomerId']);
			$query->bindParam(":CatBooksId",$val);
			$query->bindParam(":SysStatusId",$borrowStatus);
			$query->bindParam(":BeginDate",$params['BeginDate']);
			$query->bindParam(":EndDate",$params['EndDate']);
			$query->bindParam(":CreatedDate",date('Y-m-d H:i:s'));
		  	$query->execute();
		  	$id = $db->lastInsertId();

		  	$queryUpd = $db->prepare("UPDATE CatBooks SET SysStatusLendBookId =:SysStatusLendBookId WHERE CatBooksId =:CatBooksId");
		  	$queryUpd->bindParam(":SysStatusLendBookId",$borrowStatus);
			$queryUpd->bindParam(":CatBooksId",$val);
			$queryUpd->execute();

		  	$querySel = $db->prepare("SELECT rbc.*, ccr.Name AS Customer, cbt.Name AS Book, ccy.Name AS Category, sss.Name AS Status
								  FROM RelBorrowCustomerBook AS rbc
								  JOIN CatCustomer AS ccr ON rbc.CatCustomerId = ccr.CatCustomerId
								  JOIN CatBooks AS cbt ON rbc.CatBooksId = cbt.CatBooksId
								  JOIN CatCategory AS ccy ON cbt.CatCategoryId = ccy.CatCategoryId
								  JOIN SysStatus AS sss ON rbc.SysStatusId = sss.SysStatusId
								  WHERE cbt.SysStatusId = 1 AND rbc.RelBorrowCustomerBookId = :RelBorrowCustomerBookId");
		  	$querySel->bindParam(":RelBorrowCustomerBookId",$id);
		  	$querySel->execute();
		  	$result[] = $querySel->fetchAll();
		}
		return $result;	
	}

	static public function ApiUpdateStatusBorrowBook($db,$params){
		$activeStatus = 2;
		$Status = $params['Status'];
		$queryUpd = $db->prepare("UPDATE CatBooks SET SysStatusLendBookId =:SysStatusLendBookId WHERE CatBooksId =:CatBooksId");
	  	$queryUpd->bindParam(":SysStatusLendBookId",$activeStatus);
		$queryUpd->bindParam(":CatBooksId",$params['CatBooksId']);
		$queryUpd->execute();

		$queryUpdRel = $db->prepare("UPDATE RelBorrowCustomerBook SET SysStatusId =:SysStatusId WHERE RelBorrowCustomerBookId =:RelBorrowCustomerBookId");
	  	$queryUpdRel->bindParam(":SysStatusId",$Status);
		$queryUpdRel->bindParam(":RelBorrowCustomerBookId",$params['RelBorrowCustomerBookId']);
		$queryUpdRel->execute();

		$querySel = $db->prepare("SELECT cb.*, cc.Name AS Category, ss.Name AS Status
								  FROM CatBooks AS cb
								  JOIN CatCategory AS cc ON cb.CatCategoryId = cc.CatCategoryId
								  JOIN SysStatus as ss ON cb.SysStatusLendBookId = ss.SysStatusId
								  WHERE cb.SysStatusId = 1 AND cb.CatBooksId =:CatBooksId");
		$querySel->bindParam(":CatBooksId",$params['CatBooksId']);
	  	$querySel->execute();
	  	$result = ['result'=>$querySel->fetchAll(),'row'=>$params['RelBorrowCustomerBookId']];
	  	return $result;	
	}
	//RelBorrowCustomerBook

}