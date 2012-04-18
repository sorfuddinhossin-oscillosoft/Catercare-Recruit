<?php 
	$allLogs =  $shDB->select('`job_log_report`');

		
		
		// var_dump($JobsList123);
		$logs = $allLogs['records'];
		$paging = $allLogs['pagination'];
		

						// $allJobs = $shDB->selectOnMultipleCondition('','`jobs_posted`');
						/*
						$allJobs1 =  $shDB->select('`jobs_posted`');
						$allJobs = $allJobs1['records'];
						$paging = $allJobs1['pagination'];
						*/
?>
<div id="userRightDiv">
	<h1>Log Report</h1>
		
	<div class="userContent" style="clear:both">

	<br />
	
		<table width="100%" cellpadding="5" cellspacing="0" class="joblisting">
		<tr><th align="left">Job Title</th><th align="center">Loged By</th><th align="center">Loged Type</th><th align="center">Loged On</th><th align="center">IP</th><th align="left">Action</th></tr>
		<?php
		if($logs){
		 foreach($logs as $logss){?>
		<tr>
			<td align="left"><?php echo $logss['job_title']; ?></td>
			<td align="center"><?php echo namebyId($logss['logonid']); ?></td>
			<td align="center"><?php echo $logss['opt_type']; ?></td>
			<td align="center"><?php echo $logss['time']; ?></td>
			<td align="center"><?php echo $logss['ip']; ?></td>
			<td align="center">			&raquo; <a href="index.php?pg=logview&id=<?php echo $logss['id'];?>">View</a><br />	</td>			
			
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