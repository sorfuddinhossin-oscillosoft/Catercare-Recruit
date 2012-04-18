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
							'published_in' => 'Website and SEEK',
							'job_opening_status' =>'In-progress'
							);
	$JobsList = $shDB->selectOnMultipleCondition($jobSelectBy,'jobs_posted');
	
	$seek = $user->seeksettings(1);
	
	function starseperator($string) 
	{
		$returnString = "";
		$html123 = html_entity_decode($string, ENT_QUOTES, 'ISO-8859-15');
		$html123 = explode('�', $html123);
		$arraySize = sizeof($html123);
		if(sizeof($html123)>1){
			echo '<ul>';
			foreach($html123 as $htm123){
				$returnString .= '<li>'.$htm123."</li>";
			}	
				echo '</ul>';
		}else{
			$returnString .= $html123[0];
		}
		return $returnString;
	} 
	
	
 //	$allSeekUser = $user->getAllSeekId();
	
	
	// $result = $user->getJobsForSeekCron($seekUser['logonid']);	

		$file= fopen("xml/seek.xml", "w");
		
		if($JobsList){
		$xml = '<FastLanePlus UploaderID="'.$seek["seekid"].'" AgentID="'.$seek["agentid"].'" Version="3.0">
					  <Client ID="'.$seek["seekid"].'" MinJobs="0" MaxJobs="9999999">';
	// 	foreach ($result['response'][0]['result']['JobOpenings']['row'] as $value) {
		foreach($JobsList as $jList){ 
		
			
		/*
		 * 	$jobDesc = $value[FL];
			foreach($jobDesc as $field){
				$name = str_ireplace(" ","_",$field['val']);
				$dataForSeek[$name] = $field[0];
			 }	
			*/
			
			$description = (string) $jList['job_description'];
			$description = str_replace("•","<br />•",$description);
			$description = str_replace("----","<br /><br />",$description);
			$description = str_replace("---","<br />",$description);
			
			$bullet1 = str_replace("&","and",$jList['selling_point_one']);
			$bullet2 = str_replace("&","and",$jList['selling_point_two']);
			$bullet3 = str_replace("&","and",$jList['selling_point_three']);
			
			$salaryRange = explode('-',$jList['salary_range']);
			if($jList['published_in']=='Website and SEEK'){
				if($jList['job_opening_status']=='In-progress'){
				if($jList['zohoid']!==''){
				$xml .= '<Job Reference="'.$jList['zohoid'].'" TemplateID="'.$seek["templateid"].'" ScreenID="'.$seek["screenid"].'">
						      <Title><![CDATA['.$jList['job_title'].']]></Title>
						      <SearchTitle><![CDATA['.$jList['job_title'].']]></SearchTitle>
						      <Description><![CDATA['.$jList['introduction'].']]></Description>
						      <AdDetails><![CDATA['.$description.']]></AdDetails>
						      <ApplicationEmail>leon@catercareservices.com.au</ApplicationEmail>
						      <ApplicationURL>http://www.catercare.com.au/career/?jobid='.$jList['zohoid'].'</ApplicationURL>
						      <ResidentsOnly>Yes</ResidentsOnly>
						      <Items>
						        <Item Name="Jobtitle"><![CDATA['.$jList['job_title'].']]></Item>
						        <Item Name="Consultant">'.$jList['hiring_manager'].'</Item>
						        <Item Name="Consultant Email">leon@catercareservices.com.au</Item>
						        <Item Name="Consultant Telephone">1300 658 700</Item>
						        <Item Name="RefNumber">'.$jList['zohoid'].'</Item>
						      </Items>
						      <Listing MarketSegments="Main">
							        <Classification Name="Location">'.$jList['seek_location'].'</Classification>
							        <Classification Name="Area"></Classification>
							        <Classification Name="WorkType">'.$jList['seek_job_type'].'</Classification>
							       	<Classification Name="Classification">'.$jList['seek_classification'].'</Classification>
						        	<Classification Name="SubClassification">'.$jList['seek_sub_classification'].'</Classification>					      
						      </Listing>
						      <Salary Type="AnnualPackage" Min="'.$salaryRange[0].'" Max="'.$salaryRange[1].'" AdditionalText="'.$jList['additional_sal_text'].'" />
						      <StandOut IsStandOut="false" LogoID="'.$seek["logoid"].'" Bullet1="'.$bullet1.'" Bullet2="'.$bullet2.'" Bullet3="'.$bullet3.'" />
						    </Job>
						';			
				}
				}
			}
			}
	
		$xml .= '</Client>
					</FastLanePlus>';
	
		$xmlinfile = '<?xml version="1.0" encoding="utf-8" ?>'.$xml;
		
		fwrite($file, $xmlinfile);
		
		$xmlAuthenticate='<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
			  <soap:Body>
			    <AuthenticateWS xmlns="http://webservices.seek.com.au">
			      <userName>'.$seek["seekuserid"].'</userName>
			      <password>'.$seek["password"].'</password>
			      <role>'.$seek["role"].'</role>
			    </AuthenticateWS>
			  </soap:Body>
			</soap:Envelope>';
			
			$headers = array(
			"POST /webserviceauthenticator.asmx HTTP/1.1",
			"Host: webservices.seek.com.au",
			"Content-type: text/xml; charset=\"utf-8\"",
			"SOAPAction: \"http://webservices.seek.com.au/AuthenticateWS\"",
			"Content-length: ".strlen($xmlAuthenticate)
			);
			
         $url = "http://webservices.seek.com.au/WebserviceAuthenticator.asmx?WSDL";

			$soap_do = curl_init();
			curl_setopt($soap_do, CURLOPT_URL, $url );
			curl_setopt($soap_do, CURLOPT_HEADER, 0);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $xmlAuthenticate);
			
			
			$result = curl_exec($soap_do);
			$err = curl_error($soap_do);

			$xml123 = new Xml2Assoc();
	
			$practice = $xml123->parseString($result, false);
			
			$token = $practice['soap:Envelope'][0]['soap:Body']['AuthenticateWSResponse'][0]['AuthenticateWSResult'][0];
						
			$xmlForFile = '<?xml version="1.0" encoding="utf-8"?>
				<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				  <soap:Body>
				    <UploadFile xmlns="http://webservices.seek.com.au">
				      <Token>'.$token.'</Token>
				      <xmlFastlaneFile>'.$xml.'</xmlFastlaneFile>
				    </UploadFile>
				  </soap:Body>
				</soap:Envelope>';

		   	$headers = array(
			"POST /FastLanePlus.asmx HTTP/1.1",
			"Host: webservices.seek.com.au",
			"Content-type: text/xml; charset=\"utf-8\"",
			"SOAPAction: \"http://webservices.seek.com.au/UploadFile\"",
			"Content-length: ".strlen($xmlForFile)
			);	
			$url = "http://webservices.seek.com.au/FastLanePlus.asmx";
			$soap_do = curl_init();
			curl_setopt($soap_do, CURLOPT_URL,            $url );
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $xmlForFile);
				
			$result = curl_exec($soap_do);
			$err = curl_error($soap_do);
		
	
		}	
		
	?>
	
	
	