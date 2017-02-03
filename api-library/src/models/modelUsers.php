<?php

class CModelUsers
{
	
	static public function getUserLogin($c,$user,$pass){
		$query = $c->prepare("SELECT SecUserId,Name,Email FROM SecUser where UserName=:user and Password=:pass");
	   	$query->bindParam(":user",$user);
	  	$query->bindParam(":pass",$pass);
	  	$query->execute();
	  	$user = $query->fetchAll();
	  	return $user;
	}

	static public function chkToken($db,$token){
		$query = $db->prepare("SELECT SecUserId FROM SecUser WHERE Token=:token");
		$query->bindParam(":token",$token);
	  	$query->execute();
	  	$result = $query->fetchAll();
	  	return $result;
	}

	static public function logout($db,$token){
		$query = $db->prepare("UPDATE SecUser SET Token = NULL WHERE Token=:token");
		$query->bindParam(":token",$token);
	  	$query->execute();
	  	$result = 'OK';
	  	return $result;
	}

}