<div id="userRightDiv">
	<h1>SEEK Settings <span>(Manage your SEEK username, password and role.)</span></h1>
	<ul class="settingsList">
		<li><a href="index.php?pg=seeksettings">SEEK Credentials</a></li>
		<li><a href="index.php?pg=settings">Zoho Credentials</a></li>
	</ul>
	<?php
		$row = $user->seeksettings();
	 ?>
	<div class="userContent">
		<h2>SEEK Credentials</h2>
		<p class="importantnotice">
		This following SEEK Credential is mandatory for post the job from Zoho to SEEK automatically. So please don't change the information frequently. If the information entered wrongly in the database. There may problem uploading jobs to SEEK. Remember your SEEK creadential is highly confidential. We do not share this information with anyone else.
		</p>
		<?php 
		if(isset($_REQUEST['seekCredentialSubmit'])){
			
		 	$row = $user->seeksettingsUpdate();
		 	if($row==true){
		 		echo '
		 		<p>Data Updated Successfully. <a href="index.php?pg=seeksettings">Go Back</a></p>
		 		';
		 	}else echo 'Can not be update data';
		}else{		
			if(isset($_REQUEST['edit'])&&($_REQUEST['edit']==1)){?>
			<form action="" method="post" id="seekCredentialForm">
			<label>SEEK User Name</label>
			<input type="text" name="userid" id="userid" value="<?php echo $row['seekuserid'];?>"><br />
			<label>SEEK Password</label>
			<input type="text" name="userpass" id="userpass"  value="<?php echo $row['password'];?>"><br />
			<label>Role</label>
			<input type="text" name="role" id="role" value="<?php echo $row['role'];?>"><br />
			<label>Client ID</label>
			<input type="text" name="clientid" id="clientid" value="<?php echo $row['clientid'];?>"><br />
			<!-- 
			<label>Agent ID</label>
			<input type="text" name="agentid" id="agentid" value="<?php echo $row['agentid'];?>"><br />
			 -->
			<label>SEEK ID</label>
			<input type="text" name="seekid" id="seekid" value="<?php echo $row['seekid'];?>"><br />
			<label>Logo ID</label>
			<input type="text" name="logoid" id="logoid" value="<?php echo $row['logoid'];?>"><br />
			<label>Template ID</label>
			<input type="text" name="templateid" id="templateid" value="<?php echo $row['templateid'];?>"><br /><br />
			<!-- 
			<label>Screen ID</label>
			<input type="text" name="screenid" id="screenid" value="<?php echo $row['screenid'];?>"><br /><br />
			-->
			<input type="hidden"  name="seekCredentialSubmit" value="1">
			<input type="button" value="Submit" id="seekCredentialSubmit">
			<a href="index.php?pg=seeksettings" class="btnLike">Cancel</a>
			</form>
			<?php }else{?>
			<label>SEEK User Name</label>
			<input type="text" name="userid" readonly value="<?php echo $row['seekuserid'];?>"><br />
			<label>SEEK Password</label>
			<input type="text" name="userpass" readonly value="<?php echo $row['password'];?>"><br />
			<label>Role</label>
			<input type="text" name="api" readonly value="<?php echo $row['role'];?>"><br />
			<label>Client ID</label>
			<input type="text" name="clientid" id="clientid" readonly  value="<?php echo $row['clientid'];?>"><br />
			<!-- 
			<label>Agent ID</label>
			<input type="text" name="agentid" id="agentid" readonly  value="<?php echo $row['agentid'];?>"><br />
			 -->
			<label>SEEK ID</label>
			<input type="text" name="seekid" id="seekid" readonly  value="<?php echo $row['seekid'];?>"><br />
			<label>Logo ID</label>
			<input type="text" name="logoid" id="logoid" readonly  value="<?php echo $row['logoid'];?>"><br />
			<label>Template ID</label>
			<input type="text" name="templateid" id="templateid" readonly  value="<?php echo $row['templateid'];?>"><br />
			<!-- 
			<label>Screen ID</label>
			<input type="text" name="screenid" id="screenid" readonly  value="<?php echo $row['screenid'];?>"><br /><br />
			 -->
			 <br />
			<a href="index.php?pg=seeksettings&edit=1" class="btnLike">Change Now</a>
			<?php
				} 
		}?>
	</div>
</div>