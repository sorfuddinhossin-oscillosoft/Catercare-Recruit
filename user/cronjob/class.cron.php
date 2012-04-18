<?php
//start session
session_start();
class user{
	//database setup 
    //MAKE SURE TO FILL IN DATABASE INFO
	var $hostname_logon = 'localhost';		//Database server LOCATION
	var $database_logon = 'oscillos_jobs';		//Database NAME
	var $username_logon = 'oscillos_jobs';		//Database USERNAME
	var $password_logon = 'jobsforkazi';		//Database PASSWORD
	var $zoho_credential = 'zoho_credential';
	var $seek_credential = 'seek_credential';
	
		//connect to database
	function dbconnect(){
		$connections = mysql_connect($this->hostname_logon, $this->username_logon, $this->password_logon) or die ('Unabale to connect to the database');
		mysql_select_db($this->database_logon) or die ('Unable to select database!');	
		return;
	}

	function zohosettings(){
		$this->dbconnect();
		$userid	= $_SESSION['userid'];
		$result = $this->qry("SELECT * FROM ".$this->zoho_credential." WHERE logonid ='?';" , $userid);
		$row=mysql_fetch_assoc($result);
		if($row != "Error"){
			return $row;
		}
	}
	
function seeksettings(){
		$this->dbconnect();
		$userid	= $_SESSION['userid'];
		$result = $this->qry("SELECT * FROM ".$this->seek_credential." WHERE logonid ='?';" , $userid);
		$row=mysql_fetch_assoc($result);
		if($row != "Error"){
			return $row;
		}
	}
	
function ticketUpdate($email,$password,$logonid){
		$this->dbconnect();
		$nowtime = date("Y-m-d H:i:s");
		$ticket = $this->ticketGeneration($email,$password);
		
		$result = $this->qry("UPDATE ".$this->zoho_credential." SET ticket ='?',ticket_last_update='?' WHERE logonid='?'",$ticket,$nowtime,$logonid);
		 
		if($result == true){
			return true;
		}else{
			return false;
		}
						
	}
function updateFields($id,$field,$value){
	$this->dbconnect();
	$result = $this->qry("UPDATE job_field SET ? ='?' WHERE id='?'",$field,$value,$id);
	if($result == true){
			return true;
		}else{
			return false;
		}
}
	
function generateRandStr(){
	$length = 20;
      $randstr = "";
      for($i=0; $i<$length; $i++){
         $randnum = mt_rand(0,61);
         if($randnum < 10){
            $randstr .= chr($randnum+48);
         }else if($randnum < 36){
            $randstr .= chr($randnum+55);
         }else{
            $randstr .= chr($randnum+61);
         }
      }
      return $randstr;
   } 
   	
   
function getJobTitlefromSettings(){
		$this->dbconnect();
		$userid	= $_SESSION['userid'];
		$result = $this->qry("SELECT * FROM job_settings WHERE companyid ='?';" , $userid);
		$row=mysql_fetch_assoc($result);
		if($row != "Error"){
			return $row['jobtitle'];
			
		}
	}
	
function getJobTitlefromJobField($randid){
		$this->dbconnect();
		$userid	= $_SESSION['userid'];
		$title = $this->getJobTitlefromSettings();
		
		$result = $this->qry("SELECT value FROM job_field WHERE companyid ='?' AND jobrandid = '?' AND fieldname = '?';" , $userid,$randid,$title);
		$row=mysql_fetch_assoc($result);
		
		if($row != "Error"){
			return $row['value'];
		}
}

  function selectJobs($userid){
  
   	$result1 = $this->qry("SELECT * FROM job_field WHERE companyid=? AND fieldname = 'JOBOPENINGID'",$userid);
  	
	while($row = mysql_fetch_array($result1))
	  {
	  	 $result[]=$row; 
	  }  
	  	
	 return $result;
  }
  
 function selectJobField($randid){
  
 	$userid = $_SESSION['userid'];
   	$result1 = $this->qry("SELECT * FROM job_field WHERE companyid=? AND jobrandid = '?' AND fieldfor = 'jobopenings' ORDER BY displayorder ASC",$userid,$randid);
  	
	while($row = mysql_fetch_array($result1))
	  {
	  	 $result[]=$row; 
	  }  
	  	
	 return $result;
  }
  
 function selectCandidateField(){
  
 	$userid = $_SESSION['userid'];
   	$result1 = $this->qry("SELECT * FROM job_field WHERE companyid=? AND fieldfor = 'candidateform' ORDER BY displayorder ASC",$userid);
  	
	while($row = mysql_fetch_array($result1))
	  {
	  	 $result[]=$row; 
	  }  
	  	
	 return $result;
  }
  
  
function selectFieldByComId($userid=''){
 	if($userid==''){ 
 	$userid = $_SESSION['userid'];
 	}
 	
   	$result1 = $this->qry("SELECT * FROM job_field WHERE companyid=? ORDER BY displayorder ASC",$userid);
  	
	while($row = mysql_fetch_array($result1))
	  {
	  	 $result[]=$row; 
	  }  
	  	
	 return $result;
  }
function getJobsForSeek(){
	require_once '../class/xml.class.php';
	$zohoCredentials = $this->zohosettings();
		
	$comId = $_SESSION['userid'];
	 
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/getRecords?apikey='.$zohoCredentials['api'].'&ticket='.$zohoCredentials['ticket'].'&sortColumnString=Date%20opened&sortOrderString=desc&fromIndex=1&toIndex=200';
	$xml = new Xml2Assoc();
	
	$practice = $xml->parseFile($apiRequestURL, false);
	
	return $practice;
		
	} 
function refreshFields(){
	require_once '../class/xml.class.php';
	$zohoCredentials = $this->settings();
	$noOfRecords = 200;
	$comId = $_SESSION['userid'];
	 
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/getRecords?apikey='.$zohoCredentials['api'].'&ticket='.$zohoCredentials['ticket'].'&sortColumnString=Date%20opened&sortOrderString=desc&fromIndex=1&toIndex=200';
	$xml = new Xml2Assoc();
	
	$practice = $xml->parseFile($apiRequestURL, false);
	foreach ($practice['response'][0]['result']['JobOpenings']['row'] as $value) {
		$rand = $this->generateRandStr();
		 foreach($value['FL'] as $field){
		 	$result = $this->insertFieldtoDB($comId,$rand,trim($field['val']),trim($field[0]));
		 	echo $rand.' = '.$field['val'].' = '.$field[0].'<br />';
		 }
		 echo '<hr />';
	}
		
	}
	
function refreshcandidateFormFields(){
	require_once '../class/xml.class.php';
	$zohoCredentials = $this->settings();
	$noOfRecords = 200;
	$comId = $_SESSION['userid'];
	 
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/Candidates/getFormFields?apikey='.$zohoCredentials['api'].'&ticket='.$zohoCredentials['ticket'];
	$xml = new Xml2Assoc();
	
	$practice = $xml->parseFile($apiRequestURL, false);
	//var_dump($practice);
	foreach ($practice['response'][0]['result']['Candidates']['section'] as $value) {
		echo $value['name'].'<br />';
		$rand = $this->generateRandStr();
		$groupName = $value['name'];
		foreach($value['FL'] as $field){
			$result = $this->insertCandidateFieldtoDB($comId,$rand,trim($field[0]),trim($field['isMandatory']),$field['maxlength'],$field['type'],$field['isUnique'],$groupName);
		}
	}
//	foreach ($practice['response'][0]['result']['JobOpenings']['row'] as $value) {
//		$rand = $this->generateRandStr();
//		 foreach($value['FL'] as $field){
//		 	$result = $this->insertFieldtoDB($comId,$rand,trim($field['val']),trim($field[0]));
//		 	echo $rand.' = '.$field['val'].' = '.$field[0].'<br />';
//		 }
//		 echo '<hr />';
//	}
		
	}
	//var_dump($practice);
	
//https://recruit.zoho.com/ats/private/xml/Candidates/getFormFields?apikey=bfa43af8f8dacb91002b9e1a7d22845d&ticket=c7b6c75c2f311395570014aa39478c30

function insertCandidateFieldtoDB($comId,$rand,$fieldName,$isMandatory,$maxLength,$fieldType,$isUnique,$groupName){
	$qry = 'INSERT INTO job_field (
			id,
			companyid,
			fieldfor,
			jobrandid, 
			fieldname, 
			ismandatory,
			maxlength,
			fieldtype,
			isunique,
			groupname
			)			
			VALUES ("","'.$comId.'","candidateform","'.$rand.'","'.$fieldName.'","'.$isMandatory.'","'.$maxLength.'","'.$fieldType.'","'.$isUnique.'","'.$groupName.'")';
	
	 $result = mysql_query($qry) or die(mysql_error());
	//$result = $this->qry($qry);
	if($result == true){
			return true;
		}else{
			return false;
		}
}

	
function insertFieldtoDB($comId,$rand,$fieldName,$fieldValue){
	$qry = 'INSERT INTO job_field (
			id,
			companyid,
			fieldfor,
			jobrandid, 
			fieldname, 
			value
			)			
			VALUES ("","'.$comId.'","jobopenings","'.$rand.'","'.$fieldName.'","'.$fieldValue.'")';
	
	 $result = mysql_query($qry) or die(mysql_error());
	//$result = $this->qry($qry);
	if($result == true){
			return true;
		}else{
			return false;
		}
}

function ticketGeneration($email,$password){
	require_once '../class/mycurl.php';
	$url = 'https://accounts.zoho.com/login?servicename=ZohoCRM&FROM_AGENT=true&LOGIN_ID='.$email.'&PASSWORD='.$password; //Modified Time
	$myCurl = new CURL();		
	$result = $myCurl->get($url,False);
	$result = explode('TICKET=', $result);
	$result = explode('RESULT', $result[1]);
	$ticket = trim($result[0]);
	return $ticket;
}

function seekAuthenticateId($email,$password){
	require_once '../class/mycurl.php';
	$url = 'http://test.webservices.seek.com.au/WebserviceAuthenticator.asmx'; //Modified Time
	$myCurl = new CURL();		
	$result = $myCurl->get($url,False);
	$result = explode('TICKET=', $result);
	$result = explode('RESULT', $result[1]);
	$ticket = trim($result[0]);
	return $ticket;
}

function zohosettingsUpdate(){
		$this->dbconnect();
		$zohoid=$_REQUEST['userid'];
		$zohopass=$_REQUEST['userpass'];
		$zohoapi=$_REQUEST['api'];
		$userid	= $_SESSION['userid'];
		$result = $this->qry("UPDATE ".$this->zoho_credential." SET zohouserid ='?', password='?',api='?' WHERE logonid='?'",$zohoid,$zohopass,$zohoapi,$userid);
		 
		if($result == true){
			return true;
		}else{
			return false;
		}
				
	}
function seeksettingsUpdate(){
		$this->dbconnect();
		$seekuserid=trim($_REQUEST['userid']);
		$seekpass=trim($_REQUEST['userpass']);
		$seekrole=trim($_REQUEST['role']);
		
		$clientid=trim($_REQUEST['clientid']);
		$agentid=trim($_REQUEST['agentid']);
		$seekid=trim($_REQUEST['seekid']);
		$logoid=trim($_REQUEST['logoid']);
		$templateid=trim($_REQUEST['templateid']);
		$screenid=trim($_REQUEST['screenid']);
		
		$userid	= $_SESSION['userid'];
		$result = $this->qry("UPDATE ".$this->seek_credential." SET seekuserid='?', password='?',role='?',clientid='?',agentid='?',seekid='?',logoid='?',templateid='?',screenid='?' WHERE logonid='?'",$seekuserid,$seekpass,$seekrole,$clientid,$agentid,$seekid,$logoid,$templateid,$screenid,$userid);
		 
		if($result == true){
			return true;
		}else{
			return false;
		}
				
	}
function qry($query) {
	  $this->dbconnect();
      $args  = func_get_args();
      $query = array_shift($args);
      $query = str_replace("?", "%s", $query);
      $args  = array_map('mysql_real_escape_string', $args);
      array_unshift($args,$query);
      $query = call_user_func_array('sprintf',$args);
      $result = mysql_query($query) or die(mysql_error());
     
		  if($result){
		  	return $result;
		  }else{
		 	 $error = "Error";
		 	 return $result;
		  }
    }
}
?>