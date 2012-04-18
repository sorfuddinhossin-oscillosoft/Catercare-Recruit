<?php
/**
 * @package Sorfuddin
 */
/*
Plugin Name: ccrecruit
Plugin URI: http://sorfuddin.com/
Description: Zoho Integration.
Version: 2.4.0
Author: Automattic
Author URI: http://facebook.com/sorfuddin/
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/
if ( ! function_exists( 'parseWord' ) ) :
function parseWord($userDoc) 
{
    $fileHandle = fopen($userDoc, "r");

    $line = @fread($fileHandle, filesize($userDoc));   
    $lines = explode(chr(0x0D),$line);
    $outtext = "";
    foreach($lines as $thisline)
      {
        $pos = strpos($thisline, chr(0x00));
        if (($pos !== FALSE)||(strlen($thisline)==0))
          {
          } else {
            $outtext .= $thisline." ";
          }
      }
    // $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
    return $outtext;
} 
endif;

if ( ! function_exists( 'starseperator' ) ) :
function starseperator($string) 
{
	$returnString = "";
	$html123 = html_entity_decode($string, ENT_QUOTES, 'ISO-8859-15');
	$html123 = explode('•', $html123);
	if(sizeof($html123)>1){
		$returnString .= "<ul>";
		foreach($html123 as $htm123){
			$returnString .="<li>".$htm123."</li>";
		}	
		$returnString .= "</ul>";
	}else{
		$returnString .= $html123[0];
	}
echo $returnString;	
} 
endif;

if ( ! function_exists( 'myFileRead' ) ) :
function myFileRead($fb = '') {
$fh = fopen($fb, 'rb');
$contents = stream_get_contents($fh);
$theData = fread($fh, 50000000);
fclose($fh);
return $theData;
}
endif;

if ( ! function_exists( 'word_limiter' ) ) :
function word_limiter( $text, $limit = 390, $chars = '0123456789' ) {
    if( strlen( $text ) > $limit ) {
        $words = str_word_count( $text, 2, $chars );
        $words = array_reverse( $words, TRUE );
        foreach( $words as $length => $word ) {
            if( $length + strlen( $word ) >= $limit ) {
                array_shift( $words );
            } else {
                break;
            }
        }
        $words = array_reverse( $words );
        $text = implode( " ", $words );
    }
    return $text;
}
endif;

if ( ! function_exists( 'myfileToBase64' ) ) :
function myfileToBase64($filename='') {
    $handle = fopen($filename, "r");
	$imgbinary = fread(fopen($filename, "r"), filesize($filename));
	$returnString = base64_encode($imgbinary);
	return $returnString;
}
endif;


if ( ! function_exists( 'fileToBase641' ) ) :
function fileToBase641($fb=''){
	$fh = fopen($fb, 'rb');
//$fh2 = fopen('Output-File', 'wb');

$cache = '';
$eof = false;

while (1) {

    if (!$eof) {
        if (!feof($fh)) {
            $row = fgets($fh, 4096);
        } else {
            $row = '';
            $eof = true;
        }
    }

    if ($cache !== '')
        $row = $cache.$row;
    elseif ($eof)
        break;

    $b64 = base64_encode($row);
    $put = '';

    if (strlen($b64) < 76) {
        if ($eof) {
            $put = $b64."\n";
            $cache = '';
        } else {
            $cache = $row;
        }

    } elseif (strlen($b64) > 76) {
        do {
            $put .= substr($b64, 0, 76)."\n";
            $b64 = substr($b64, 76);
        } while (strlen($b64) > 76);

        $cache = base64_decode($b64);

    } else {
        if (!$eof && $b64{75} == '=') {
            $cache = $row;
        } else {
            $put = $b64."\n";
            $cache = '';
        }
    }

    if ($put !== '') {
        //echo $put;
        //fputs($fh2, $put);
        //fputs($fh2, base64_decode($put));        // for comparing
    }
}

//fclose($fh2);
fclose($fh); 
return base64_decode($put);
}
endif;

 if ( ! function_exists( 'ccRecruit' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
 
function ccRecruit() {
	$xml = new Xml2Assoc();
	$url = 'http://www.catercare.com.au/career/career/?state=';
	$applyURL = 'http://www.catercare.com.au/career/career/?jobid=';
	
	$xmlUrl = 'http://jobs.oscillosoft.com/user/xml/plugin_1.xml';
	
	$settings = $xml->parseFile($xmlUrl, false);
	
	$api = $settings['plugin']['settings']['api'][0];
	$secretkey = '251c6e6e9db869910f6ac8a6a1181977';
	//$ticket = 'b6762a32a42e7923dcbf54985797bb44';

	$ticket = $settings['plugin']['settings']['ticket'][0];
	
	$noOfRecords = 200;
 	if(!($_GET['state'])){
			$statename = 'Queensland';				 	
			}else {
				$statename = $_GET['state'];
			}

	if($_GET['state']=='NewSouthWales'){
		$statename = 'New South Wales';
	}
	
	if($_GET['state']=='SouthAustralia'){
		$statename = 'South Australia';
	}
	
	if($_GET['state']=='NorthernTerritory'){
		$statename = 'Northern Territory';
	}
	
	if($_GET['state']=='WesternAustralia'){
		$statename = 'Western Australia';
	}
	
	//require_once 'http://ccrecruit.oscillosoft.com.au/wp/wp-content/plugins/xml.class.php';
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/getRecords?apikey='.$api.'&ticket='.$ticket.'&sortColumnString=Date%20opened&sortOrderString=desc&fromIndex=1&toIndex='.$noOfRecords;
	$xml = new Xml2Assoc();
	
	$practice = $xml->parseFile($apiRequestURL, false);
	


	echo '<style type="text/css">
	#ccrecruit ul{
					/* list-style:none;  */
				}
			#ccrecruit li{
				margin:10px 0 10px 0;
				}
			#ccrecruit li ul{
				margin:0px 0px 0px 25px;
				list-style:none;
				}
			#ccrecruit li ul li{
				margin:4px 0 4px 0;
				color:black;

				}
			#ccrecruit ol li{
				margin:4px 0 4px 0;
				color:black;
				list-style:none;
				}
			#ccrecruit{
				color:#000000;
				clear:both;
				margin:0px;
				font-size:12px;

				}
			#ccrecruit p{
				color:#000000;
				font-size:12px;
				}
			#ccrecruit label{
				color:#333333;
				margin:0px;
				font-size:12px;
				}
			#ccrecruit input[type="text"]{
				width:95%;
				color:#999999;
				}
			#ccrecruit div.header{
				clear:both;
				background:#666666;
				color:white;
				padding:6px;
				font-family:"Arial",tahoma,verdana;
				font-size:12px;
				font-weight:bold;
				margin:0px;
			}
			#ccrecruit div.header span{
				float:right;
				margin-top:-2px;
				}
			#ccrecruit div.jobcontainer{
				border:1px solid #CCCCCC;
				background:#ffffff;
				clear:both;
				padding:15px;
				line-height:1.4em;
				font-family:"Trebuchet MS", arial, tahoma;
				
			}
			#ccrecruit h2{
				color:#999900;
				font-size:16px;
				font-weight:bold;
				margin:0px;
				
			}
			#ccrecruit h2 span{
				color:#8C1818;
			}
			#ccrecruit span.date1{
				font-size:10px;
				color:#8C1818;
			}
			#ccrecruit h3{
				color:#000000;
				margin:5px 0 5px 0;
			}
			#ccrecruit input[type="button"]{
				color:white;
				font-weight:bold;
				font-size:12px;
				background:#8C1818;
				-moz-border-radius: 4px;
				border-radius: 4px;
				padding:6px 10px 6px 10px;
				text-decoration:none;
				}
			#ccrecruit input[type="button"]:hover{
		background:#8C1818;
				color:#cccccc;
				}
			
			#ccrecruit a.apply{
				color:white;
				font-weight:bold;
				font-size:12px;
				background:#8C1818;
				-moz-border-radius: 4px;
				border-radius: 4px;
				padding:6px 10px 6px 10px;
				text-decoration:none;
				margin-left:auto;
				margin-right:auto;
			}
			#ccrecruit a.apply:hover{
				background:#8C1818;
				color:#cccccc;
			}
			#ccrecruit a.more{
				color:#8C1818;
				font-weight:bold;
				font-size:12px;
				text-decoration:none;
			}
			#ccrecruit a.more:hover{
				text-decoration:none;
				color:#C82222;
			}
			
			#ccrecruit b{
				color:#8C1818;
			}
			#ccrecruit span.mandatory{
				color:#ff0000;
			}
			
		  </style>';
	echo '
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	 <script type="text/javascript">
	 
      $(document).ready(function() {
      	$("#auslocation").change(function(){
      		window.location = "'.$url.'"+$(this).val();
      	});
      	
     $("#submitButton").click(function(){
    
     var err = 0;
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var fName = $("#fName").val();
		var lName = $("#lName").val();
		var phone = $("#phone").val();
		var email = $("#email").val();
		if(fName==""){
			alert("Please enter first name!");
			$("#fName").focus();
			return false;
		}else if(lName==""){
			alert("Please enter Surname name!");
			$("#lName").focus();
			return false;
		}else if(phone==""){
			alert("Please enter a phone number!");
			$("#phone").focus();
			return false;
		}else if(email==""){
			alert("Please enter email address!");
			$("#email").focus();
			return false;
		}else if(reg.test(email) == false) {
			      alert("Please enter a valid email!");
			      $("#email").val("");
				  $("#email").focus();
			      return false;
		}else{			
			 $("#application").submit();			
		}
		
	});		
        });
    </script>
	';
	$QL = '';
	$NSW = '';
	$VT = '';
	$SA = '';
	$NT = '';
	$WA = '';

	if($_GET['state']){
		if(($_GET['state'])=='Queensland'){
			$QL = 'SELECTED';
		}
		elseif(($_GET['state'])=='NewSouthWales'){
			$NSW = 'SELECTED';
		}
		elseif(($_GET['state'])=='Victoria'){
			$VT = 'SELECTED';
		}
		elseif(($_GET['state'])=='SouthAustralia'){
			$SA = 'SELECTED';
		}
		elseif(($_GET['state'])=='NorthernTerritory'){
			$NT = 'SELECTED';
		}
		elseif(($_GET['state'])=='WesternAustralia'){
			$WA = 'SELECTED';
		}
	}else{
		$QL = 'SELECTED';
	}
	echo '
		<div id="ccrecruit">
		<div class="header">
			Career opportunities
			<span>
				<b style="color:white;">Select a state</b>
				<select name="location" id="auslocation">
					<option value="Queensland" '.$QL.'>Queensland</option>
					<option value="New SouthWales" '.$NSW.'>New South Wales</option>
					<option value="Victoria" '.$VT.'>Victoria</option>
					<option value="South Australia" '.$SA.'>South Australia</option>
					<option value="Northern Territory" '.$NT.'>Northern Territory</option>
					<option value="Western Australia" '.$WA.'>Western Australia</option>
				</select>
			</span>
		</div>';

	$isjob = 0;
	if(!($_GET['jobid'])){
		foreach ($practice['response'][0]['result']['JobOpenings']['row'] as $value) {
				
						 foreach($value['FL'] as $field){
						 	if($field['val']=='JOBOPENINGID'){
						 		$jobOpeningID = $field[0];
						 	}
						 	if($field['val']=='Job opening status'){
						 		$jobOpeningstatus = $field[0];
						 	}
						 	
						 	if($field['val']=='Date opened'){
						 		$openDate = $field[0];
						 	}
						 	if($field['val']=='Target date'){
						 		$targetDate = $field[0];
						 	}
						 	if($field['val']=='Posting title'){
						 		$positionName = $field[0];
						 	}
						 	if($field['val']=='Roles and responsibilities'){
						 		$roles = $field[0];
						 	}
							 if($field['val']=='SEEK Description'){
						 		$seekdescription = $field[0];
						 	}
						 	
						 	
						 	if($field['val']=='Number of positions'){
						 		$noOfPositions = $field[0];
						 	}
							if($field['val']=='State'){
						 		$location = $field[0];
						 	}
						 	if($field['val']=='Country'){
						 		$country = $field[0];
						 	}
						 	if($field['val']=='Work experience'){
						 		$workExperience = $field[0];
						 	}
						 	if($field['val']=='Required Skills'){
						 		$requiredSkills = $field[0];
						 	} 	
						 	if($field['val']=='Introduction'){
						 		$Introduction = $field[0];
						 	}
						 if($field['val']=='Application Summary'){
						 		$ApplicationSummary = $field[0];
						 	} 	
					 }
					
			if($statename==$location){
				$isjob = $isjob+1;
					if($jobOpeningstatus!='Filled'){
					 	echo '<div class="jobcontainer">';
						 echo '<h2><a class="jobtitle" href="'.$applyURL.$jobOpeningID.'">'.$positionName.'</a>&nbsp;<span>('.$noOfPositions.')</span></h2>';
						 echo '<span class="date1">Posted Date : '.$openDate.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Closing Date : '.$targetDate.'</span>';
						 echo '<h3>'.$location.',&nbsp;'.$country.'</h3>';
						
						 echo '<h4>'.starseperator($workExperience).'</h4>';
						 echo '<b>Roles and Responsibilities</b><br />';
						 echo '<p>'.starseperator($seekdescription).'</p>';
						 echo '<a class="apply" href="'.$applyURL.$jobOpeningID.'">Read More</a>';
						 echo '</div>';
					 }
				}
				
				}
			if($isjob==0){
				echo '<div style="width:100%;padding:20px 0 20px 0;font-size:16px;color:red;text-align:center;">Unfortunately we do not currently have any positions available in '.$statename.'.</div>';
				}
				
	} else {
	foreach ($practice['response'][0]['result']['JobOpenings']['row'] as $value) {
				
						 foreach($value['FL'] as $field){
						 	if($field['val']=='JOBOPENINGID'){
						 		$jobOpeningID = $field[0];
						 	}
						 	if($field['val']=='Date opened'){
						 		$openDate = $field[0];
						 	}
						 	if($field['val']=='Target date'){
						 		$targetDate = $field[0];
						 	}
						 	if($field['val']=='Posting title'){
						 		$positionName = $field[0];
						 	}
						 	if($field['val']=='Roles and responsibilities'){
						 		$roles = $field[0];
						 	}
						 	 if($field['val']=='SEEK Description'){
						 		$seekdescription = $field[0];
						 	}
						 	if($field['val']=='Number of positions'){
						 		$noOfPositions = $field[0];
						 	}
							if($field['val']=='State'){
						 		$location = $field[0];
						 	}
						 	if($field['val']=='Country'){
						 		$country = $field[0];
						 	}
						 	if($field['val']=='Work experience'){
						 		$workExperience = $field[0];
						 	}
						 	if($field['val']=='Required Skills'){
						 		$requiredSkills = $field[0];
						 	} 	
						 	if($field['val']=='Introduction'){
						 		$Introduction = $field[0];
						 	}
						 if($field['val']=='Application Summary'){
						 		$ApplicationSummary = $field[0];
						 	} 	 	
					 }
					 
					 if($_GET['jobid']==$jobOpeningID){
					 	echo '<div class="jobcontainer">';
						 echo '<h2><a href="'.$applyURL.$jobOpeningID.'">'.$positionName.'</a>&nbsp;<span>('.$noOfPositions.')</span></h2>';
						 echo '<span class="date1">Opened Date : '.$openDate.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Closing Date : '.$targetDate.'</span>';
						 echo '<h3>'.$location.',&nbsp;'.$country.'</h3>';
						 echo '<h4>'.starseperator($workExperience).'</h4>';
						 echo '<p>'.starseperator($Introduction).'</p>';

						echo '<ul style="list-style:none">';
if(!$_GET['apply']){

						 echo '<li><b>Job Description</b><br />';
						 echo '<p>'.starseperator($seekdescription).'</p></li>';
						// echo '<li><b>Required Skills</b><br />';
						// echo '<p>'.starseperator($requiredSkills).'</p></li>';
						 //echo '<li><b>Application Summary</b><br />';
						// echo '<p>'.starseperator($ApplicationSummary).'</p></li>';
}
if(!$_GET['apply']){
echo '<li style="text-align:center;">';
 echo '<a style="margin-left:auto;margin-right:auto;" class="apply" href="'.$applyURL.$jobOpeningID.'&apply=1">Apply Now</a>';
echo '</li>';

}
 if($_POST['isSubmit']){
	if(isset($_POST['fName'])){
		$fname = $_POST['fName'];
	}else{
		$fname = '';
	}
 if(isset($_POST['employmentstatus'])){
		$employmentstatus = $_POST['employmentstatus'];
	}else{
		$employmentstatus = '';
	}
 if(isset($_POST['lName'])){
		$lName = $_POST['lName'];
	}else{
		$lName = '';
	}
 if(isset($_POST['street'])){
		$street = $_POST['street'];
	}else{
		$street = '';
	}
 if(isset($_POST['suburb'])){
		$suburb = $_POST['suburb'];
	}else{
		$suburb = '';
	}
  if(isset($_POST['state'])){
		$state = $_POST['state'];
	}else{
		$state = '';
	}
 if(isset($_POST['Postcode'])){
		$Postcode = $_POST['Postcode'];
	}else{
		$Postcode = '';
	}
  if(isset($_POST['phoneNo'])){
		$phoneNo = $_POST['phoneNo'];
	}else{
		$phoneNo = '';
	}
 if(isset($_POST['mobileNo'])){
		$mobileNo = $_POST['mobileNo'];
	}else{
		$mobileNo = '';
	}
  if(isset($_POST['driverlicense'])){
		$driverlicense = $_POST['driverlicense'];
	}else{
		$driverlicense = '';
	}
  if(isset($_POST['Email'])){
		$Email = $_POST['Email'];
	}else{
		$Email = '';
	}
  if(isset($_POST['entitledinaustralia'])){
		$entitledinaustralia = $_POST['entitledinaustralia'];
	}else{
		$entitledinaustralia = '';
	}
 if(isset($_POST['driverlicence'])){
		$driverlicence = $_POST['driverlicence'];
	}else{
		$driverlicence = '';
	}
 if(isset($_POST['policesecuritycheck'])){
		$policesecuritycheck = $_POST['policesecuritycheck'];
	}else{
		$policesecuritycheck = '';
	}
 if(isset($_POST['medicalexamination'])){
		$medicalexamination = $_POST['medicalexamination'];
	}else{
		$medicalexamination = '';
	}
						 	//$filename = explode('tmp/', $_FILES['uploadedresume']['tmp_name']);
							//$fileToPass = fileToBase641($_FILES['uploadedresume']['tmp_name']);
if(($_FILES['uploadedresume']['tmp_name']!='')||($_FILES['uploadedresume']['tmp_name']!=Null)){
	$newString = myfileToBase64($_FILES['uploadedresume']['tmp_name']);
}


//$newString = base64_encode($newString);

						 	$string = '<Candidates>
								<row no="1">
									<FL val="First name">'.$fname.'</FL>
									<FL val="Cater Care Employment status">'.$employmentstatus.'</FL>
									<FL val="Sur name">'.$lName.'</FL>
									<FL val="Street">'.$street.'</FL>
									<FL val="Suburb">'.$suburb.'</FL>
									<FL val="State">'.$state.'</FL>
									<FL val="Post Code">'.$Postcode.'</FL>
									<FL val="Phone number">'.$phoneNo.'</FL>
									<FL val="Mobile Number">'.$mobileNo.'</FL>
									<FL val="Email ID">'.$Email.'</FL>
									<FL val="Are you legally entitled to work in Australia?">'.$entitledinaustralia.'</FL>
									<FL val="Do you hold a valid drivers licence?">'.$driverlicence.'</FL>
									<FL val="Are you prepared to undergo a police/security check should our clients request this check?">'.$policesecuritycheck.'</FL>
									<FL val="Total work exp (year)">0</FL>
									<FL val="Total work exp (month)">0</FL>
									<FL val="Current job title"></FL>
									<FL val="Current employer"> </FL>
									<FL val="Skill set"> </FL>
									<FL val="Resume status">New</FL>';
					if(($_FILES['uploadedresume']['tmp_name']!='')||($_FILES['uploadedresume']['tmp_name']!=Null)){
							$string .= '<FL val="Attach resume">'.$newString.'</FL>
									<FL val="Attach resume_filename">'.$_FILES['uploadedresume']['name'].'</FL>';
					}		
							$string .= '</row>
							</Candidates>';
						 	
    $postData = array(
       'xmlData' => $string
    );
    
	$url = 'https://recruit.zoho.com/ats/private/xml/Candidates/addRecords?apikey='.$api.'&ticket='.$ticket;
	
	$myCurl = new CURL();
	$asscCurl = new CURL();
	$success = $myCurl->post($url, $postData);
	
	$successtoString = (string)trim($success);
	

	$pos = strrpos($successtoString, "successfully");

		if ($pos > 0) { 
		   $candidateid = explode('successfully', $successtoString);
			$canid = trim($candidateid[1]);
			$canid = explode('<FL val=', $canid);
			$canid = explode('>', $canid[1]);
			$canid = explode('<', $canid[1]);
			$canid = $canid[0]; 
		}
   $ascData = array(
      	'Develop By' => 'sorfuddin@gmail.com'
    );
    
if($canid){
	$asscociate ='https://recruit.zoho.com/ats/private/xml/Candidates/associateJobOpening?apikey='.$api.'&ticket='.$ticket.'&jobId='.$_GET["jobid"].'&candidateIds='.$canid;
	$assc_success = $asscCurl->post($asscociate, $ascData);
	
	$pos1 = strrpos($assc_success, "successfully");
	if($pos1>0){
		echo '<div style="width:95%;border:1px solid orange;color:orange;padding:5px;">Thank you for submitting your application for a career with Cater Care. We have successfully received your application and will contact you shortly.</div>';
	}
}

     }else{
     	
if($_GET['apply']){

						 echo '
						 <ul> 
						 <li>
<span style="color:black">To apply for your select position please complete the application form below and upload your most recent resume.</span>
							
						 	<form action="" method="post" id="application" enctype="multipart/form-data">
							<OL style="list-style:lower-roman outside none;line-height:1.9em">
							<li>
						 	<label>First name</label><span class="mandatory">*</span><br />
						 	<input type="text" name="fName" id="fName">
							
						 	<label>Surname</label><span class="mandatory">*</span><br />
						 	<input type="text" name="lName" id="lName">							
							 	
							</li><li>
						 	<label>Address</label><br />
						 	<input type="text" name="street"><br />					
						 	<label>Suburb</label><br />
						 	<input type="text" name="suburb"><br />					
						 	<label>State</label><br />
						 	<select name="state">
						 		<option value="QLD">QLD</option>
						 		<option value="NSW">NSW</option>
						 		<option value="VIC">VIC</option>
						 		<option value="SA">SA</option>
						 		<option value="WA">WA</option>
						 		<option value="NT">NT</option>
						 		<option value="ACT">ACT</option>
						 		<option value="OTHER">OTHER</option>
						 	</select><br />							
						 	<label>Postcode</label><br />
						 	<input type="text" name="Postcode"><br />				
						 	<label>Email</label><span class="mandatory">*</span><br />
						 	<input type="text" name="Email" id="email"><br />
						 	<label>Phone No</label><span class="mandatory">*</span><br />
						 	<input type="text" name="phoneNo" id="phone"><br />
						 	<label>Mobile No</label><br />
						 	<input type="text" name="mobileNo"><br />
						 	
							</li><li>
						 	<label>Are you legally entitled to work in Australia?</label><br />					 	
						 	<input type="radio" name="entitledinaustralia" value="No - I require assistance">&nbsp;No - I require assistance&nbsp;&nbsp;
						 	<input type="radio" name="entitledinaustralia" value="Yes - I have a current work visa">&nbsp;Yes - I have a current work visa&nbsp;&nbsp;
						 	<input type="radio" name="entitledinaustralia" value="Yes – I am a resident of Australia">&nbsp;Yes – I am a resident of Australia
							</li><li>
						 	<label>Do you hold a valid driver licence?</label><br />
						 	<input type="radio" name="driverlicence" value="Yes">&nbsp;Yes &nbsp;&nbsp;
						 	<input type="radio" name="driverlicence" value="No">&nbsp;No
							</li>
							<li>
						 	<label>Are you prepared to undergo a police/security check should our clients request this check?
						 	</label><br />
						 	<input type="radio" name="policesecuritycheck" value="Yes">&nbsp;Yes &nbsp;&nbsp;
						 	<input type="radio" name="policesecuritycheck" value="No">&nbsp;No
						 	</li><li>
						 	<label>Cater Care Employment Status</label><br />
						 	<input type="radio" name="employmentstatus" value=" Never been employed">&nbsp;Never been employed&nbsp;&nbsp;
						 	<input type="radio" name="employmentstatus" value=" Previously employed">&nbsp;Previously employed&nbsp;&nbsp;
						 	<input type="radio" name="employmentstatus" value=" Currently employed">&nbsp;Currently employed
						 	
							</li><li>
						 	<label>Upload your resume</label><br />
						 	<input name="uploadedresume" type="file" />
							</li></ol>
						 	<input type="hidden" value="1" name="isSubmit">
						 	<div style="width:100%;text-align:center;">
						 	<input type="Button" id="submitButton" class="apply" value="Apply Now"></div>
						 	</form>	
							</li>		
						 	</ul>
						 	
						 ';
						 //echo '<a href="'.$applyURL.$jobOpeningID.'">Apply Now</a>';
						 echo '</div>';
								 }
				}
					 } 
				}
	}
	
	echo '</div>';
	
	
}
endif;
?>