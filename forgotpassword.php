<div id="main">
<div id="mainbottom">
<div id="bodyContainter"> 	
	<div id="page">
		<div class="left">
			<img border="0" src="<?php echo $images; ?>reg.png" align="right" alt="Oscillosoft Pty Limited">
		</div>
		<div class="right">
			
			
					
					<div class="right_area">
					<h1>Retrieve Password</h1>
					<p>Please enter your id(Email) to retrieve the password. Password will send to your email address.</p>
					<?php
					
					
					
					if(isset($_REQUEST['postUserEmail'])){
					$pass = $log->createPassword();
					$data = array(
						  "password"=>md5($pass)
						  );  	
						  
											  
					$result = $shDB->updateonfield($data,trim($_REQUEST['postUserEmail']),'useremail','logon');
					
					if($result==true){
						passwordreset($_REQUEST['postUserEmail'],$pass);
					
						echo '<span style="color:green;font-weight:bold">Your password is reset. Please check your email for the new password.</span>';
					}else{
						echo '<span style="color:red;font-weight:bold">Can\'t reset your password now. Please try later';
					}
					
					
					}else{
			  ?>
			  	<form name="forgotPassword" method="post"  action="">
			  	<div><label for="username">Put your email address that you use for login.</label><br />
				<input name="postUserEmail" id="postUserEmail" type="text">
				<div>
				<input value="Retrieve Password" type="submit">
				</div>
				</div>
				</form>
				<?php } ?>
			</div>
		</div>
	</div>	
	<div style="clear:both"></div>
</div>

</div>

</div>