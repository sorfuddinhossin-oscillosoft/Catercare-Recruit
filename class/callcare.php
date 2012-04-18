<?php
$api = 'dwCZl0iRgRal0V2pBDZKwLgAIqOUw7fQkQaMGWeIdlI$';
$ticket = 'b5f84c766e0959258cabe7d5b307dd6e';

$noOfRecords = 2;

$fromIndex = 1;
if(isset($_REQUEST['fromIndex'])){
$fromIndex = $_REQUEST['fromIndex'];
}else{
	$fromIndex = 1;
}
$toIndex =$fromIndex+$noOfRecords;


//$toIndex = $fromIndex+$noOfRecords;

//$toIndex = $noOfRecords +$fromIndex;
echo '<a href="http://jobs.oscillosoft.com/class/callcare.php?fromIndex='.$toIndex.'">NEXT</a>';

require_once 'xml.class.php';
require_once 'mycurl.php';
	
$myCurl1234 = new CURL();

	
	
	$apiRequestURL = 'https://crm.zoho.com/crm/private/xml/SalesOrders/getRecords?apikey='.$api.'&ticket='.$ticket.'&sortColumnString=Created%20Time&sortOrderString=desc&fromIndex='.$fromIndex.'&toIndex='.$toIndex;
	//$apiRequestURL = 'https://crm.zoho.com/crm/private/xml/SalesOrders/getRecordById?apikey='.$api.'&ticket='.$ticket.'&newFormat=2&selectColumns=All&id=245289000000565123';
	$xml = new Xml2Assoc();
	
	
	$practice = $xml->parseFile($apiRequestURL, false);
	
		// var_dump($practice);
	foreach ($practice['response'][0]['result']['SalesOrders']['row'] as $value) {
		
		//Update XML
		$postedData = '<SalesOrders>';
		$postedData .= '<row no="1">';
			
						
		
		
		//Sales order information
		
		
		
		$RenewalDate = '';
		
		
		
		// Mobile Broadband Service
		$mobileBroadBandServiceType = '';
		$MobileBroadbandNumber = '';
		$MobileBroadbandUser = '';
		$MobileBroadbandSIM = '';
		$DeviceType = '';
		$MobileBroadbandPUK = '';
		$DeviceIMEI = '';
		$MobileBroadbandPassword = '';
		$MobileBroadbandPIN = '';
		$MobileBroadbandRenewalDate = '';
		$MobileBroadbandDataPlans = '';
		$MobileBroadbandPortingDetails = '';
		
		//Mobile Service

		$MobileServiceType = '';
		$MobileBonusOption = '';
		$MobileServicesNumber = '';
		$MROAmount = '';
		$HandsetType = ''; 
		$HandsetIMEI = '';
		$MobileUser = '';
		$SIM = '';
		$PUK = '';
		$PIN = '';
		$Password = '';
		$Plan = '';
		$DataPlan = '';
		$MobileServiceRenewalDate = '';
		$TransferofOwnership = '';
		$InternationalRoaming = '';
		$PortingDetails = '';
		
		// Business Broadband Renewal Date
		$BusinessBroadbandRenewalDate = '';
		
		//Service Type
		$ProductType = '';
		$RenewalDateExpiryTriggerDate = '';
		$LandlineAccount = '';
		$TRNNumber = '';
		
		//landline 
		
		$Landlinerenewaldate = '';
		$TelstraOrderReferenceNumber = '';
		$ExistingTelstraAccountNumber = '';
		$Subject = '';
			foreach($value['FL'] as $field){
				
				// Mobile BroadBand
					if($field['val']=='Mobile Broadband Service Type'){
						if($field[0]=='null'){
							$mobileBroadBandServiceType = '';
						}else{
					 		$mobileBroadBandServiceType =  $field[0];
					 		
					 	}
					}
			if($field['val']=='Subject'){
				if($field[0]=='null'){
					$Subject = '';
				}else{
					 		$Subject =  $field[0];
					 	}
			}				 	

			
					if($field['val']=='Mobile Broadband Number'){
						if($field[0]=='null'){
							$MobileBroadbandNumber = '';
						}else{
					 		$MobileBroadbandNumber =  $field[0];
					 	}
					}
					if($field['val']=='Mobile Broadband User'){
						if($field[0]=='null'){
							$MobileBroadbandUser = '';
						}else{
					 		$MobileBroadbandUser =  $field[0];
					 	}
					}
					if($field['val']=='Mobile Broadband SIM'){
						if($field[0]=='null'){
							$MobileBroadbandSIM = '';
						}else{
					 		$MobileBroadbandSIM =  $field[0];
					 	}
					}
					if($field['val']=='Device Type'){
						if($field[0]=='null'){
							$DeviceType = '';
						}else{
					 		$DeviceType =  $field[0];
					 	}
					}
					 	
					if($field['val']=='Mobile Broadband PUK'){
							if($field[0]=='null'){
								$MobileBroadbandPUK = '';
							}else{
					 		$MobileBroadbandPUK =  $field[0];
					 	}
					}
					if($field['val']=='Device IMEI'){
						if($field[0]=='null'){
							$DeviceIMEI = '';
						}else{
					 		$DeviceIMEI =  $field[0];
					 	}
					}
					if($field['val']=='Mobile Broadband Password'){
						if($field[0]=='null'){
							$MobileBroadbandPassword = '';
						}else{
					 		$MobileBroadbandPassword =  $field[0];
					 	}
					}
					 	
					if($field['val']=='Mobile Broadband PIN'){
						if($field[0]=='null'){
							$MobileBroadbandPIN = '';
						}else{
					 		$MobileBroadbandPIN =  $field[0];
					 	}
					}
					if($field['val']=='Mobile Broadband Renewal Date'){
						if($field[0]=='null'){
							$MobileBroadbandRenewalDate = '';
						}else{
					 		$MobileBroadbandRenewalDate =  $field[0];
					 	}
					}
					 	
					if($field['val']=='Mobile Broadband Data Plans'){
						if($field[0]=='null'){
							$MobileBroadbandDataPlans = '';
						}else{						
					 		$MobileBroadbandDataPlans =  $field[0];
					 	}
					 	
					if($field['val']=='Mobile Broadband Porting Details'){
						if($field[0]=='null'){
							$MobileBroadbandPortingDetails = '';
						}else{
					 		$MobileBroadbandPortingDetails =  $field[0];
					 	}
					}
					 	
					 	
					 	
					 //Mobile Service
					 
					if($field['val']=='Mobile Service Type'){
						if($field[0]=='null'){
							$MobileServiceType = '';
						}else{
					
					 		$MobileServiceType =  $field[0];
					 	}
					}
					if($field['val']=='Mobile Bonus Option'){
						if($field[0]=='null'){
							$MobileBonusOption = '';
						}else{
							$MobileBonusOption =  $field[0];
						}
					}
					 		
					 	}
					if($field['val']=='Mobile Services Number'){
						if($field[0]=='null'){
							$MobileServicesNumber = '';
						}else{
					 		$MobileServicesNumber =  $field[0];
					 	}
					}
					if($field['val']=='MRO Amount'){
						if($field[0]=='null'){
							$MROAmount = '';
						}else{
					 		$MROAmount =  $field[0];
					 	}
					}
					if($field['val']=='Handset Type'){
						if($field[0]=='null'){
							$HandsetType = '';
						}else{
					 		$HandsetType =  $field[0];
					 	}
					}
					if($field['val']=='Handset IMEI'){
						if($field[0]=='null'){
							$HandsetIMEI = '';
						}else{
					 		$HandsetIMEI =  $field[0];
					 	}
					}
					if($field['val']=='Mobile User'){
						if($field[0]=='null'){
							$MobileUser = '';
						}else{
					 		$MobileUser =  $field[0];
					 	}
					} 	
					if($field['val']=='SIM'){
						if($field[0]=='null'){
							$SIM = '';
						}else{
					 		$SIM =  $field[0];
					 	}
					}	
					if($field['val']=='PUK'){
						if($field[0]=='null'){
							$PUK = '';
						}else{
					 		$PUK =  $field[0];
					 	}
					}
					 
					if($field['val']=='PIN'){
						if($field[0]=='null'){
							$PIN = '';
						}else{
					 		$PIN =  $field[0];
					 	}
					}
					if($field['val']=='Password'){
						if($field[0]=='null'){
							$Password = '';
						}else{
					 		$Password =  $field[0];
					 	}
					}
					 	
					if($field['val']=='Plan'){
						if($field[0]=='null'){
							$Plan = '';
						}else{
					 		$Plan =  $field[0];
					 	}
					}
					if($field['val']=='Data Plan'){
						if($field[0]=='null'){
							$DataPlan = '';
						}else{
					 		$DataPlan =  $field[0];
					 	}
					}
					 	
					if($field['val']=='Mobile Service Renewal Date'){
						if($field[0]=='null'){
							$MobileServiceRenewalDate = '';
						}else{
					 		$MobileServiceRenewalDate =  $field[0];
					 	}
					}
					if($field['val']=='Transfer of Ownership'){
						if($field[0]=='null'){
							$TransferofOwnership = '';
						}else{
					 		$TransferofOwnership =  $field[0];
					 	}
					}
					 	
					if($field['val']=='International Roaming'){
						if($field[0]=='null'){
							$InternationalRoaming = '';
						}else{
					 		$InternationalRoaming =  $field[0];
					 	}
					}
					if($field['val']=='Porting Details'){
						if($field[0]=='null'){
							$InternationalRoaming = '';
						}else{
					 		$InternationalRoaming =  $field[0];
					 	}
					}
					 	
					 	
			// Sales Order Information
					if($field['val']=='Renewal Date'){
						if($field[0]=='null'){
							$RenewalDate = '';
						}else{
					 		$RenewalDate =  $field[0];
					 	}
					}
			
			//Business Broadband Renewal Date
				if($field['val']=='Business Broadband Renewal Date'){
					if($field[0]=='null'){
						$BusinessBroadbandRenewalDate = '';
					}else{
					 		$BusinessBroadbandRenewalDate =  $field[0];
					 	}
				}

			//Service Summery
				if($field['val']=='Renewal Date Expiry Trigger Date'){
					if($field[0]=='null'){
						$RenewalDateExpiryTriggerDate = '';
					}else{
					 		$RenewalDateExpiryTriggerDate =  $field[0];
					 	}
				}
				if($field['val']=='Product Type'){
					if($field[0]=='null'){
						$ProductType = '';
					}else{
					 		$ProductType =  $field[0];
					 	}
				}
				if($field['val']=='Landline Account'){
					if($field[0]=='null'){
						$LandlineAccount = '';
					}else{
					 		$LandlineAccount =  $field[0];
					 	}
				}
				if($field['val']=='TRN Number'){
					if($field[0]=='null'){
						$TRNNumber = '';
					}else{
					 		$TRNNumber =  $field[0];
					 	}
				}
					 	
					 	
			//Land line			
			if($field['val']=='Landline renewal date'){
				if($field[0]=='null'){
					$Landlinerenewaldate = '';
				}else{
					 		$Landlinerenewaldate =  $field[0];
					 	}
			}
			if($field['val']=='Telstra Order Reference Number'){
				if($field[0]=='null'){
					$TelstraOrderReferenceNumber = '';
				}else{
			
					 		$TelstraOrderReferenceNumber =  $field[0];
					 	}
			}
			if($field['val']=='Existing Telstra Account Number'){
				if($field[0]=='null'){
					$ExistingTelstraAccountNumber = '';
				}else{
					 		$ExistingTelstraAccountNumber =  $field[0];
					 	}
			}
			if($field['val']=='SALESORDERID'){
				if($field[0]=='null'){
					$SALESORDERID = '';
				}else{
					 		$SALESORDERID =  $field[0];
					 	}
						} //field backet closed
			}
		echo '<h3>Mobile Broadband = > Mobile Service</h3>';
		echo $SALESORDERID.'('.$Subject.')<Br />';
		echo $RenewalDate.'<br />';
		echo $ProductType;
		echo '<hr />';
		
		if(($MobileServiceType=='')||($MobileServiceType=='null')){
		$postedData .= '<FL val="Mobile Service Type">'.$MobileServiceType.$mobileBroadBandServiceType.'</FL>';
		}
		
		if(($MobileServicesNumber=='')||($MobileServicesNumber=='null')){
		$postedData .= '<FL val="Mobile Services Number">'.$MobileBroadbandNumber.$MobileServicesNumber.'</FL>';
		}
		
		if(($MobileUser=='')||($MobileUser=='null')){
		$postedData .= '<FL val="Mobile User">'.$MobileUser.$MobileBroadbandUser.'</FL>';
		}
		
		if(($SIM=='')||($SIM=='null')){
		$postedData .= '<FL val="SIM">'.$MobileBroadbandSIM.$SIM.'</FL>';
		}
		
		if(($HandsetType=='')||($HandsetType=='null')){
		$postedData .= '<FL val="Handset Type">'.$DeviceType.$HandsetType.'</FL>';
		}

		if(($PUK=='')||($PUK=='null')){
		$postedData .= '<FL val="PUK">'.$MobileBroadbandPUK.$PUK.'</FL>';
		}
		
		if(($HandsetIMEI=='')||($HandsetIMEI=='null')){
		$postedData .= '<FL val="Handset IMEI">'.$DeviceIMEI.$HandsetIMEI.'</FL>';
		}
		
		if(($Password=='')||($Password=='null')){
		$postedData .= '<FL val="Password">'.$MobileBroadbandPassword.$Password.'</FL>';
		}
		
		if(($PIN=='')||($PIN=='null')){
		$postedData .= '<FL val="PIN">'.$MobileBroadbandPIN.$PIN.'</FL>';
		}
		
		if(($DataPlan=='')||($DataPlan=='null')){
		$postedData .= '<FL val="Data Plan">'.$MobileBroadbandDataPlans.$DataPlan.'</FL>';
		}
		
		if(($InternationalRoaming=='')||($InternationalRoaming=='null')){
		$postedData .= '<FL val="Porting Details">'.$MobileBroadbandPortingDetails.$InternationalRoaming.'</FL>';
		}
		
		
		if(($LandlineAccount=='')||($LandlineAccount=='null')){
	 	$postedData .= '<FL val="Landline Account">'.$LandlineAccount.$ExistingTelstraAccountNumber.'</FL>';
		}
	
		if(($TRNNumber=='')||($TRNNumber=='null')){
	 	$postedData .= '<FL val="TRN Number">'.$TRNNumber.$TelstraOrderReferenceNumber.'</FL>';
		}
	 	
		
		if(($RenewalDate=='')||($RenewalDate=='null')){
	 	$postedData .= '<FL val="Renewal Date">'.$Landlinerenewaldate.$BusinessBroadbandRenewalDate.$RenewalDate.$MobileServiceRenewalDate.$MobileBroadbandRenewalDate.'</FL>';
			}
			
			
		if($ProductType=='Mobile Service'){
			// 2011-06-20
			if($RenewalDate!=''){
			$RenewalDate=strtotime($RenewalDate);
			$RenewalDate =  date('Y-m-d',strtotime('-58 days', $RenewalDate));
			}else{
				$RenewalDate='';
			}
			if(($RenewalDateExpiryTriggerDate=='')||($RenewalDateExpiryTriggerDate=='null')){
			 $postedData .= '<FL val="Renewal Date Expiry Trigger Date">'.$RenewalDate.'</FL>';
			}
		}else{
			
		if($RenewalDate!=''){
			$RenewalDate=strtotime($RenewalDate);
			$RenewalDate =  date('Y-m-d',strtotime('-88 days', $RenewalDate));
			}else{
				$RenewalDate='';
			}  
			if(($RenewalDateExpiryTriggerDate=='')||($RenewalDateExpiryTriggerDate=='null')){
				$postedData .= '<FL val="Renewal Date Expiry Trigger Date">'.$RenewalDate.'</FL>';
			}
		} 
		
	echo '<hr />';			 	
	$postedData .= '</row>';
	$postedData .= '</SalesOrders>';	
	 $postData = array(
       'xmlData' => $postedData
    );
	//$result = $myCurl1234->get('https://crm.zoho.com/crm/private/xml/SalesOrders/updateRecords?newFormat=1&apikey='.$api.'&ticket='.$ticket.'&id='.$SALESORDERID.'&xmlData='.urlencode($postedData));
	$result = $myCurl1234->post('https://crm.zoho.com/crm/private/xml/SalesOrders/updateRecords?newFormat=1&apikey='.$api.'&ticket='.$ticket.'&id='.$SALESORDERID,$postData);
	var_dump($result);		 	
	}

?>
<script>
	function moretext(nextpage){
		window.location = 'http://jobs.oscillosoft.com/class/callcare.php?fromIndex='+nextpage;
	}
	</script>
	<?php if($toIndex<6000){?>
	<!-- 
	 <script>setTimeout("moretext('<?=$toIndex;?>')",3000);</script> 
	  -->
	<?php }?>
