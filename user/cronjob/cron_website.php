<?php 
	set_time_limit(600);
	require_once '../../class/xml.class.php';
	require_once '../../class/class.user.php';
	function starseperator($string) 
	{
		$returnString = "";
		$html123 = html_entity_decode($string, ENT_QUOTES, 'ISO-8859-15');
		$html123 = explode('•', $html123);
		$arraySize = sizeof($html123);
		if(sizeof($html123)>1){
		//	echo '<ul>';
			foreach($html123 as $htm123){
				$returnString .= '<li>'.$htm123."</li>";
			}	
		//		echo '</ul>';
		}else{
			$returnString .= $html123[0];
		}
		return $returnString;
	} 
	
	$user = new user();		
	// $getAllZohoId = $user->allzohosettings();
    
		//	foreach($getAllZohoId as $zohoUser){
			//$row = $user->refreshFieldsforCron($zohoUser['logonid']);
			//$settings = $user->zohosettings($zohoUser['logonid']);
			
			$row = $user->refreshFieldsforCron(16);
			$settings = $user->zohosettings(16);
			
			
			// #########################################  //
			$result = $user->selectJobs(16);
		 $jobOpenings = '<jobopenings>';
		
		 if($result){
		 foreach ($result as $res){
		 	
		 	$jobFieldbyRandID = $user->selectJobField($res['jobrandid'],16); 
		 	
		 	$jobtitleField = $user->getJobTitlefromJobField($res['jobrandid'],16);
		 	$jobOpenings .='<jobs id="'.$res['value'].'" title="'.$jobtitleField.'">';
		 	
		 	foreach($jobFieldbyRandID as $jobField){
		 		//echo $jobField['iswebsite'].'<br />';
		 		if($jobField['iswebsite']==1){
			 		$jobOpenings .='<field>';
			 		$jobOpenings .='<label>'.$jobField['fieldname'].'</label>';
			 		$jobOpenings .='<description>'.$jobField['value'].'</description>';		 		
			 		$jobOpenings .='</field>';
		 		}
		 	}		 	
		 	$jobOpenings .='</jobs>';
		 	
		 }
		 }
		 $jobOpenings .= '</jobopenings>';
		 
		 $candidates = '<candidateform>';
		 
		 $candidateField = $user->selectCandidateField(16);
		 if($candidateField){
		 foreach($candidateField as $field){
		 	 $candidates .= '<field type="'.$field['fieldtype'].'" maxlength="'.$field['maxlength'].'" mandatory="'.$field['ismandatory'].'">';
		 	 $candidates .= '<label>';
		 	 $candidates .= $field['fieldtype'];
		 	 $candidates .= '</label>';
		 	 $candidates .= '</field>';
		 }
		 }
		$candidates .= '</candidateform>';
		 
		 
		$file= fopen("../xml/plugin_16.xml", "w");
		
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
		/*
		if(fwrite($file, $xml)){
			//echo 'File written <br /><hr />';
		}else{
			echo 'File can\'t be write <br /><hr />';
		}
		*/
		fclose($file);
		
		// ############################################   //
		// }
	
		/* test mail function  */	
			
	
	?>
	
	
	