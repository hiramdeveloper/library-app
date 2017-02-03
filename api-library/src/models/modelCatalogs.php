<?php

class CModelCatalogs
{
	//Books
	static public function ApiGetAllBooks($db){
		$querySel = $db->prepare("SELECT cb.*, cc.Name AS Category, ss.Name AS Status
								  FROM CatBooks AS cb
								  JOIN CatCategory AS cc ON cb.CatCategoryId = cc.CatCategoryId
								  JOIN SysStatus as ss ON cb.SysStatusId = ss.SysStatusId");
	  	$querySel->execute();
	  	$result = $querySel->fetchAll();
	  	return $result;
	}

	static public function ApiCreateBook($db,$params){
		$query = $db->prepare("INSERT INTO CatBooks (CatCategoryId,Name,Author,PublishDate) VALUES (:CatCategoryId,:Name,:Author,:PublishDate)");
		$query->bindParam(":CatCategoryId",$params['CatCategoryId']);
		$query->bindParam(":Name",$params['Name']);
		$query->bindParam(":Author",$params['Author']);
		$query->bindParam(":PublishDate",$params['PublishDate']);
	  	$query->execute();
	  	$id = $db->lastInsertId();

	  	$querySel = $db->prepare("SELECT cb.*, cc.Name AS Category
								  FROM CatBooks AS cb
								  JOIN CatCategory AS cc ON cb.CatCategoryId = cc.CatCategoryId
								  WHERE CatBooksId =:CatBooksId");
	  	$querySel->bindParam(":CatBooksId",$id);
	  	$querySel->execute();
	  	$result = $querySel->fetchAll();
	  	return $result;
	}

	static public function ApiUpdateBook($db,$params){
		$query = $db->prepare("UPDATE CatBooks SET CatCategoryId =:CatCategoryId, Name =:Name, Author =:Author, PublishDate =:PublishDate WHERE CatBooksId =:id");
		$query->bindParam(":CatCategoryId",$params["CatCategoryId"]);
		$query->bindParam(":Name",$params["Name"]);
		$query->bindParam(":Author",$params["Author"]);
		$query->bindParam(":PublishDate",$params["PublishDate"]);
		$query->bindParam(":id",$params["id"]);
	  	$query->execute();

	  	$querySel = $db->prepare("SELECT cb.*, cc.Name AS Category
								  FROM CatBooks AS cb
								  JOIN CatCategory AS cc ON cb.CatCategoryId = cc.CatCategoryId
								  WHERE CatBooksId =:CatBooksId");
	  	$querySel->bindParam(":CatBooksId",$params["id"]);
	  	$querySel->execute();
	  	$result = $querySel->fetchAll();
	  	return $result;
	}

	static public function ApiUpdateStatusBook($db,$params){
		$query = $db->prepare("UPDATE CatBooks SET SysStatusId =:SysStatusId WHERE CatBooksId =:id");
		$query->bindParam(":SysStatusId",intval($params["Status"]));
		$query->bindParam(":id",$params["id"]);
	  	$query->execute();

	  	$querySel = $db->prepare("SELECT cb.*, cc.Name AS Category, ss.Name AS Status
								  FROM CatBooks AS cb
								  JOIN CatCategory AS cc ON cb.CatCategoryId = cc.CatCategoryId
								  JOIN SysStatus as ss ON cb.SysStatusId = ss.SysStatusId
								  WHERE CatBooksId =:CatBooksId");
	  	$querySel->bindParam(":CatBooksId",$params["id"]);
	  	$querySel->execute();
	  	$result = $querySel->fetchAll();
	  	return $result;
	}
	//Books

	//Categories
	static public function ApiGetAllCategories($db){
		$querySel = $db->prepare("SELECT * FROM CatCategory");
	  	$querySel->execute();
	  	$result = $querySel->fetchAll();
	  	return $result;
	}
	//Categories

	//Customers
	static public function ApiGetAllCustomers($db){
		$querySel = $db->prepare("SELECT * FROM CatCustomer WHERE SysStatusId = 1");
	  	$querySel->execute();
	  	$result = $querySel->fetchAll();
	  	return $result;
	}
	//Customers

}