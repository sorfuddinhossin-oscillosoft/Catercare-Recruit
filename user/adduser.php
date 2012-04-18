<div id="userRightDiv">
	<h1>User Addition <span>(Add a new user)</span></h1>
	
	<?php
	
		$row = $user->zohosettings();
	 ?>
	<div class="userContent">
		<h2>Add a new user</h2>
		<div id="registrationFormSuccess" style="display:none">
			<p style="color:green;font-weight:bold">
				Registration successful. A detials with url, userid and password is sent to the mail of the user.
			</p>
		</div>
		<div id="registrationFormDiv">
		<form name="refForm" enctype="application/x-www-form-urlencoded" method="POST" action="">
					<label>First Name</label>
					<input type="text" name="fname" class="mandatory"><br>
					<label>Last Name</label>
					<input type="text" name="lname"><br>
					<label>Address</label>
					<input type="text" name="address" class="mandatory"><br>
					<label>Address Line Two</label>
					<input type="text" name="addresstwo"><br>
					<label>Phone</label>
					<input type="text" name="phone">
					<label>Email</label>
					<input type="text" name="email" class="mandatory"><br>
					<label>Post Code</label>
					<input type="text" name="zip">
					<label>City</label>
					<input type="text" name="city">
					<label>Country</label>
					<input type="text" name="country"><br>
					<input type="hidden" value="1" name="regtype">	
					<input type="hidden" value="<?php echo $_SESSION['group_id']?>" name="group_id">						
					<input type="button" onclick="javascript:userregistration()" name="registration" value="Submit">
					<input type="reset" value="Reset">
					<br><br>
				</form>
				</div>
			

	</div>
</div>