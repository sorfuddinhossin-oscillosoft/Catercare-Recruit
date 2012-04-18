<?php
include_once '../class/class.login.php';
$log = new logmein(); 
$log->logout();
header( 'Location: '.$log->base_url );
?>