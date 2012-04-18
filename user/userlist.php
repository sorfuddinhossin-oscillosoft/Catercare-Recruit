<?php 
if(isset($_REQUEST['status'])){
	
	$status = $_REQUEST['status'];
}else{
		$status = 1;			
}
	$userSelectBy = array(
							'group_id' => $_SESSION['group_id'],
							'status' => $status
							);
	$allUser =  $shDB->selectOnMultipleCondition($userSelectBy,'`logon`');
	$UserList = $allUser;	
		
		// var_dump($JobsList123);
		// $UserList = $allUser['records'];
		// $paging = $allUser['pagination'];
		

						// $allJobs = $shDB->selectOnMultipleCondition('','`jobs_posted`');
						/*
						$allJobs1 =  $shDB->select('`jobs_posted`');
						$allJobs = $allJobs1['records'];
						$paging = $allJobs1['pagination'];
						*/
?>
<div id="userRightDiv">
	<h1>User List <span>(listing all user entry from plugins)</span></h1>
	<ul class="settingsList">		
		<li><a href="index.php?pg=adduser">Add new user</a></li>		
	</ul>
	
	<div class="userContent" style="clear:both">
<!--		<p class="importantnotice">-->
<!--		This following Fields are directly coming from Zoho using your settings. Now you can manage the Order,Group name and Validation here. Then click Flush XML so that it can be update to your website accordingly. -->
<!--		</p>-->
	<br />
	<table width="100%" cellpadding="5" cellspacing="0" class="joblisting">
		<tr><th align="left">Email</th><th align="center">First Name</th><th align="center">Last Name</th><th align="center">Register On</th><th align="left">Action</th></tr>
		<?php
		if($UserList){
		 foreach($UserList as $user){?>
		<tr>
			<td align="left"><?php echo $user['useremail']; ?></td>
			<td align="center"><?php echo $user['fname']; ?></td>
			<td align="center"><?php echo $user['lname']; ?></td>
			<td align="center"><?php echo $user['registration_date']; ?></td>
			<td align="left">
				&raquo; <a href="index.php?pg=useredit&id=<?php echo $user['userid'];?>">Edit</a><br />
			</td>
		</tr>
		
		<?php } ?>
		<tr><td colspan="5"><div id="paging"><?php echo $paging; ?></div></td></tr>
		<?php }else{ ?>
		<tr><td colspan="5">No Records Found</td></tr>
		<?php } ?>
		</table>
		
		
		<br /><br />
	</div>
</div>