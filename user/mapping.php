<div id="userRightDiv">
	<h1>Field Mapping <span>(Manage job fields order, group, css and validation)</span></h1>
	<div class="userContent">
		<h2>Zoho Recruit Fields</h2>
		<a class="updatexml" href="index.php?pg=xmlgeneration"></a>
		<a class="refresh" href="index.php?pg=xmlgeneration&refresh=1">Refresh</a>
		<p class="importantnotice">
		This following Fields are directly coming from Zoho using your settings. Now you can manage the Order,Group name and Validation here. Then click Flush XML so that it can be update to your website accordingly. 
		</p>
	
		<?php if(isset($_REQUEST['refresh'])){			
				//$row = $user->refreshFields();
				echo $row;
				
		}?>
		
		<?php if(isset($_REQUEST['formfield'])){
			
				//$row = $user->refreshcandidateFormFields();
				//echo $row;
				
		}?>
		
		
		<?php
			 $result = $user->selectJobs($_SESSION['userid']);
			 if(!isset($_REQUEST['jobid'])){
			 $defaultJobId = $result[0]['jobrandid'];
			 }else{
			 	$defaultJobId = $_REQUEST['jobid'];
			 }
			
		
		
		?>
		<br />
		<div  id="info"></div>
		<div style="width:762px;height:25px;">
			<ul id="itemTab">
				<li id="jobopeningslist" class="active">Job Openings</li>
				<li id="candidateformlist" style="margin-left:2px;" class="candidate">Candidate Form</li>
				<li class="listofjob" id="listofjob">
					<strong>Select a job</strong>
					<?php 
					 echo '<select id="jobId">';
					 foreach ($result as $res){	
					 	$jobtitleField = $user->getJobTitlefromJobField($res['jobrandid']);	 	
						 //echo $res['jobrandid'].'='.$res['value'].' '.$jobtitleField.'<br />';
						 if($defaultJobId==$res['jobrandid']){
						 echo '<option value="'.$res['jobrandid'].'" selected>'.$jobtitleField.'</option>';
						 }else{
						 	echo '<option value="'.$res['jobrandid'].'">'.$jobtitleField.'</option>';
						 }
					 }
					 echo '</select>';
			 		?>
				</li>
			</ul>
		</div>
		<ul class="mapping" id="dataFieldMap">
			<li class="header">
				<div class="map_field_head">
					<div class="fieldname">Field Name</div>
					<div class="groupname">&nbsp;</div>
					<div class="fieldtype">&nbsp;</div>
					<div class="isdisplay">Is Display?</div>
					<div class="ismandatory">&nbsp;</div>
				</div>				
			</li>
			<?php 
			$jobFieldbyRandID = $user->selectJobField($defaultJobId); 
				
			?>
			<?php foreach($jobFieldbyRandID as $field){?>
			<li id="listItem_<?=$field['id'];?>">
				<div class="map_field_body">
					<div class="handler"></div>
					<div class="fieldname">&nbsp;<?=$field['fieldname'];?></div>
					<div class="groupname">&nbsp;</div>
					<div class="fieldtype">&nbsp;</div>
					<div class="isdisplay">
					<?php
						if($field['iswebsite']==0){ 
					?>
						<a href="<?=$field['id'];?>" id="display<?=$field['id'];?>" class="displayNo" title="<?=$field['id'];?>"></a>
						<?php }else{?>
						<a href="<?=$field['id'];?>" id="display<?=$field['id'];?>" class="displayYes" title="<?=$field['id'];?>"></a>
						<?php }?>
					</div>
					<div class="ismandatory">
						&nbsp;
					</div>
				</div>		
			</li>
				<?php }?>
		</ul>
		
		<ul class="mapping" id="candidateFieldMap" style="display:none">
			<li class="header">
				<div class="map_field_head">
					<div class="fieldname">Field Name</div>
					<div class="groupname">Group Name</div>
					<div class="fieldtype">Field Type</div>
					<div class="isdisplay">Is Display?</div>
					<div class="ismandatory">Is Mandatory?</div>
				</div>				
			</li>
			<?php 
			$candidateField = $user->selectCandidateField(); 
				
			?>
			<?php foreach($candidateField as $field){
				
			if($field['fieldtype']!='AutoIncrement')
			{
				if($field['fieldtype']!='SingleLookup'){
			?>
		
			<li id="listItem_<?=$field['id'];?>">
				<div class="map_field_body">
					<div class="handler"></div>
					<div class="fieldname">&nbsp;<?=$field['fieldname'];?></div>
					<div class="groupname">&nbsp;<?=$field['groupname'];?></div>
					<div class="fieldtype">&nbsp;<?=$field['fieldtype'];?></div>
					<div class="isdisplay">
					<?php
						if($field['iswebsite']==0){ 
					?>
						<a href="<?=$field['id'];?>" id="display<?=$field['id'];?>" class="displayNo" title="<?=$field['id'];?>"></a>
						<?php }else{?>
						<a href="<?=$field['id'];?>" id="display<?=$field['id'];?>" class="displayYes" title="<?=$field['id'];?>"></a>
						<?php }?>
					</div>
					<div class="ismandatory">
				<?php
						if($field['ismandatory']==0){ 
					?>
						<a href="<?=$field['id'];?>" id="mandatory<?=$field['id'];?>" class="mandatoryNo"  title="<?=$field['id'];?>"></a>
							<?php }else{?>
							<a href="<?=$field['id'];?>" id="mandatory<?=$field['id'];?>" class="mandatoryYes"  title="<?=$field['id'];?>"></a>
							<?php }?>
					</div>
				</div>		
			</li>
			<?php 
			}
			}
			}?>
		</ul>
		<br /><br />
	</div>
</div>