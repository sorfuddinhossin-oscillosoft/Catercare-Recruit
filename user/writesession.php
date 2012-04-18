<?php
session_start();
include_once 'class/class.login.php';
include_once 'class/dbclass.php';
include_once 'class/function.php';
require_once 'class/paypal.class.php';
require_once 'class/class.email.php';
require_once 'class/imageprocessing.php';
require_once 'class/ps_pagination.php';  

include_once 'class/easyphpthumbnail.class.php';
include_once 'config.php';
$log = new logmein();
$shDB =new sh_DB();
$thumb = new easyphpthumbnail;
$imageProcessor = new imageprocessor();
if($_REQUEST['pg']=='logout'){
	$log->logout();
	header( 'Location: '.$base_url);
}
	
if(!$_SESSION['sessionid']){
	randSessionId();
}
//  ##################
if(isset($_REQUEST['secureemail'])){
			  if($_REQUEST['loginas']==3){
				$selectAlbumByEmail = array(		
					'guest_id' => trim($_REQUEST['secureemail']),
					'isowner' => 1
					);
				}else{
					$selectAlbumByEmail = array(		
					'guest_id' => trim($_REQUEST['secureemail']),
					'isowner' => 0
					);
				}
				
							
						$selectAlbumByEmail = $shDB->selectOnMultipleCondition($selectAlbumByEmail,'`album_guest`');
						
						if(!$selectAlbumByEmail){
							echo 'No collection found';
						}else{
							//var_dump($selectAlbumByEmail);
							foreach($selectAlbumByEmail as $albByEmail){
									$selectAlbum = array(		
									'id' => $albByEmail['album_id'],
									'securitycode'  => $_REQUEST['scode']
									);									
									$selectAlbum = $shDB->selectOnMultipleCondition($selectAlbum,'`album`');	
							}							
						}
						if($selectAlbum){
										$_SESSION['email'] = $_REQUEST['secureemail'];
										$_SESSION['scode'] = $_REQUEST['scode'];
										$_SESSION['userlevel'] = $_REQUEST['loginas'];	
						}
			}
			
			
			if(isset($_SESSION['email'])&&isset($_SESSION['scode'])){
				
			  if($_SESSION['userlevel']==3){
				$selectAlbumByEmail = array(		
					'guest_id' => trim($_SESSION['email']),
					'isowner' => 1
					);
				}else{
					$selectAlbumByEmail = array(		
					'guest_id' => trim($_SESSION['email']),
					'isowner' => 0
					);
				}

			$selectAlbumByEmail = $shDB->selectOnMultipleCondition($selectAlbumByEmail,'`album_guest`');
			if(!$selectAlbumByEmail){
							echo 'No collection found';
						}else{
							//var_dump($selectAlbumByEmail);
							foreach($selectAlbumByEmail as $albByEmail){
									$selectAlbum = array(		
									'id' => $albByEmail['album_id'],
									'securitycode'  => $_SESSION['scode']
									);
																		
									$selectAlbum= $shDB->selectOnMultipleCondition($selectAlbum,'`album`');
									//array_push_array($selectAlbum,$shDB->selectOnMultipleCondition($selectAlbum,'`album`'));
									//array_push($selectAlbum, $shDB->selectOnMultipleCondition($selectAlbum,'`album`'));		
							}							
						}
			}

//  ##################

		
if(isset($_REQUEST['loginsubmit'])){
	$loginerrorrrr = '';	
	if($_REQUEST['uname']!=''){
	if(($_REQUEST['loginas']==0)||($_REQUEST['loginas']==2)){
	 $result = $log->login(trim($_REQUEST['uname']),trim($_REQUEST['upass']));
			  if($result==true){
			 	header( 'Location: '.$base_url.'user/');
			 }else{
			 	$loginerrorrrr = ' <p class="greenMessage" style="color:red">Wrong username or password.</p>';		
			 	if(isset($_REQUEST['attempt'])){
			$attemp = $_REQUEST['attempt']+1;
				}else{
					$attemp = 1;
				}
				// header( 'Location: '.$base_url.'index.php?pg=login&attempt='.$attemp) ;
			 }
	}else{
				if($_REQUEST['loginas']==3){
				$selectAlbumByEmail = array(		
					'guest_id' => trim($_REQUEST['uname']),
					'isowner' => 1
					);
				}else{
					$selectAlbumByEmail = array(		
					'guest_id' => trim($_REQUEST['uname']),
					'isowner' => 0
					);
				}
					$selectAlbumByEmail = $shDB->selectOnMultipleCondition($selectAlbumByEmail,'`album_guest`');
					
						if(!$selectAlbumByEmail){
						
						}else{
							
							foreach($selectAlbumByEmail as $albByEmail){
									$selectAlbum = array(		
									'id' => $albByEmail['album_id'],
									'securitycode'  => $_REQUEST['upass']
									);									
									$selectAlbum = $shDB->selectOnMultipleCondition($selectAlbum,'`album`');	
							}							
						}
						if($selectAlbum){
										$_SESSION['email'] = $_REQUEST['uname'];
										$_SESSION['scode'] = $_REQUEST['upass'];
										$_SESSION['userlevel'] = $_REQUEST['loginas'];
										
										
										header( 'Location: '.$base_url.'index.php?pg=invitation') ;	
						}else{
								$loginerrorrrr = ' <p class="greenMessage" style="color:red">Wrong username or password.</p>';	
						}
		}
	}
			// $result = $log->login($_REQUEST['username'], $_REQUEST['password']);
			
	/*
			 $result = $log->login(trim($_REQUEST['uname']),trim($_REQUEST['upass']));
			  if($result==true){
			 	header( 'Location: '.$base_url.'user/');
			 }else{
			 	if(isset($_REQUEST['attempt'])){
			$attemp = $_REQUEST['attempt']+1;
				}else{
					$attemp = 1;
				}
				header( 'Location: '.$base_url.'index.php?pg=login&attempt='.$attemp) ;
			 }
			 
			 */
}

// settings data
$settingsdata = array(		
							'id' => 1
							);									
$settings = $shDB->selectOnMultipleCondition($settingsdata,'`settings`');
$settings = $settings[0];



include_once 'header.php';
//$log->cratetable('logon');
if(!$_REQUEST['pg']){
include_once 'homecontent.php';
}else{
	include_once $_REQUEST['pg'].'.php';
} 
include_once 'footer.php'; 
?>
