<?php 
						$jobid = array(
							'id' => $_REQUEST['id']
							);
						$Jobs = $shDB->selectOnMultipleCondition($jobid,'`jobs_posted`');
						$Jobs = $Jobs[0];
						
?>
<div id="userRightDiv">
	<h1>Job Details <span></span></h1>
	<ul class="settingsList">		
		<li><a href="index.php?pg=jobedit&id=<?php echo $_REQUEST['id']?>">Edit the Job</a></li>
		
	</ul>
	<div class="userContent">
		
		<strong class="head">Posting title</strong><br />
		<span class="description"><?php echo $Jobs['job_title'];?></span><br />
		<strong class="head">Open Date</strong><br />
		<span class="description"><?php echo date('d-m-Y',strtotime($Jobs['open_date']));?></span><br />
		<strong class="head">Target Date</strong><br />
		<span class="description"><?php echo date('d-m-Y',strtotime($Jobs['target_date']));?></span><br />
		<strong class="head">Introduction</strong><br />
		<span class="description"><?php echo $Jobs['introduction'];?></span><br />
		<strong class="head">Job Description</strong><br />
		<span class="description"><?php echo $Jobs['job_description'];?></span><br />
		<strong class="head">Job Opening Status</strong><br />
		<span class="description"><?php echo $Jobs['job_opening_status'];?></span><br />
		<strong class="head">Job Type</strong><br />
		<span class="description"><?php echo $Jobs['job_type'];?></span><br />
		<strong class="head">SEEK Job Type</strong><br />
		<span class="description"><?php echo $Jobs['seek_job_type'];?></span><br />
		<strong class="head">No of Position</strong><br />
		<span class="description"><?php echo $Jobs['no_of_position'];?></span><br />
		
		<strong class="head">Published In</strong><br />
		<span class="description"><?php echo $Jobs['published_in'];?></span><br />
		<strong class="head">Selling point one</strong><br />
		<span class="description"><?php echo $Jobs['selling_point_one'];?></span><br />
		<strong class="head">Selling point two</strong><br />
		<span class="description"><?php echo $Jobs['selling_point_two'];?></span><br />
		<strong class="head">Selling point three</strong><br />
		<span class="description"><?php echo $Jobs['selling_point_three'];?></span><br />
		<strong class="head">Salary Range</strong><br />
		<span class="description"><?php echo $Jobs['salary_range'];?></span><br />
		<strong class="head">Additional Salary Text</strong><br />
		<span class="description"><?php echo $Jobs['additional_sal_text'];?></span><br />
		<strong class="head">Job Opening Id</strong><br />
		<span class="description"><?php echo $Jobs['job_opening_id'];?></span><br />
		<strong class="head">State</strong><br />
		<span class="description"><?php echo $Jobs['state'];?></span><br />
		<strong class="head">Seek Location</strong><br />
		<span class="description"><?php echo $Jobs['seek_location'];?></span><br />		
		<strong class="head">Seek Classification</strong><br />
		<span class="description"><?php echo $Jobs['seek_classification'];?></span><br />
		<strong class="head">Seek Sub-Classification</strong><br />
		<span class="description"><?php echo $Jobs['seek_sub_classification'];?></span><br />
		<strong class="head">Country</strong><br />
		<span class="description"><?php echo $Jobs['country'];?></span><br />
		<strong class="head">Posted On</strong><br />
		<span class="description"><?php echo date('d-m-Y',strtotime($Jobs['posted_on']));?></span><br />
		
		<!-- 
		<?php if($Jobs['publish_in_website']!==''){?>
		<strong class="head">publish_in_website</strong><br />
		<span class="description"><?php echo $Jobs['publish_in_website'];?></span><br />
		<?php } ?>
		
		-->
		<input type="button" value="Back to List">
		
		
		
		<br /><br />
	</div>
</div>