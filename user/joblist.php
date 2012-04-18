<?php 
if($_REQUEST['status']=='In-progress'){
	
	$jobSelectBy = array(
							'job_opening_status' =>'In-progress'
							);
						$allJobs1 = $shDB->selectOnMultipleConditionWithPagingWithOrder($jobSelectBy,'jobs_posted','ORDER BY open_date DESC');
}else{
	$allJobs1 =  $shDB->selectWithOrder('`jobs_posted`','ORDER BY open_date DESC');
}
		
		
		// var_dump($JobsList123);
		$allJobs = $allJobs1['records'];
		$paging = $allJobs1['pagination'];
		

						// $allJobs = $shDB->selectOnMultipleCondition('','`jobs_posted`');
						/*
						$allJobs1 =  $shDB->select('`jobs_posted`');
						$allJobs = $allJobs1['records'];
						$paging = $allJobs1['pagination'];
						*/
?>
<div id="userRightDiv">
	<h1>Job List <span>(listing all jobs entry from plugins)</span></h1>
		
	<div class="userContent" style="clear:both">
<!--		<p class="importantnotice">-->
<!--		This following Fields are directly coming from Zoho using your settings. Now you can manage the Order,Group name and Validation here. Then click Flush XML so that it can be update to your website accordingly. -->
<!--		</p>-->
	<br />
	<?php 
	
	$inprogress = '';
	$all = '';
	
		
	
	switch($_REQUEST['status']){
		case 'In-progress':
			$inprogress = 'current';
			break;
		
		default:
			$all = 'current';
			break;			
	}
	
	?>
	<ul id="StatusFilter" style="clear:both">
		<li><a href="index.php?pg=joblist&status=In-progress" class="<?php echo $inprogress;?>">In Progress</a>
		<li><a href="index.php?pg=joblist&status=All"  class="<?php echo $all;?>">All</a>
		
	</ul>
		<table width="100%" cellpadding="5" cellspacing="0" class="joblisting" style="clear:both;margin-top:25px;">
		<tr>
		<th style="background:#dddddd" align="left">Job Title</th>
		<th style="background:#dddddd" align="center">Open Date</th>
		<th style="background:#dddddd" align="center">Status</th>
		<th style="background:#dddddd" align="center">Published In</th>
		<th style="background:#dddddd" align="left">Action</th>
		</tr>
		<?php
		if($allJobs){
		 foreach($allJobs as $jobs){?>
		<tr>
			<td align="left"><?php echo $jobs['job_title']; ?></td>
			<td align="center"><?php echo date('d-m-Y',strtotime($jobs['open_date'])); ?></td>
			<td align="center"><?php echo $jobs['job_opening_status']; ?></td>
			<td align="center"><?php echo $jobs['published_in']; ?></td>
			<td align="left">
				&raquo; <a href="index.php?pg=jobview&id=<?php echo $jobs['id'];?>">View</a><br />
				&raquo; <a href="index.php?pg=jobedit&id=<?php echo $jobs['id'];?>">Edit</a><br />
<!--				&raquo; <a href="index.php?pg=pushtozoho&id=<?php echo $jobs['id'];?>">Push to Zoho</a><br />					-->
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