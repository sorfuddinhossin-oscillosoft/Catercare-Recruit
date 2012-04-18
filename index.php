<?php
include_once 'class/class.login.php';
include_once 'class/dbclass.php';
include_once 'class/function.php';
$shDB = new sh_DB();
$log = new logmein();
$loginFailedMessage = '';
if(isset($_REQUEST['action'])){
			 $result = $log->login($_REQUEST['username'], $_REQUEST['password']);	
			 if($result==1){			 	
			 	 header('Location: '.$log->base_url.'user/index.php?pg=joblist');
			 }else{
			 	$loginFailedMessage = '<span style="color:red;padding:20px 0px;display:block">Wrong username or password.</span>';
			 }
}
include_once 'header.php';
//$log->cratetable('logon');
if(!$_REQUEST['pg']){
include_once 'homecontent.php';
}else{
	include_once $_REQUEST['pg'].'.php';
} 
include_once 'footer.php'; 
?>
