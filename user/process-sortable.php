<?php
/* This is where you would inject your sql into the database 
   but we're just going to format it and send it back
*/
include_once '../class/class.user.php';
$user = new user();

foreach ($_GET['listItem'] as $position => $item) :
	$result[] = $user->qry("UPDATE job_field SET `displayorder` = ? WHERE `id` = ?",$position,$item);
endforeach;

//print_r ($result);
?>