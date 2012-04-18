	<?php 
		include '../../class/class.user.php';
		$baseurl = 'http://www.oscillosoft.com/jobs/';
		$user = new user();
		
		$userall = $user->getAllUser();
		foreach($userall as $userinfo){
		//$restult = $user->selectFieldByComId($userinfo['userid']);
		$settings = $user->zohosettings($userinfo['userid']);
		//var_dump($userinfo['userid']);
		 $res = $user->selectJobs($userinfo['userid']);
		
		$res = $res[0];
		 if($res!=Null){
		 
		 $jobOpenings = '';
		 $jobOpenings = '<jobopenings>';
		 
		 
		
		 	$jobFieldbyRandID = $user->selectJobField($res['jobrandid'],$userinfo['userid']); 
		 	
		 	$jobtitleField = $user->getJobTitlefromJobField($res['jobrandid'],$userinfo['userid']);
		 	
		 	$jobOpenings .='<jobs id="'.$res['value'].'" title="'.$jobtitleField.'">';
		 	
		 	foreach($jobFieldbyRandID as $jobField){
		 		if($jobField['iswebsite']==1){
			 		$jobOpenings .='<field>';
			 		$jobOpenings .='<label>'.$jobField['fieldname'].'</label>';
			 		$jobOpenings .='<description>'.$jobField['value'].'</description>';		 		
			 		$jobOpenings .='</field>';
		 		}
		 	}		 	
		 	$jobOpenings .='</jobs>';
		 	
		 
		 
		 $jobOpenings .= '</jobopenings>';
		 $candidates = '<candidateform>';
		 
		 $candidateField = $user->selectCandidateField($userinfo['userid']);
		 foreach($candidateField as $field){
		 	 $candidates .= '<field type="'.$field['fieldtype'].'" maxlength="'.$field['maxlength'].'" mandatory="'.$field['ismandatory'].'">';
		 	 $candidates .= '<label>';
		 	 $candidates .= $field['fieldtype'];
		 	 $candidates .= '</label>';
		 	 $candidates .= '</field>';
		 }

		 $candidates .= '</candidateform>';
		 
		 	
		$file= fopen("../xml/plugin_".$userinfo['userid'].".xml", "w");
		
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$xml .= '<plugin>';
			$xml .= '<settings>';
				$xml .= '<api>';
					$xml .= $settings['api'];
				$xml .= '</api>';
				$xml .= '<ticket>';
					$xml .= $settings['ticket'];
				$xml .= '</ticket>';
			$xml .= '</settings>';
			$xml .= $jobOpenings;		
			$xml .= $candidates;
		$xml .= '</plugin>';
		fwrite($file, $xml);
		fclose($file);
		 }
		}
		
		?>
