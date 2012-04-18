<div id="userRightDiv">
	<h1>User Edit <span>(Edit user profile)</span></h1>
	
	<?php
	
	$userSelectBy = array(
							'userid' => $_REQUEST['id']
							);
	$user =  $shDB->selectOnMultipleCondition($userSelectBy,'`logon`');
	$user = $user[0];
	 ?>
	<div class="userContent">
		<h2>Add a new user</h2>
		<div id="registrationFormSuccess" style="display:none">
			<p style="color:green;font-weight:bold">
				Update successful. 
			</p>
		</div>
		<div id="registrationFormDiv">
		<form name="refForm" enctype="application/x-www-form-urlencoded" method="POST" action="">
					<label>First Name</label>
					<input type="text" name="fname" class="mandatory" value="<?php echo $user['fname']?>"><br>
					<label>Last Name</label>
					<input type="text" name="lname"  value="<?php echo $user['lname']?>"><br>
					<label>Address</label>
					<input type="text" name="address" class="mandatory"  value="<?php echo $user['address']?>"><br>
					<label>Address Line Two</label>
					<input type="text" name="addresstwo"  value="<?php echo $user['addresstwo']?>"><br>
					<label>Phone</label>
					<input type="text" name="phone"  value="<?php echo $user['phone']?>">
					<label>Post Code</label>
					<input type="text" name="zip"  value="<?php echo $user['zip']?>">
					<label>City</label>
					<input type="text" name="city"  value="<?php echo $user['city']?>">
					<label>Country</label>
					<input type="text" name="country"  value="<?php echo $user['country']?>"><br>
					<input type="hidden" name="userid" value="<?php echo $_REQUEST['id'];?>">
					<input type="button" onclick="javascript:userupdate()" name="registration" value="Update Now"> &nbsp;
					<input type="button" onclick="history.go(-1);" value="Back"> &nbsp;
					
					<br><br>
				</form>
				</div>
			

	</div>
</div>