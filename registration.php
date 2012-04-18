<div id="main">
<div id="mainbottom">
<div id="bodyContainter"> 	
	<div id="page">
		<div class="left">
			<img border="0" src="<?php echo $images; ?>reg.png" align="right" alt="Oscillosoft Pty Limited">
		</div>
		<div class="right">
			<h1>User Registration</h1>
			<div class="content">
			<div class="formGuide">
				<ul>
					<li class="optional">Optional</li>
					<li class="mandatory">Mandatory</li>
					<li class="duplicate">Duplicate</li>
				</ul>
			</div>
				<?php
					if(isset($_REQUEST['registration'])){
						$result = $log->registration();
						if($result==true){
							echo '<span style="color:green;font-weight:bold;font-size:14px;">Registration Successfull.</span>';
						}
					} 
				
				if(!isset($_REQUEST['registration'])){
					
				?>
					
				<form action="" method="POST" enctype="application/x-www-form-urlencoded" name="refForm">
					<label>First Name</label><br />
					<input class="mandatory" type="text" name="fname"><br />
					<label>Last Name</label><br />
					<input type="text" name="lname"><br />
					<label>Address</label><br />
					<input class="mandatory" type="text" name="address"><br />
					<label>Address Line Two</label><br />
					<input type="text" name="addresstwo"><br />
					<label>Phone</label><br />
					<input type="text" name="phone"><br />
					<label>Email</label><br />
					<input class="mandatory" type="text" name="email"><br />
					<label>Zip Code</label><br />
					<input type="text" name="zip"><br />
					<label>City</label><br />
					<input type="text" name="city"><br />
					<label>Country</label><br />
					<input type="text" name="country"><br />
					<label class="blue">Password</label><br />
					<input class="duplicate" type="password" name="password"><br />
					<label class="blue">Retype Password</label><br />
					<input class="duplicate" type="password" name="confirmpass"><br />
					<input type="Submit" Value="Submit" name="registration">
					<input type="reset" Value="Reset">
				</form>
				<?php } ?>
			</div>
		</div>
	</div>	
	<div style="clear:both"></div>
</div>

</div>

</div>