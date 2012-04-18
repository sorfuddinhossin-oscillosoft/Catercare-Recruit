<?php
include_once '../class/class.user.php';
$user = new user();
$result = $user->updateFields($_REQUEST['id'],$_REQUEST['field'],$_REQUEST['value']);
echo $result; 
?>