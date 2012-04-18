<?php 
	function pushtozoho($id = ''){
	if($id == ''){return false;}
	require_once 'xml.class.php';
	require_once 'class.user.php';
	require_once 'mycurl.php';
	require_once 'dbclass.php';
	$shDB = new sh_DB();
	$user = new user();
	$myCurl = new CURL();
	$jobid = array(
							'id' => $id
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
	if($result){
		return $result;
	}else{
		return false;
	}
	}
	
	function mailsendpassword($name,$to,$pass){
		
			$from = 'LEON HAYES <leon@catercareservices.com.au';
						
			
			
			$subject = 'Recruit Plugins : Registration Successful';
			
					
			$message = '<html><body style="background: #8C1818;font-size:8pt;font-family:tahoma,arial;padding:20px;">';
			$message .= '<img src="http://www.catercare.com.au/sitecc/wp-content/themes/CCG/images/homelogo.gif" height="89" alt="Cater Care" />';
			$message .= '<table width="80%" rules="" cellpadding="0" cellspacing="0">';
			$message .= '<tr>';
			$message .= '<td style="background-position:top left;background-repeat:no-repeat;width:14px;height:14px"></td>';
			$message .= '<td style="background: #fff;border-top:1px solid #6E9091"></td>';
			$message .= '<td style="background-position:top right;background-repeat:no-repeat;width:14px;height:14px"></td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td style="background: #fff;"></td>';
			$message .= '<td style="background: #fff;font-size:11px;line-height:2.1em;">';
			$message .= '<table rules="" style="border-color: #666;" cellpadding="10">';
			$message .= '<tr ><td style="width:100px;font-size:11px;">Subject:</td><td style="font-size:11px;"><strong>'.$subject.'</strong> </td></tr>';
			$message .= '<tr ><td colspan="2" style="font-size:11px;">Dear '.$name.'<br />Your are registered for catercare recruit plugins user. Here is your login credentials - </td></tr>';
			$message .= '<tr ><td style="font-size:11px;">User Id:</td><td style="font-size:11px;"><strong>'.$to.'</strong> </td></tr>';
			$message .= '<tr ><td style="font-size:11px;">Password:</td><td style="font-size:11px;"><strong>'.$pass.'</strong> </td></tr>';
			$message .= '<tr ><td style="font-size:11px;">Login URL:</td><td style="font-size:11px;"><strong><a href="http://recruit.catercareconnect.com">http://recruit.catercareconnect.com/</a></strong> </td></tr>';			
			$message .= '</table>';			 
			$message .= '</td>';
			$message .= '<td style=\'background: #fff;\'></td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td style="background-repeat:no-repeat;background-position:bottom left;width:14px;height:14px"></td>';
			$message .= '<td style=\'background: #fff;\'></td>';
			$message .= '<td style="background-repeat:no-repeat;background-position:bottom right;width:14px;height:14px"></td>';
			$message .= '</tr>';
			$message .= '</table><br />';
			
			$message .= '<p style="color:black;font-size:10px;">Copyright 2011 &copy; Oscillosoft. All rights reserved. </p>';
			$message .= '</body>';
			
			
			$headers = "From: " . $from . "\r\n";
			$headers .= "Reply-To: ". $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
            if (mail($to, $subject, $message, $headers)) {
              return true;
            } else {
              return false;
            }
            
            // DON'T BOTHER CONTINUING TO THE HTML...
            die();
	}
	
	
	function passwordreset($to,$pass){
		
			$from = 'LEON HAYES <leon@catercareservices.com.au';
						
			
			
			$subject = 'Password Reset : Catercare Recruit Integration';
			
					
			$message = '<html><body style="background: #8C1818;font-size:8pt;font-family:tahoma,arial;padding:20px;">';
			$message .= '<img src="http://www.catercare.com.au/sitecc/wp-content/themes/CCG/images/homelogo.gif" height="89" alt="Cater Care" />';
			$message .= '<table width="80%" rules="" cellpadding="0" cellspacing="0">';
			$message .= '<tr>';
			$message .= '<td style="background-position:top left;background-repeat:no-repeat;width:14px;height:14px"></td>';
			$message .= '<td style="background: #fff;border-top:1px solid #6E9091"></td>';
			$message .= '<td style="background-position:top right;background-repeat:no-repeat;width:14px;height:14px"></td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td style="background: #fff;"></td>';
			$message .= '<td style="background: #fff;font-size:11px;line-height:2.1em;">';
			$message .= '<table rules="" style="border-color: #666;" cellpadding="10">';
			$message .= '<tr ><td style="width:100px;font-size:11px;">Subject:</td><td style="font-size:11px;"><strong>'.$subject.'</strong> </td></tr>';
			$message .= '<tr ><td colspan="2" style="font-size:11px;">Dear '.$name.'<br />Your password has changed to following - </td></tr>';
			$message .= '<tr ><td style="font-size:11px;">User Id:</td><td style="font-size:11px;"><strong>'.$to.'</strong> </td></tr>';
			$message .= '<tr ><td style="font-size:11px;">Password:</td><td style="font-size:11px;"><strong>'.$pass.'</strong> </td></tr>';
			$message .= '<tr ><td style="font-size:11px;">Login URL:</td><td style="font-size:11px;"><strong><a href="http://recruit.catercareconnect.com">http://recruit.catercareconnect.com</a></strong> </td></tr>';			
			$message .= '</table>';			 
			$message .= '</td>';
			$message .= '<td style=\'background: #fff;\'></td>';
			$message .= '</tr>';
			$message .= '<tr>';
			$message .= '<td style="background-repeat:no-repeat;background-position:bottom left;width:14px;height:14px"></td>';
			$message .= '<td style=\'background: #fff;\'></td>';
			$message .= '<td style="background-repeat:no-repeat;background-position:bottom right;width:14px;height:14px"></td>';
			$message .= '</tr>';
			$message .= '</table><br />';
			
			$message .= '<p style="color:black;font-size:10px;">Copyright 2011 &copy; Oscillosoft. All rights reserved. </p>';
			$message .= '</body>';
			
			
			$headers = "From: " . $from . "\r\n";
			$headers .= "Reply-To: ". $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
            if (mail($to, $subject, $message, $headers)) {
              return true;
            } else {
              return false;
            }
            
            // DON'T BOTHER CONTINUING TO THE HTML...
            die();
	}
	
	
	function log_report($jobid='',$optType=''){
	require_once 'xml.class.php';
	require_once 'class.user.php';
	
	require_once 'dbclass.php';
	$shDB = new sh_DB();
	$user = new user();
	
	
		if($jobid=='') return false;
		
	$jobidselect = array(
							'id' => $jobid
							);
						$Jobs = $shDB->selectOnMultipleCondition($jobidselect,'`jobs_posted`');
						$Jobs = $Jobs[0];
	if($Jobs['publish_in_website']==1){
		$publishedinWebsite = 1;
	}else{
		$publishedinWebsite = 0;
	}

$seekJobPosted = array(		
	'jobs_table_id' => $jobid,	
	'job_title' => $Jobs['job_title'],
	'open_date' => $Jobs['open_date'],
	'target_date' => $Jobs['target_date'],
	'introduction' => $Jobs['introduction'],
	'job_description' => $Jobs['job_description'],
	'job_opening_status' => $Jobs['job_opening_status'],
	'job_type' => $Jobs['job_type'],
	'seek_job_type' => $Jobs['seek_job_type'],
	'no_of_position' => $Jobs['no_of_position'],
	'published_in' => $Jobs['published_in'],
	'selling_point_one' => $Jobs['selling_point_one'],
	'selling_point_two' => $Jobs['selling_point_two'],
	'selling_point_three' => $Jobs['selling_point_three'],
	'salary_range' => $Jobs['salary_range'],
	'additional_sal_text' => $Jobs['additional_sal_text'],
	'job_opening_id' =>$Jobs['job_opening_id'],
	'state' => $Jobs['state'],
	'seek_location' => $Jobs['seek_location'],
	'seek_classification' => $Jobs['seek_classification'],
	'seek_sub_classification' => $Jobs['seek_sub_classification'],
	'country' => $Jobs['country'],
	'posted_on' => $Jobs['posted_on'],
	'publish_in_website' => $Jobs['publish_in_website'],
	'zohoid' => $Jobs['zohoid'],
	'opt_type' => $optType,
	'ip' => get_ip_address(),
	'logonid' => $_SESSION['userid'],
	'time' => date("Y-m-d H:i:s")
);		

	$jobId = $shDB->insert($seekJobPosted,'`job_log_report`');
	if($jobId){return $jobId;}else{return false;}
	}
	
	function get_ip_address() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }
}

	function namebyId($logonId = ''){
			require_once 'dbclass.php';
			$shDB = new sh_DB();
		if($logonId=='') return false;
		$userid = array(
							'userid' => $logonId
							);
						$Jobs = $shDB->selectOnMultipleCondition($userid,'`logon`');
						$Jobs = $Jobs[0];
						$name = $Jobs['fname'].' '.$Jobs['lname'];
						return $name;
	}


?>
	
	
	