<div id="userRightDiv">
	<h1>XML Generation</h1>
	<div class="userContent">
	<?php 
		$restult = $user->selectFieldByComId();
		$settings = $user->zohosettings();
		//var_dump($settings);
		
		 $result = $user->selectJobs($_SESSION['userid']);
		 $jobOpenings = '<jobopenings>';
		// var_dump($result);
		 foreach ($result as $res){
		 	$jobFieldbyRandID = $user->selectJobField($res['jobrandid']); 
		 	$jobtitleField = $user->getJobTitlefromJobField($res['jobrandid']);
		 	$jobOpenings .='<jobs id="'.$res['value'].'" title="'.$jobtitleField.'">';
		 	
		 	foreach($jobFieldbyRandID as $jobField){
		 		echo $jobField['iswebsite'].'<br />';
		 		if($jobField['iswebsite']==1){
			 		$jobOpenings .='<field>';
			 		$jobOpenings .='<label>'.$jobField['fieldname'].'</label>';
			 		$jobOpenings .='<description>'.$jobField['value'].'</description>';		 		
			 		$jobOpenings .='</field>';
		 		}
		 	}		 	
		 	$jobOpenings .='</jobs>';
		 	
		 }
		 
		 $jobOpenings .= '</jobopenings>';
		 
		 $candidates = '<candidateform>';
		 
		 $candidateField = $user->selectCandidateField();
		 foreach($candidateField as $field){
		 	 $candidates .= '<field type="'.$field['fieldtype'].'" maxlength="'.$field['maxlength'].'" mandatory="'.$field['ismandatory'].'">';
		 	 $candidates .= '<label>';
		 	 $candidates .= $field['fieldtype'];
		 	 $candidates .= '</label>';
		 	 $candidates .= '</field>';
		 }

		 $candidates .= '</candidateform>';
		 
		 	
		$file= fopen("xml/plugin_".$_SESSION['userid'].".xml", "w");
		
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
		?>
		
	<script>
		alert('<?php echo $xml;?>');
	</script>
	
	</div>
</div>