<div id="userRightDiv">
	<h1>Dashboard</h1>
	<div style="width:500px;float:left;padding:10px;">
	<p class="importantnotice">
	</p>
</div>
	<div id="personalInfo">
	<?php 
	$userselectid = array(
							'userid' => $_SESSION['userid']
							);
						$User = $shDB->selectOnMultipleCondition($userselectid,'`logon`');
						$User = $User[0];
	?>
		<h1>Personal Information</h1>
		<div style="padding:10px;">
			<strong><?php echo $User['fname'].' '.$User['lname'];?></strong><br />
			Contact - <strong><?php echo $User['phone'];?></strong><br />
			<i><?php echo $User['useremail'];?></i><br />
			Address : <?php echo $User['address'];?><br />
			Zip - <?php echo $User['zip'];?><br />
			<?php echo $User['city'];?>, <?php echo $User['country'];?><br />
			Member Since - <font style="color:#FF6600;font-size:14px"><strong><?php echo date('d-m-Y',strtotime($User['registration_date']));?></strong></font>
			
		</div>
		<h1>Change Password</h1>
		<lable>Old Password</label>
		<input type="text" name="oldpassword" id="oldpassword" style="width:216px;"><br />
		<lable>New Password</label>
		<input type="text" name="newpassword" id="newpassword"  style="width:216px;"><br />
		<lable>Retype Password</label>
		<input type="hidden" id="userid" value="<?php echo $_SESSION['userid'];?>">
		<input type="text" name="retypepass" id="retypepass"  style="width:216px;"><br />
		<input type="button" value="Change Password" id="btnChangePass" style="margin:8px 2px 10px;">		
	</div>
</div>