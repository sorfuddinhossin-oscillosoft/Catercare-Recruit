<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">  
<title>Zoho to Website</title> 
<link rel="shortcut icon" href="images/favicon.ico">  
<link href="../css/style.css" rel="stylesheet" type="text/css">  
<style type="text/css">
@import "../datepicker/jquery.datepick.css";
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<script type="text/javascript" src="../datepicker/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	//$('.datepicker').datepick();
	//$('#inlineDatepicker').datepick({onSelect: showDate});
	// $('.datepicker').datepick({dateFormat: 'yyyy-mm-dd'});

	$('.datepicker').datepick({dateFormat: 'dd-mm-yyyy'});
});

</script>

<script type="text/javascript" src="../ckeditor/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../ckeditor/ckeditor/samples/sample.js"></script>
<link href="../ckeditor/ckeditor/samples/sample.css" rel="stylesheet" type="text/css"> 
<!-- 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>  

<script type="text/javascript" src="../js/jquery-ui-1.7.1.custom.min.js"></script>
 -->
<script type="text/javascript" src="../js/function.js"></script>
 

</head>
<body>
<div id="header">
<!-- 
<div class="topround">		
	<div class="topleft"></div>		
	<div class="topmiddle"></div>		
	<div class="topright"></div>	
</div>
 -->		
<div class="logoContainer">		
	<div class="oscLogo">			
	<img src="../images/cclogo.jpg" width="65" alt="Oscillosoft Pty Limited">		
	</div>		
	<div class="topMenu">
	<table width="100%">
	<tr>
	<td align="right">			
	<ul style="margin-left:273px;">						
		
	<li><a class="wcome">Welcome <?php echo $_SESSION['name'];?></a></li>				
	<li><a href="logout.php" >Logout</a></li>			
	</ul>	
	
	</td>
	</tr>
	<?php 
	$dashboard = '';
	$jobpost = '';
	$joblist = '';
	$logreport = '';
	
	
	switch($_REQUEST['pg']){
		case 'jobpost':
			$jobpost = 'current';
			break;
		case 'joblist':
			$joblist = 'current';
			break;
		case 'logreport':
			$logreport = 'current';
			break;
		case 'logview':
				$logreport = 'current';
				break;
		default:
			$dashboard = 'current';
			break;			
	}
	
	?>
	<tr>
	<td align="right">
	<ul style="margin-left:173px;">				
	<li><a href="index.php" class="<?php echo $dashboard;?>">Dashboard</a></li>	
	<li><a href="index.php?pg=jobpost" class="<?php echo $jobpost;?>" >Post Job</a></li>	
	<li><a href="index.php?pg=joblist"  class="<?php echo $joblist;?>">Job List</a></li>	
	<li><a href="index.php?pg=logreport" class="<?php echo $logreport;?>">Log Report</a></li>		
			
	</ul>
			</td>
			</tr>
			</table>	
	</div>	
</div></div>
<div id="main">
<div id="mainbottom">
<div id="bodyContainter"> 