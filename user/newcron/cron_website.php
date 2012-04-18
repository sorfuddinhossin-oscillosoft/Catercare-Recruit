<?php 
	set_time_limit(600);
	require_once '../../class/xml.class.php';
	require_once '../../class/class.user.php';
	require_once '../../class/dbclass.php';
	
	
		$shDB = new sh_DB();
		$user = new user();
		$xml = new Xml2Assoc();
		
		$zohoCredentials = $user->zohosettings(1);	
		 
		$jobSelectBy = array(
							'job_opening_status' =>'In-progress'
							);
		$JobsList = $shDB->selectOnMultipleCondition($jobSelectBy,'jobs_posted','open_date','DESC');
		if($JobsList){
			 $jobOpenings = '<jobopenings>';
			 	foreach ($JobsList as $jList){
			 		if(($jList['published_in']=='Website')||($jList['published_in']=='Website and SEEK')){
			 		$jobOpenings .= '<jobs id="'.$jList['zohoid'].'">';
			 		
			 		
			 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>JOBOPENINGID</label>';
				 		$jobOpenings .='<description>'.$jList['zohoid'].'</description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>Date opened</label>';
				 		$jobOpenings .='<description>'.$jList['open_date'].'</description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>Target date</label>';
				 		$jobOpenings .='<description>'.$jList['target_date'].'</description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>Job type</label>';
				 		$jobOpenings .='<description>'.$jList['job_type'].'</description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>SEEK Job Type</label>';
				 		$jobOpenings .='<description>'.$jList['seek_job_type'].'</description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>Number of positions</label>';
				 		$jobOpenings .='<description>'.$jList['no_of_position'].'</description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>Department</label>';
				 		$jobOpenings .='<description>'.$jList['department'].'</description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>SEEK Description</label>';
				 		$jobOpenings .='<description><![CDATA['.$jList['job_description'].']]></description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>Salary Range</label>';
				 		$jobOpenings .='<description>'.$jList['salary_range'].'</description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>Posting title</label>';
				 		$jobOpenings .='<description><![CDATA['.$jList['job_title'].']]></description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>Introduction</label>';
				 		$jobOpenings .='<description><![CDATA['.$jList['introduction'].']]></description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>Posted on</label>';
				 		$jobOpenings .='<description>'.$jList['posted_on'].'</description>';		 		
				 		$jobOpenings .='</field>';
				 		
				 		$jobOpenings .='<field>';
				 		$jobOpenings .='<label>State</label>';
				 		$jobOpenings .='<description>'.$jList['state'].'</description>';		 		
				 		$jobOpenings .='</field>';	 		
			 		
			 		$jobOpenings .='</jobs>';
			 	}
			 	}
			  $jobOpenings .= '</jobopenings>';
		}
		
		
		$file= fopen("xml/plugin.xml", "w");
		
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$xml .= '<plugin>';
			$xml .= '<settings>';
				$xml .= '<api>';
					$xml .= $zohoCredentials['api'];
				$xml .= '</api>';
				$xml .= '<ticket>';
					$xml .= $zohoCredentials['ticket'];
				$xml .= '</ticket>';
			$xml .= '</settings>';	
			$xml .= $jobOpenings;		
		$xml .= '</plugin>';
		
		
		fwrite($file, $xml);
	
	?>
	
	
	