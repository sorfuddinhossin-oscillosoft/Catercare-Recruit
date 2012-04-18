<?php 
require_once '../../class/xml.class.php';
require_once '../../class/class.user.php';
require_once '../../class/mycurl.php';
$user = new user();
$row1 = $user->allzohosettings();
foreach ($row1 as $row){
			 $row = $user->ticketUpdate($row['zohouserid'],$row['password'],$row['logonid']);
}
?>
	