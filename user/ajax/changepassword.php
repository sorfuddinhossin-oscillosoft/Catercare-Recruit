<?php
include_once '../../class/dbclass.php';
include_once '../../class/class.login.php';
include_once '../../class/function.php';

$shDB =new sh_DB();
$log =new logmein();


$oldPass = md5(trim($_REQUEST['oldpass']));

$dataforEmailExist = array(
					'password' => $oldPass,
					'userid' => $_REQUEST['userid']
					);
$imageIsExistResult = $shDB->selectOnMultipleCondition($dataforEmailExist,'logon');



if($imageIsExistResult){
	$data = array(
	 'password' => md5($_REQUEST['newpass'])
	  );  
	  
$userId = $shDB->updateonfield($data,$_REQUEST['userid'],'userid','logon');
if($userId){
 	echo 1;
 }else{ 
 	echo 0;
 }
}else{
	echo 0;
}
?>