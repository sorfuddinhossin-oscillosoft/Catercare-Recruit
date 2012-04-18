<?php
session_start();
include_once '../class/class.login.php';
include_once '../class/dbclass.php';
include_once '../class/ps_pagination.php';
include_once '../class/class.user.php';
include_once '../class/xml.class.php';
include_once '../class/mycurl.php';
include_once '../class/function.php';

$log = new logmein();
$shDB = new sh_DB();
$user = new user();
$xml = new Xml2Assoc();
$myCurl = new CURL();

$loginCheck = $log->logincheck($_SESSION['loggedin'], "logon", "password", "useremail");

if($loginCheck == false){
	header( 'Location: '.$log->base_url );
}
include_once 'header.php';
// include_once 'left.php';
 
if(!$_REQUEST['pg']){
	include_once 'dashboard.php';
}else{
	include_once $_REQUEST['pg'].'.php';
} 
include_once 'footer.php'; 
?>