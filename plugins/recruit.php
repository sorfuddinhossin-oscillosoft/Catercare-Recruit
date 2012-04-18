<?php
class recruit {
    
	var $xmlURL = '';
    protected $bOptimize = false;
    
    public function apiKey(){
    	$data = $this->parseFile($this->xmlURL, false);
    	if($data){
    		$api = $data['plugin']['settings']['api'];
    		return $api[0];
    	}    	
    }
    public function ticket(){
    	$data = $this->parseFile($this->xmlURL, false);
    	if($data){
    		$ticket = $data['plugin']['settings']['ticket'];
    		return $ticket[0];
    	}    	
    }
    function javaScript(){
    	echo '
    	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				$("#btnSubmit").click(
					function(){
						alert("Clicked WOrk");
    				}
				);
			});
		</script>
    	';
    }
    function jobOpenings(){
    	$this->javaScript(); 
    	$jobOpenings = $this->parseFile($this->xmlURL, false);
    	echo '<ul>';
    	//echo 'Job id'.$_REQUEST['jobid'];
    	
    	if($jobOpenings){
    		if(!isset($_REQUEST['jobid'])){
    		foreach($jobOpenings['plugin']['jobopenings']['jobs'] as $job){
    			echo '<li>';
    			
    			echo '<h2>'.$job['title'].'</h2>';
    			
    			echo '<dl>';
    			
    			if(sizeof($job['field'])>=1){
	    			foreach($job['field'] as $fl){
	    				echo '<dt>'.$fl['label'][0].'</dt><dd>'.$fl['description'][0].'</dd>';
	    			}
    			}
    			
    			echo '</dl>';
    			
    			echo '<br />';
    			echo '<a href="'.$this->curPageURL().'?jobid='.$job['id'].'">Read More</a>';
    			echo '</li>';
    		}
    	}else{
    	foreach($jobOpenings['plugin']['jobopenings']['jobs'] as $job){
    		
    			if($job['id']==$_REQUEST['jobid']){
    			
    			echo '<form action="" id="appicationform" method="POST">';
    			echo '<h2>'.$job['title'].'</h2>';
    			
    			echo '<dl>';
    			
    			if(sizeof($job['field'])>=1){
	    			foreach($job['field'] as $fl){
	    				echo '<dt>'.$fl['label'][0].'</dt><dd>'.$fl['description'][0].'</dd>';
	    			}
    			}
    			
    			echo '</dl>';
    			
    			echo '<br />';
    			echo '<input type="Submit" Value="Apply Now" id="btnSubmit">';
    			echo '</form>';
    			
    		}
    	}
    	}
    	}
    	echo '</ul>';
    }
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

    /**
     * Method for loading XML Data from String
     *
     * @param string $sXml
     * @param bool $bOptimize
     */

    public function parseString( $sXml , $bOptimize = false) {
        $oXml = new XMLReader();
        $this -> bOptimize = (bool) $bOptimize;
        try {

            // Set String Containing XML data
            $oXml->XML($sXml);

            // Parse Xml and return result
            return $this->parseXml($oXml);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Method for loading Xml Data from file
     *
     * @param string $sXmlFilePath
     * @param bool $bOptimize
     */
    public function parseFile( $sXmlFilePath , $bOptimize = false ) {
        $oXml = new XMLReader();
        $this -> bOptimize = (bool) $bOptimize;
        try {
            // Open XML file
            $oXml->open($sXmlFilePath);

            // // Parse Xml and return result
            return $this->parseXml($oXml);

        } catch (Exception $e) {
            echo $e->getMessage(). ' | Try open file: '.$sXmlFilePath;
        }
    }

    /**
     * XML Parser
     *
     * @param XMLReader $oXml
     * @return array
     */
    protected function parseXml( XMLReader $oXml ) {
        $aAssocXML = null;
        $iDc = -1;

        while($oXml->read()){
            switch ($oXml->nodeType) {

                case XMLReader::END_ELEMENT:

                    if ($this->bOptimize) {
                        $this->optXml($aAssocXML);
                    }
                    return $aAssocXML;

                case XMLReader::ELEMENT:

                    if(!isset($aAssocXML[$oXml->name])) {
                        if($oXml->hasAttributes) {
                            $aAssocXML[$oXml->name][] = $oXml->isEmptyElement ? '' : $this->parseXML($oXml);
                        } else {
                            if($oXml->isEmptyElement) {
                                $aAssocXML[$oXml->name] = '';
                            } else {
                                $aAssocXML[$oXml->name] = $this->parseXML($oXml);
                            }
                        }
                    } elseif (is_array($aAssocXML[$oXml->name])) {
                        if (!isset($aAssocXML[$oXml->name][0]))
                        {
                            $temp = $aAssocXML[$oXml->name];
                            foreach ($temp as $sKey=>$sValue)
                            unset($aAssocXML[$oXml->name][$sKey]);
                            $aAssocXML[$oXml->name][] = $temp;
                        }

                        if($oXml->hasAttributes) {
                            $aAssocXML[$oXml->name][] = $oXml->isEmptyElement ? '' : $this->parseXML($oXml);
                        } else {
                            if($oXml->isEmptyElement) {
                                $aAssocXML[$oXml->name][] = '';
                            } else {
                                $aAssocXML[$oXml->name][] = $this->parseXML($oXml);
                            }
                        }
                    } else {
                        $mOldVar = $aAssocXML[$oXml->name];
                        $aAssocXML[$oXml->name] = array($mOldVar);
                        if($oXml->hasAttributes) {
                            $aAssocXML[$oXml->name][] = $oXml->isEmptyElement ? '' : $this->parseXML($oXml);
                        } else {
                            if($oXml->isEmptyElement) {
                                $aAssocXML[$oXml->name][] = '';
                            } else {
                                $aAssocXML[$oXml->name][] = $this->parseXML($oXml);
                            }
                        }
                    }

                    if($oXml->hasAttributes) {
                        $mElement =& $aAssocXML[$oXml->name][count($aAssocXML[$oXml->name]) - 1];
                        while($oXml->moveToNextAttribute()) {
                            $mElement[$oXml->name] = $oXml->value;
                        }
                    }
                    break;
                case XMLReader::TEXT:
                case XMLReader::CDATA:

                    $aAssocXML[++$iDc] = $oXml->value;

            }
        }

        return $aAssocXML;
    }

    /**
     * Method to optimize assoc tree.
     * ( Deleting 0 index when element
     *  have one attribute / value )
     *
     * @param array $mData
     */
    public function optXml(&$mData) {
        if (is_array($mData)) {
            if (isset($mData[0]) && count($mData) == 1 ) {
                $mData = $mData[0];
                if (is_array($mData)) {
                    foreach ($mData as &$aSub) {
                        $this->optXml($aSub);
                    }
                }
            } else {
                foreach ($mData as &$aSub) {
                    $this->optXml($aSub);
                }
            }
        }
    }
}
?>