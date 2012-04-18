<div id="userRightDiv">
	<h1>Settings <span>(Generate Ticket)</span></h1>
	<?php
		$row = $user->zohosettings();
	 ?>
	<div class="userContent">
		<h2>Ticket Generation</h2>
		<p class="importantnotice">
		Ticket is generated using Zoho login id and password. If you set wrong Zoho User ID or Password the ticket will return something wrong information. So be sure Zoho User ID and Password is right in the settings before generate a ticket.
		</p>
		
		<?php 
		if(isset($_REQUEST['issubmit'])){
			$row = $user->ticketUpdate($row['zohouserid'],$row['password'],$row['logonid']);
			
		 	if($row==true){
		 		echo '	<p>Ticket Updated Successfully. <a href="index.php?pg=settings">Go Back</a></p>
		 		';
		 	}else echo 'Can not be update data';
		 	
		}else{?>		
			<form action="" method="post" id="ticketGenerationForm">
			<h3>Zoho User Id : <strong><?php echo $row['zohouserid'];?></strong></h3>
			<h3>Zoho Password : <strong><?php echo $row['password'];?></strong></h3>
			<h3>Ticket : <strong><?php echo $row['ticket'];?></strong>&nbsp;(Last update on <?=$row['ticket_last_update'];?>)</h3>
			<input type="hidden" name="zohoid" value="<?=$row['zohouserid'];?>">
			<input type="hidden" name="zohopass" value="<?=$row['password'];?>">
			<input type="hidden" name="issubmit" value="1">
			<input type="Submit" value="Generate Ticket">
			<a href="index.php?pg=settings" class="btnLike">Cancel</a> 
			</form>
			<?php }?>		
		
	</div>
</div>