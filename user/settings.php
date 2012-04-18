<div id="userRightDiv">
	<h1>Zoho Settings <span>(Manage your CRM Ticket, Username, Password etc.)</span></h1>
	<ul class="settingsList">		
		<li><a href="index.php?pg=seeksettings">SEEK Credentials</a></li>
		<li><a href="index.php?pg=settings">Zoho Credentials</a></li>
	</ul>
	<?php
		$row = $user->zohosettings();
	 ?>
	<div class="userContent">
		<h2>Zoho Credentials</h2>
		<p class="importantnotice">
		This following Zoho Credential is mandatory for pick the list of Jobs from Zoho Recruit so please put the information in correct.
Please do not change it frequently that may effect your jobs in the website. Remember your zoho creadential is highly confidential. We do not share this information with anyone else.
		</p>
		<?php 
		if(isset($_REQUEST['zohoCredentialSubmit'])){
		 	$row = $user->zohosettingsUpdate();
		 	if($row==true){
		 		echo '
		 		<p>Data Updated Successfully. <a href="index.php?pg=settings">Go Back</a></p>
		 		';
		 	}else echo 'Can not be update data';
		}else{		
			if(isset($_REQUEST['edit'])&&($_REQUEST['edit']==1)){?>
			<form action="" method="post" id="zohoCredentialForm">
			<label>Zoho User Id</label>
			<input type="text" name="userid" id="userid" value="<?php echo $row['zohouserid'];?>"><br />
			<label>Zoho Password</label>
			<input type="text" name="userpass" id="userpass"  value="<?php echo $row['password'];?>"><br />
			<label>API Key</label>
			<input type="text" name="api" id="api" value="<?php echo $row['api'];?>"><br />
			<input type="hidden"  name="zohoCredentialSubmit" value="1">
			<input type="Button" value="Submit" id="zohoCredentialSubmit">
			<a href="index.php?pg=settings" class="btnLike">Cancel</a>
			</form>
			<?php }else{?>
			<label>Zoho User Id</label>
			<input type="text" name="userid" readonly value="<?php echo $row['zohouserid'];?>"><br />
			<label>Zoho Password</label>
			<input type="text" name="userpass" readonly value="<?php echo $row['password'];?>"><br />
			<label>API Key</label>
			<input type="text" name="api" readonly value="<?php echo $row['api'];?>"><br />
			<label>API Ticket</label>
			<input type="text" name="ticket" readonly value="<?php echo $row['ticket'];?>">&nbsp;
			<span>Last Updated on <?=$row['ticket_last_update'];?>&nbsp;<a href="index.php?pg=ticketgeneration" class="ticketGenerate">Generate New</a></span><br />
			<br />
			<a href="index.php?pg=settings&edit=1" class="btnLike">Change Now</a>
			<?php
				} 
		}?>
	</div>
</div>