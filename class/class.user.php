<?php
//start session
class user{
	//database setup 
    //MAKE SURE TO FILL IN DATABASE INFO
	var $hostname_logon = 'localhost';		//Database server LOCATION
	var $database_logon = 'oscint_catercare';		//Database NAME
	var $username_logon = 'oscint_leon';		//Database USERNAME
	var $password_logon = 'leonosc123';		//Database PASSWORD
	var $zoho_credential = 'zoho_credential';
	var $seek_credential = 'seek_credential';
	
		//connect to database
	function dbconnect(){
		$connections = mysql_connect($this->hostname_logon, $this->username_logon, $this->password_logon) or die ('Unabale to connect to the database');
		mysql_select_db($this->database_logon) or die ('Unable to select database!');	
		
	}

	function zohosettings($userid=''){
		$this->dbconnect();
		if($userid==''){
			$userid	= $_SESSION['userid'];
		}
		$result = $this->qry("SELECT * FROM ".$this->zoho_credential." WHERE logonid ='?';" , $userid);
		$row=mysql_fetch_assoc($result);
		if($row != "Error"){
			return $row;
		}
	}
	
function getAllUser(){
		$this->dbconnect();
		$result1 = $this->qry("SELECT * FROM logon");
		
		while($row = mysql_fetch_array($result1))
		  {
		  	 $result[]=$row; 
		  }  
		  	
		 return $result;
	}
	
function allzohosettings(){
		$this->dbconnect();
		$userid	= $_SESSION['userid'];
		$result1 = $this->qry("SELECT * FROM ".$this->zoho_credential);
		while($row = mysql_fetch_array($result1))
		  {
		  	 $result[]=$row; 
		  }  
		  	
		 return $result;
	}
	
function seeksettings($userid=''){
		$this->dbconnect();
		if($userid==''){
			$userid	= $_SESSION['userid'];
		}
		$result = $this->qry("SELECT * FROM ".$this->seek_credential." WHERE logonid ='?';" , $userid);
		$row=mysql_fetch_assoc($result);
		if($row != "Error"){
			return $row;
		}
	}
function getAllSeekId(){
		$this->dbconnect();
		$userid	= $_SESSION['userid'];
		$result = $this->qry("SELECT logonid FROM ".$this->seek_credential);
		$row=mysql_fetch_assoc($result);
		if($row != "Error"){
			return $row;
		}
	}
	
function getAllZohoId(){
		$this->dbconnect();
		$userid	= $_SESSION['userid'];
		$result1 = $this->qry("SELECT * FROM ".$this->zoho_credential);
		while($row = mysql_fetch_array($result1))
	  {
	  	 $result[]=$row; 
	  }  
	  	
	 return $result;
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
	
function getJobTitlefromJobField($randid,$userid=''){
		$this->dbconnect();
		if($userid==''){ 
	 		$userid = $_SESSION['userid'];
	 	}
		$title = $this->getJobTitlefromSettings();
		
		$result = $this->qry("SELECT value FROM job_field WHERE companyid ='?' AND jobrandid = '?' AND fieldname = '?';" , $userid,$randid,$title);
		$row=mysql_fetch_assoc($result);
		
		if($row != "Error"){
			return $row['value'];
		}
}

  function selectJobs($userid){
  
   	$result1 = $this->qry("SELECT * FROM job_field WHERE companyid='?' AND fieldname = 'JOBOPENINGID'",$userid);
  	
	while($row = mysql_fetch_array($result1))
	  {
	  	 $result[]=$row; 
	  }  
	  	
	 return $result;
  }
  
  
 function selectJobField($randid,$userid=''){
  
 	if($userid==''){ 
 	$userid = $_SESSION['userid'];
 	}
 	
 	$result1 = $this->qry("SELECT * FROM job_field WHERE companyid='?' AND jobrandid = '?' AND fieldfor = 'jobopenings' ORDER BY displayorder ASC",$userid,$randid);
 	
 	while($row = mysql_fetch_array($result1))
	  {
	  	 $result[]=$row; 
	  }  
	 return $result;
  }
  
function selectJobField123($randid,$userid=''){
  
 	if($userid==''){ 
 	$userid = $_SESSION['userid'];
 	}
 	
 	$result1 = $this->qry("SELECT * FROM job_field WHERE companyid=? AND jobrandid = '?' AND fieldfor = 'jobopenings' ORDER BY displayorder ASC",$userid,$randid);
 	
 	while($row = mysql_fetch_array($result1))
	  {
	  	 $result[]=$row; 
	  }  
	 return $result;
  }
  
 function selectCandidateField($userid=''){
 if($userid==''){ 
 	$userid = $_SESSION['userid'];
 	}
   	$result1 = $this->qry("SELECT * FROM job_field WHERE companyid='?' AND fieldfor = 'candidateform' ORDER BY displayorder ASC",$userid);
  	
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
 	
   	$result1 = $this->qry("SELECT * FROM job_field WHERE companyid='?' ORDER BY displayorder ASC",$userid);
  	
	while($row = mysql_fetch_array($result1))
	  {
	  	 $result[]=$row; 
	  }  
	  	
	 return $result;
  }
 
function deleteRandIdbyComId($userid=''){
	$this->dbconnect();
 	if($userid==''){ 
 	//$userid = $_SESSION['userid'];
 	}
 	
  	$result1 = mysql_query("SELECT jobrandid FROM job_field WHERE fieldname = 'Job opening status' AND value != 'In-progress'");
   	//$result1 = mysql_query("SELECT * FROM job_field");
   	//var_dump($result1);
  	
	while($row = mysql_fetch_array($result1))
	  {
	  	$result[] = $row;
	  	
	  }  
	 // var_dump($result);	
	  return $result;
  }
  
function getJobsForSeek(){
	require_once 'xml.class.php';
	$zohoCredentials = $this->zohosettings();

	
	$comId = $_SESSION['userid'];
	 
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/getRecords?apikey='.$zohoCredentials['api'].'&ticket='.$zohoCredentials['ticket'].'&sortColumnString=Date%20opened&sortOrderString=desc&fromIndex=1&toIndex=200';
	$xml = new Xml2Assoc();
	
	$practice = $xml->parseFile($apiRequestURL, false);
	
	return $practice;
		
	}
	 
function getJobsForSeekCron($comId){
	require_once 'xml.class.php';
	$zohoCredentials = $this->zohosettings($comId);
		
	 
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/getRecords?apikey='.$zohoCredentials['api'].'&ticket='.$zohoCredentials['ticket'].'&sortColumnString=Date%20opened&sortOrderString=desc&fromIndex=1&toIndex=30';
	$xml = new Xml2Assoc();
	
	$practice = $xml->parseFile($apiRequestURL, false);
	
	
	return $practice;
		
	}
	
function deleteJobField($comId=''){
 	if($comId==''){ 
 	$comId = $_SESSION['userid'];
 	}
 	
   	$result = $this->qry("DELETE FROM job_field WHERE companyid = ?",$comId);

  }
  
function deleteJobFieldbyRandId($rndId=''){
 	var_dump($rndId);
   	$result = $this->qry("DELETE FROM job_field WHERE jobrandid = '?'",$rndId);

  }
  
function refreshFields($comId=''){
	require_once '../class/xml.class.php';
	
	$noOfRecords = 200;
	if($comId==''){ 
	 	$comId = $_SESSION['userid'];
	 }
	 $zohoCredentials = $this->zohosettings($comId);
	$this->deleteJobField($comId);
	
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
	
	$this->refreshcandidateFormFields($comId);
		
	}
function refreshFieldsforCron($comId=''){
	require_once '../../class/xml.class.php';
	
	$noOfRecords = 200;
	if($comId==''){ 
	 	$comId = $_SESSION['userid'];
	 }
	 $zohoCredentials = $this->zohosettings($comId);
	$this->deleteJobField($comId);
	
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/getRecords?apikey='.$zohoCredentials['api'].'&ticket='.$zohoCredentials['ticket'].'&sortColumnString=Date%20opened&sortOrderString=desc&fromIndex=1&toIndex=100';
	$xml = new Xml2Assoc();
	
	$practice = $xml->parseFile($apiRequestURL, false);
	if($practice['response'][0]['result']['JobOpenings']['row']){
	foreach ($practice['response'][0]['result']['JobOpenings']['row'] as $value) {
		$dataForDB = array();
		$rand = $this->generateRandStr();
		 foreach($value['FL'] as $field){
		 
		 	$result = $this->insertFieldtoDB($comId,$rand,trim($field['val']),trim($field[0]));
		 //	echo $rand.' = '.$field['val'].' = '.$field[0].'<br />';
		 }
		}
	}
	$this->refreshcandidateFormFieldsforCron($comId);
	
	$rndid = $this->deleteRandIdbyComId();
	foreach($rndid as $randd){
		
		$this->deleteJobFieldbyRandId($randd['jobrandid']);
	}
		
	}
	
function refreshcandidateFormFieldsforCron($comId=''){
	require_once '../../class/xml.class.php';
		
	if($comId==''){ 
	 	$comId = $_SESSION['userid'];
	 }
	$zohoCredentials = $this->zohosettings($comId);
	$noOfRecords = 200;
	
	 
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/Candidates/getFormFields?apikey='.$zohoCredentials['api'].'&ticket='.$zohoCredentials['ticket'];
	$xml = new Xml2Assoc();
	
	$practice = $xml->parseFile($apiRequestURL, false);
	
	foreach ($practice['response'][0]['result']['Candidates']['section'] as $value) {
		echo $value['name'].'<br />';
		$rand = $this->generateRandStr();
		$groupName = $value['name'];
		foreach($value['FL'] as $field){
			$result = $this->insertCandidateFieldtoDB($comId,$rand,trim($field[0]),trim($field['isMandatory']),$field['maxlength'],$field['type'],$field['isUnique'],$groupName);
		}
	}
	
	}
			
function refreshcandidateFormFields($comId=''){
	require_once '../class/xml.class.php';
	
	
	if($comId==''){ 
	 	$comId = $_SESSION['userid'];
	 }
	$zohoCredentials = $this->zohosettings();
	$noOfRecords = 200;
	$comId = $_SESSION['userid'];
	 
	$apiRequestURL = 'https://recruit.zoho.com/ats/private/xml/Candidates/getFormFields?apikey='.$zohoCredentials['api'].'&ticket='.$zohoCredentials['ticket'];
	$xml = new Xml2Assoc();
	
	$practice = $xml->parseFile($apiRequestURL, false);
	
	foreach ($practice['response'][0]['result']['Candidates']['section'] as $value) {
		echo $value['name'].'<br />';
		$rand = $this->generateRandStr();
		$groupName = $value['name'];
		foreach($value['FL'] as $field){
			$result = $this->insertCandidateFieldtoDB($comId,$rand,trim($field[0]),trim($field['isMandatory']),$field['maxlength'],$field['type'],$field['isUnique'],$groupName);
		}
	}
	
	}

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
			iswebsite,
			groupname
			)			
			VALUES ("","'.$comId.'","candidateform","'.$rand.'","'.$fieldName.'","'.$isMandatory.'","'.$maxLength.'","'.$fieldType.'","'.$isUnique.'","1","'.$groupName.'")';
	
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
			iswebsite,
			value
			)			
			VALUES ("","'.$comId.'","jobopenings","'.$rand.'","'.$fieldName.'","1","'.$fieldValue.'")';
	
	 $result = mysql_query($qry) or die(mysql_error());
	//$result = $this->qry($qry);
	if($result == true){
			return true;
		}else{
			return false;
		}
}

function ticketGeneration($email,$password){
	require_once 'mycurl.php';
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
		//$agentid=trim($_REQUEST['agentid']);
		$seekid=trim($_REQUEST['seekid']);
		$logoid=trim($_REQUEST['logoid']);
		$templateid=trim($_REQUEST['templateid']);
		//$screenid=trim($_REQUEST['screenid']);
		
		$userid	= $_SESSION['userid'];
		$result = $this->qry("UPDATE ".$this->seek_credential." SET seekuserid='?', password='?',role='?',clientid='?',seekid='?',logoid='?',templateid='?' WHERE logonid='?'",$seekuserid,$seekpass,$seekrole,$clientid,$seekid,$logoid,$templateid,$userid);
		 
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