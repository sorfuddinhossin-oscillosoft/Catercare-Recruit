<?php
/*
Sean Huber CURL library

This library is a basic implementation of CURL capabilities.
It works in most modern versions of IE and FF.

==================================== USAGE ====================================
It exports the CURL object globally, so set a callback with setCallback($func).
(Use setCallback(array('class_name', 'func_name')) to set a callback as a func
that lies within a different class)
Then use one of the CURL request methods:

get($url);
post($url, $vars); vars is a urlencoded string in query string format.

Your callback function will then be called with 1 argument, the response text.
If a callback is not defined, your request will return the response text.
*/

class CURL {
    var $callback = false;

function setCallback($func_name) {
    $this->callback = $func_name;
}

function doRequest($method, $url, $vars) {
	
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    }
    $data = curl_exec($ch);
    
    var_dump($method);
    
  	curl_close($ch);
    if ($data) {
        if ($this->callback)
        {
            $callback = $this->callback;
            $this->callback = false;
            return call_user_func($callback, $data);
        } else {
            return $data;
        }
    } else {
        return curl_error($ch);
    }
}

function doInvoiceRequest($method, $url, $vars,$potId,$invId) {
	$date = date("Y-m-d H:i:s");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    }
    $data = curl_exec($ch);
     
    $invoiceId = explode('"Id">', (string)$data);
    $invoiceId = explode('</FL><FL val="Created Time">', $invoiceId[1]);

   	curl_close($ch);
   	$result = 'Invoice ID'.$invoiceId[0];
   	$this->dbfiguration();
   	
   	if($invoiceId[0]){
     		$queryString = 'UPDATE invoice SET
			zohoinvoiceid=\''.$invoiceId[0].'\',
			modifiedtime=\''.$date.'\'
			WHERE id="'.$invId.'"';
   	
   	//$result = updatePotential($queryString);
   	$result = mysql_query($queryString) or die(mysql_error());
   	
	   
   	}   	
 }

 
function getInvoice($url,$data,$potId,$invId) {
    return $this->doInvoiceRequest('POST', $url, $data,$potId,$invId);
}


function get($url) {
    return $this->doRequest('GET', $url, 'NULL');
}

function post($url, $vars, $files) {
    return $this->doRequest('POST', $url, $vars);
}

function dbfiguration(){
$con = mysql_connect("localhost","crmwater_stuart","stuart123");
		if (!$con)
  			{
  				die('Could not connect: ' . mysql_error());
  			}
  			
  		if(!mysql_select_db("crmwater_smart", $con)){
  			echo 'Database Can\'t be connected';
  		}
}
}
?>
