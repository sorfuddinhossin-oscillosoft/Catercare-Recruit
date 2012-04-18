<div id="userRightDiv">
	<h1>Zoho to SEEK FEED <span>(Automatically pull jobs from zoho and upload to seek.)</span></h1>
	<div class="userContent">	
	<?php 
	require_once '../class/xml.class.php';
	
	$seek = $user->seeksettings();
	
		$result = $user->getJobsForSeek();	
			
		$file= fopen("xml/".$_SESSION['userid'].".xml", "w");
		
		$xml = '<FastLanePlus UploaderID="'.$seek["seekid"].'" AgentID="'.$seek["agentid"].'" Version="3.0">
					  <Client ID="'.$seek["seekid"].'" MinJobs="0" MaxJobs="9999999">';
		foreach ($result['response'][0]['result']['JobOpenings']['row'] as $value) {
		$jobDesc = $value[FL];
			
			foreach($jobDesc as $field){
				$name = str_ireplace(" ","_",$field['val']);
				$dataForSeek[$name] = $field[0];
			 }	

			$description = $dataForSeek[SEEK_Description];
			$description = str_replace("•","<br />•",$description);
			
			$salaryRange = explode('-',$dataForSeek[Salary_Range]);
			if($dataForSeek[Published_In]=='Website and SEEK'){
				if($dataForSeek[Job_opening_status]=='In-progress'){
			$xml .= '<Job Reference="'.$dataForSeek['JOBOPENINGID'].'" TemplateID="'.$seek["templateid"].'" ScreenID="'.$seek["screenid"].'">
					      <Title>'.$dataForSeek[Posting_title].'</Title>
					      <SearchTitle>'.$dataForSeek[Posting_title].'</SearchTitle>
					      <Description>'.substr($dataForSeek[Introduction],0,148).'</Description>
					      <AdDetails><![CDATA[<p>'.$description.'</p>]]></AdDetails>
					      <ApplicationEmail>leon@catercareservices.com.au</ApplicationEmail>
					      <ApplicationURL>http://www.catercare.com.au/career/?jobid='.$dataForSeek['JOBOPENINGID'].'</ApplicationURL>
					      <ResidentsOnly>Yes</ResidentsOnly>
					      <Items>
					        <Item Name="Jobtitle">'.$dataForSeek[Posting_title].'</Item>
					        <Item Name="Consultant">'.$dataForSeek[Hiring_manager].'</Item>
					        <Item Name="Consultant Email">leon@catercareservices.com.au</Item>
					        <Item Name="Consultant Telephone">1300 658 700</Item>
					        <Item Name="RefNumber">'.$dataForSeek['JOBOPENINGID'].'</Item>
					      </Items>
					      <Listing MarketSegments="Main">
						        <Classification Name="Location">'.$dataForSeek['SEEK_Location'].'</Classification>
						        <Classification Name="Area"></Classification>
						        <Classification Name="WorkType">'.$dataForSeek[Job_type].'</Classification>
						       	<Classification Name="Classification">'.$dataForSeek[Classification].'</Classification>
					        	<Classification Name="SubClassification">'.$dataForSeek[Sub_Classification].'</Classification>					      
					      </Listing>
					      <Salary Type="AnnualPackage" Min="'.$salaryRange[0].'" Max="'.$salaryRange[1].'" AdditionalText="" />
					      <StandOut IsStandOut="true" LogoID="'.$seek["logoid"].'" Bullet1="'.$dataForSeek[Selling_Point_1].'" Bullet2="'.$dataForSeek[Selling_Point_2].'" Bullet3="'.$dataForSeek[Selling_Point_3].'" />
					    </Job>
					';			
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
			
         $url1 = "http://webservices.seek.com.au/WebserviceAuthenticator.asmx?WSDL";
		$url = "http://test.webservices.seek.com.au/WebserviceAuthenticator.asmx?WSDL";
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
			
			$url123 = "http://webservices.seek.com.au/FastLanePlus.asmx";
			$url = "http://test.webservices.seek.com.au/FastLanePlus.asmx";
			
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
				
	?>
	
	<h2>XML is prepared and uploaded to SEEK Fastlane.
	<a class="ticketGenerate" href="index.php?pg=seekfeed">Return to Page</a></h2>
	</div>
</div>