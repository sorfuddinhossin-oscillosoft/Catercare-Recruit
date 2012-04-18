<?php 
	set_time_limit(600);
	require_once '../../class/xml.class.php';
	require_once '../../class/class.user.php';
	require_once '../../class/dbclass.php';
	$shDB = new sh_DB();
	$user = new user();
	$noOfRecords = 200;
	if($comId==''){ 
	 	$comId = $_SESSION['userid'];
	 }
	 $zohoCredentials = $user->zohosettings(1);	
	
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/getRecords?apikey='.$zohoCredentials['api'].'&ticket='.$zohoCredentials['ticket'].'&sortColumnString=Date%20opened&sortOrderString=desc&fromIndex=101&toIndex=200';
	$xml = new Xml2Assoc();
	
	$allJobs = $xml->parseFile($apiRequestURL, false);
	$allJobs = $allJobs['response'][0]['result']['JobOpenings']['row'];
	
	
	if($allJobs){
	foreach ($allJobs as $value) {
				
		$zohoid = '';
		$publishedinwebsite = '';
		$Modifiedby = '';
		$Modifiedtime = '';
		$Dateopened = '';
		$Targetdate = '';
		$Jobopeningstatus = '';
		$Jobtype = '';
		$SEEKJobType = '';
		$Numberofpositions = '';
		$Department = '';
		$Hiringmanager = '';
		$SEEKDescription = '';
		$Classification = '';
		$SubClassification = '';
		$PublishedIn = '';
		$SellingPoint1 = '';
		$SellingPoint2 = '';
		$SellingPoint3 = '';
		$SalaryRange = '';
		$AdditionalSalaryText = '';
		$JobopeningID = '';
		$Postingtitle = '';
		$Introduction  = '';
		$State  = '';
		$SEEKLocation = '';
		$Country = '';
		$Postedon = '';
		$Createdby = '';
		$Assignedrecruiter = '';
		
		
		
		 foreach($value['FL'] as $field){
		 
		 	if($field['val'] == 'JOBOPENINGID'){
		 		$zohoid = $field[0];
		 	}
		 
		 	if($field['val'] == 'Assigned recruiter'){
		 		$Assignedrecruiter = $field[0];
		 	}
		 	
		 if($field['val'] == 'Published in website'){
		 		$Publishedinwebsite = $field[0];
		 		if($Publishedinwebsite=='true'){
		 			$Publishedinwebsite = 1;
		 		}else{
		 			$Publishedinwebsite = 0;
		 		}
		 	}
		 if($field['val'] == 'Modified by'){
		 		$Modifiedby = $field[0];
		 	}
		 if($field['val'] == 'Modified time'){
		 		$Modifiedtime = $field[0];
		 	}
		 if($field['val'] == 'Date opened'){
		 		$Dateopened = $field[0];
		 	}
		 if($field['val'] == 'Target date'){
		 		$Targetdate = $field[0];
		 	}
		 if($field['val'] == 'Job opening status'){
		 		$Jobopeningstatus = $field[0];
		 	}
		 if($field['val'] == 'Job type'){
		 		$Jobtype = $field[0];
		 	}
		 if($field['val'] == 'SEEK Job Type'){
		 		$SEEKJobType = $field[0];
		 	}
		 if($field['val'] == 'Number of positions'){
		 		$Numberofpositions = $field[0];
		 	}
		 if($field['val'] == 'Hiring manager'){
		 		$Hiringmanager  = $field[0];
		 	}
		 if($field['val'] == 'SEEK Description'){
		 		$SEEKDescription = $field[0];
		 	}
		 if($field['val'] == 'Classification'){
		 		$Classification = $field[0];
		 	}
		 if($field['val'] == 'Sub Classification'){
		 		$SubClassification = $field[0];
		 	}
		 if($field['val'] == 'Published In'){
		 		$PublishedIn = $field[0];
		 	}
		 if($field['val'] == 'Selling Point 1'){
		 		$SellingPoint1 = $field[0];
		 	}
		 if($field['val'] == 'Selling Point 2'){
		 		$SellingPoint2 = $field[0];
		 	}
		 if($field['val'] == 'Selling Point 3'){
		 		$SellingPoint3 = $field[0];
		 	}
		 if($field['val'] == 'Salary Range'){
		 		$SalaryRange = $field[0];
		 	}
		 if($field['val'] == 'Additional Salary Text'){
		 		$AdditionalSalaryText = $field[0];
		 	}
		  if($field['val'] == 'Job opening ID'){
		 		$JobopeningID = $field[0];
		 	}
		  if($field['val'] == 'Posting title'){
		 		$Postingtitle = $field[0];
		 	}
		 if($field['val'] == 'Introduction'){
		 		$Introduction  = $field[0];
		 	}
		 if($field['val'] == 'State'){
		 		$State = $field[0];
		 	}
		 if($field['val'] == 'SEEK Location'){
		 		$SEEKLocation = $field[0];
		 	}
		 if($field['val'] == 'Country'){
		 		$Country = $field[0];
		 	}
		 if($field['val'] == 'Posted on'){
		 		$Postedon = $field[0];
		 	}
		 if($field['val'] == 'Created by'){
		 		$Createdby = $field[0];
		 	}
		  if($field['val'] == 'Department'){
		 		$Department = $field[0];
		 	}
		 	
		 	// $result = $this->insertFieldtoDB($comId,$rand,trim($field['val']),trim($field[0]));
		 	// echo $field['val'].' = '.$field[0].'<br />';
		 }
		 
		 $seekJobPosted = array(		
			'job_title' => $Postingtitle,
			'open_date' => date('Y-m-d',strtotime($Dateopened)),
			'target_date' => date('Y-m-d',strtotime($Targetdate)),
			'introduction' =>$Introduction,
			'job_description' => $SEEKDescription,
			'job_opening_status' => $Jobopeningstatus,
			'job_type' => $Jobtype,
			'seek_job_type' => $SEEKJobType,
			'no_of_position' => $Numberofpositions,
			'department' => $Department,
			'hiring_manager' => $Hiringmanager,
			'assigned_recruiter' => $Assignedrecruiter,
			'published_in' => $PublishedIn,
			'selling_point_one' =>$SellingPoint1,
			'selling_point_two' => $SellingPoint2,
			'selling_point_three' => $SellingPoint3,
			'salary_range' => $SalaryRange,
			'additional_sal_text' => $AdditionalSalaryText,
			'job_opening_id' => $JobopeningID,
			'state' => $State,
			'seek_location' => $SEEKLocation,
			'seek_classification' => $Classification,
			'seek_sub_classification' => $SubClassification,
			'country' => $Country,
			'posted_on' => date('Y-m-d',strtotime($Postedon)),
			'publish_in_website' => $Publishedinwebsite,
			'zohoid' => $zohoid
			);

			
			//check if already exist in local db
			
				$jobid = array(
							'zohoid' => $zohoid
							);
						$JobsExist = $shDB->selectOnMultipleCondition($jobid,'jobs_posted');
						
				if($JobsExist){
					$Jobs = $JobsExist[0]['id'];
					$jobId = $shDB->update($seekJobPosted,$Jobs,'jobs_posted');
				}else{
					$jobId = $shDB->insert($seekJobPosted,'jobs_posted');
				}
			var_dump('Posted returned job id # '.$jobId.'<br />');
			echo '<hr />';
		}
	}
?>
	
	
	