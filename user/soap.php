<?php 
try { 
   $x = @new SoapClient("http://test.webservices.seek.com.au/WebserviceAuthenticator.asmx?WSDL"); 
  
  
   echo 'Try working here.';
} catch (Exception $e) { 
	 echo 'Exeption working here.';
    echo $e->getMessage();
}

	?>
