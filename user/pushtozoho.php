<?php
$jobid = array(
							'id' => $_REQUEST['id']
							);
						$Jobs = $shDB->selectOnMultipleCondition($jobid,'`jobs_posted`');
						$Jobs = $Jobs[0];
	if($Jobs['publish_in_website']==1){
		$publishedinwebsite = true;
	}else{
		$publishedinwebsite = false;
	}
	
	$zohoId = $Jobs['zohoid'];
	$string = '<JobOpenings>';
	$string .= '<row no="1">';
	$string .= '<FL val="Published in website">'.$publishedinwebsite.'</FL>';
	$string .= '<FL val="Date opened">'.date('d-m-Y',strtotime($Jobs['open_date'])).'</FL>';
	$string .= '<FL val="Target date">'.date('d-m-Y',strtotime($Jobs['target_date'])).'</FL>';
	$string .= '<FL val="Job opening status">'.$Jobs['job_opening_status'].'</FL>';
	$string .= '<FL val="Job type">'.$Jobs['job_type'].'</FL>';
	$string .= '<FL val="SEEK Job Type">'.$Jobs['seek_job_type'].'</FL>';
	$string .= '<FL val="Number of positions">'.$Jobs['no_of_position'].'</FL>';
	// $string .= '<FL val="Department">'.$Jobs['department'].'</FL>';
	
	// $string .= '<FL val="Hiring manager">'.$Jobs['hiring_manager'].'</FL>';
	$string .= '<FL val="Introduction">'.$Jobs['introduction'].'</FL>';
	$string .= '<FL val="SEEK Description"><![CDATA['.$Jobs['job_description'].']]></FL>';
	$string .= '<FL val="Classification">'.$Jobs['seek_classification'].'</FL>';
	$string .= '<FL val="Sub Classification">'.$Jobs['seek_sub_classification'].'</FL>';
	$string .= '<FL val="Published In">'.$Jobs['published_in'].'</FL>';	
	$string .= '<FL val="Selling Point 1">'.$Jobs['selling_point_one'].'</FL>';
	$string .= '<FL val="Selling Point 2">'.$Jobs['selling_point_two'].'</FL>';
	$string .= '<FL val="Selling Point 3">'.$Jobs['selling_point_three'].'</FL>';
	
	$string .= '<FL val="Salary Range">'.$Jobs['salary_range'].'</FL>';
	$string .= '<FL val="Additional Salary Text">'.$Jobs['additional_sal_text'].'</FL>';
	
	$string .= '<FL val="Posting title">'.$Jobs['job_title'].'</FL>';	
	$string .= '<FL val="State">'.$Jobs['state'].'</FL>';
	$string .= '<FL val="SEEK Location">'.$Jobs['seek_location'].'</FL>';
	$string .= '<FL val="Country">'.$Jobs['country'].'</FL>';
	$string .= '<FL val="Posted on">'.date('d-m-Y',strtotime($Jobs['posted_on'])).'</FL>';
	
	$string .= '</row>';
	$string .= '</JobOpenings>';	
	
	$postData = array(
       'xmlData' => $string
    );
    
    $crmCredential = $user->zohosettings(1);
   
   $api = $crmCredential['api'];
     $ticket = $crmCredential['ticket'];
    
   //  $url = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/addRecords?apikey='.$recruitAPI.'&ticket='.$newTicket;
   if($zohoId==''){
    $url = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/addRecords?apikey='.$api.'&ticket='.$ticket;
    $success = $myCurl->post($url, $postData);
	
	$successResult = $xml->parseString($success, false);
	
   }else{
   	 $url = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/updateRecords?apikey='.$api.'&ticket='.$ticket.'&id='.$zohoId;
   	 $success = $myCurl->post($url, $postData);
	
	$successResult = $xml->parseString($success, false);
	
   }
	
	
	$result = $successResult['response'][0]['result']['recorddetail']['FL'][0][0];
	var_dump($result);
?>