<?php
include_once '../../class/dbclass.php';
include_once '../../class/class.login.php';
include_once '../../class/function.php';

$shDB =new sh_DB();
$log =new logmein();

	$data = array(
	  "fname"=>trim($_REQUEST['fname']),
	  "lname"=>trim($_REQUEST['lname']),
	  "address"=>trim($_REQUEST['address']),
	  "addresstwo"=>trim($_REQUEST['addresstwo']),
	  "phone"=>trim($_REQUEST['phone']),
	  "zip"=>trim($_REQUEST['zip']),
	  "city"=>trim($_REQUEST['city']),
	  "country"=>trim($_REQUEST['country'])
	  );  
	  
 $userId = $shDB->updateonfield($data,$_REQUEST['id'],'userid','logon');
 
 if($userId){
 	echo 1;
 }else{ 
 	echo 0;
 }
?>