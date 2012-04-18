<?php 
$isUpdateSubmit = 0;
if(isset($_REQUEST['postingtitle'])){
if($_REQUEST['publishinwebsite']){
		$publishedinWebsite = 1;
	}else{
		$publishedinWebsite = 0;
	}
$seekJobPosted = array(		
'job_title' => trim($_REQUEST['postingtitle']),
'open_date' => date('Y-m-d',strtotime(trim($_REQUEST['openDate']))),
'target_date' => date('Y-m-d',strtotime(trim($_REQUEST['targetDate']))),
'introduction' => trim($_REQUEST['introduction']),
'job_description' => trim($_REQUEST['description']),
'job_opening_status' => trim($_REQUEST['jobopeningstatus']),
'job_type' => trim($_REQUEST['jobType']),
'seek_job_type' => trim($_REQUEST['seekjobType']),
'no_of_position' => trim($_REQUEST['noofposition']),
'published_in' => trim($_REQUEST['publishedin']),
'selling_point_one' => trim($_REQUEST['sellingpointone']),
'selling_point_two' => trim($_REQUEST['sellingpointtwo']),
'selling_point_three' => trim($_REQUEST['sellingpointthree']),
'salary_range' => trim($_REQUEST['salaryRange']),
'additional_sal_text' => trim($_REQUEST['addSalText']),
'job_opening_id' => trim($_REQUEST['jobopeningid']),
'state' => trim($_REQUEST['state']),
'seek_location' => trim($_REQUEST['seekLocation']),
'seek_classification' => trim($_REQUEST['seekClassification']),
'seek_sub_classification' => trim($_REQUEST['seekSubClassification']),
'country' => trim($_REQUEST['country']),
'posted_on' => date('Y-m-d',strtotime(trim($_REQUEST['postedon']))),
'publish_in_website' => $publishedinWebsite
);						
$jobId = $shDB->update($seekJobPosted,$_REQUEST['id'],'jobs_posted');

if($jobId){
	log_report($_REQUEST['id'],'update');
	$isUpdateSubmit = 1;
$jobselectid = array(
							'id' => $_REQUEST['id']
							);
						$Jobs = $shDB->selectOnMultipleCondition($jobselectid,'`jobs_posted`');
						$Jobs = $Jobs[0];
	if($Jobs['publish_in_website']==1){
		$publishedinwebsite = true;
	}else{
		$publishedinwebsite = false;
	}
	
	$thiszohoId = $Jobs['zohoid'];

	$string = '<JobOpenings>';
	$string .= '<row no="1">';
	$string .= '<FL val="Published in website">'.$publishedinwebsite.'</FL>';
	$string .= '<FL val="Date opened">'.date('m-d-Y',strtotime($Jobs['open_date'])).'</FL>';
	$string .= '<FL val="Target date">'.date('m-d-Y',strtotime($Jobs['target_date'])).'</FL>';
	$string .= '<FL val="Job opening status">'.$Jobs['job_opening_status'].'</FL>';
	$string .= '<FL val="Job type">'.$Jobs['job_type'].'</FL>';
	$string .= '<FL val="SEEK Job Type">'.$Jobs['seek_job_type'].'</FL>';
	$string .= '<FL val="Number of positions">'.$Jobs['no_of_position'].'</FL>';
	// $string .= '<FL val="Department">'.$Jobs['department'].'</FL>';
	
	// $string .= '<FL val="Hiring manager">'.$Jobs['hiring_manager'].'</FL>';
	$string .= '<FL val="Introduction"><![CDATA['.$Jobs['introduction'].']]></FL>';
	$string .= '<FL val="SEEK Description"><![CDATA['.$Jobs['job_description'].']]></FL>';
	$string .= '<FL val="Classification"><![CDATA['.$Jobs['seek_classification'].']]></FL>';
	$string .= '<FL val="Sub Classification"><![CDATA['.$Jobs['seek_sub_classification'].']]></FL>';
	$string .= '<FL val="Published In">'.$Jobs['published_in'].'</FL>';	
	$string .= '<FL val="Selling Point 1"><![CDATA['.$Jobs['selling_point_one'].']]></FL>';
	$string .= '<FL val="Selling Point 2"><![CDATA['.$Jobs['selling_point_two'].']]></FL>';
	$string .= '<FL val="Selling Point 3"><![CDATA['.$Jobs['selling_point_three'].']]></FL>';
	
	$string .= '<FL val="Salary Range">'.$Jobs['salary_range'].'</FL>';
	$string .= '<FL val="Additional Salary Text">'.$Jobs['additional_sal_text'].'</FL>';
	// "<![CDATA[" and ends with "]]>"
	$string .= '<FL val="Posting title"><![CDATA['.$Jobs['job_title'].']]></FL>';	
	$string .= '<FL val="State">'.$Jobs['state'].'</FL>';
	$string .= '<FL val="SEEK Location">'.$Jobs['seek_location'].'</FL>';
	$string .= '<FL val="Country">'.$Jobs['country'].'</FL>';
	$string .= '<FL val="Posted on">'.date('m-d-Y',strtotime($Jobs['posted_on'])).'</FL>';
	
	$string .= '</row>';
	$string .= '</JobOpenings>';	
	
	$postData = array(
       'xmlData' => $string
    );
    
    $crmCredential = $user->zohosettings(1);
   
   $api = $crmCredential['api'];
     $ticket = $crmCredential['ticket'];
    
   //  $url = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/addRecords?apikey='.$recruitAPI.'&ticket='.$newTicket;
   if($thiszohoId==''){
    $url = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/addRecords?apikey='.$api.'&ticket='.$ticket;
    $success = $myCurl->post($url, $postData);
	
	$successResult = $xml->parseString($success, false);
	$result = $successResult['response'][0]['result']['recorddetail']['FL'][0][0];
	
	var_dump($result);
	
	// update zoho id
	
	$seekJobPosted = array(		
	'zohoid' => $result
	);	
					
	$jobId = $shDB->update($seekJobPosted,$_REQUEST['id'],'jobs_posted');

   }else{
   	 $url = 'https://recruit.zoho.com/ats/private/xml/JobOpenings/updateRecords?apikey='.$api.'&ticket='.$ticket.'&id='.$thiszohoId;
   	$success = $myCurl->post($url, $postData);
	
	$successResult = $xml->parseString($success, false);
	
   }
	
	$result = $successResult['response'][0]['result']['recorddetail']['FL'][0][0];
	
	
	
}else{
	$isUpdateSubmit = 2;
}
}

// select job for edit by id
	$jobid = array(
							'id' => $_REQUEST['id']
							);
						$Jobs = $shDB->selectOnMultipleCondition($jobid,'`jobs_posted`');
						$Jobs = $Jobs[0];

$jobOpeningStatus = array('Waiting for Approval','In-progress','On-Hold','Filled','Cancelled','Declined');
$jobType = array('Casual','Full time','Part time','Temporary','Contract','Temporary to Permanent');
$department = array('CATER CARE AUSTRALIA PTY LTD');
$hiringManager = array('MARIAM KHOSHABA (0465KHOM)');
$assignedRecruiter = array('MARIAM KHOSHABA (0465KHOM)');
$publishedIn = array('','Publish in Intranet Only','Website','Website and SEEK');
$salaryRange = array('1-39999','40000-59999','60000-79999','80000-119999','120000-199999','200000-200000+');
$state = array('New South Wales','Northern Territory','Queensland','South Australia','Victoria', 'Western Australia');

$seekJobType = array(
		'CasualVacation' => 'Casual/Vacation',
		'ContractTemp' => 'Contract/Temp',
		'FullTime' => 'Full Time',
		'PartTime' => 'Part Time',
	);
	
// seek location
$seekLocation = array(		
							'Type' => trim($_REQUEST['Location'])
							);
							
						$seekLocation = $shDB->selectOnMultipleCondition('','`seek_location`');
					$seekClassification = array(		
							'status' => 1
							);
							
							
						$seekClassification = $shDB->selectOnMultipleCondition($seekClassification,'`classification`');
					

$country_list = array(
		"Afghanistan",
		"Albania",
		"Algeria",
		"Andorra",
		"Angola",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bhutan",
		"Bolivia",
		"Bosnia and Herzegovina",
		"Botswana",
		"Brazil",
		"Brunei",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Colombi",
		"Comoros",
		"Congo (Brazzaville)",
		"Congo",
		"Costa Rica",
		"Cote d'Ivoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor (Timor Timur)",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Fiji",
		"Finland",
		"France",
		"Gabon",
		"Gambia, The",
		"Georgia",
		"Germany",
		"Ghana",
		"Greece",
		"Grenada",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Honduras",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran",
		"Iraq",
		"Ireland",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, North",
		"Korea, South",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Mauritania",
		"Mauritius",
		"Mexico",
		"Micronesia",
		"Moldova",
		"Monaco",
		"Mongolia",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepa",
		"Netherlands",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Poland",
		"Portugal",
		"Qatar",
		"Romania",
		"Russia",
		"Rwanda",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Vincent",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"Spain",
		"Sri Lanka",
		"Sudan",
		"Suriname",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syria",
		"Taiwan",
		"Tajikistan",
		"Tanzania",
		"Thailand",
		"Togo",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom",
		"United States",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City",
		"Venezuela",
		"Vietnam",
		"Yemen",
		"Zambia",
		"Zimbabwe"
	);

?>
<div id="userRightDiv">
	<h1>Job Post <span>(This module will post the job to Zoho Recruit)</span></h1>
	<div class="userContent">
		
	 <?php if($isUpdateSubmit == 0 ){?>
		<form action="" method="POST" id="formJobPost">
		<label>Posting title  <span style="color:red">*</span></label>
		<input type="text" name="postingtitle"  id="postingtitle"  maxlength="80"  value="<?php echo $Jobs['job_title'];?>"><br />
		<label>Open Date</label>
		<input type="text" name="openDate"   style="width:160px;" class="datepicker" value="<?php echo date('d-m-Y',strtotime($Jobs['open_date']));?>"><br />
		<label>Target Date</label>
		<input type="text" name="targetDate"  style="width:160px;" class="datepicker"  value="<?php echo date('d-m-Y',strtotime($Jobs['target_date']));?>"><br />
		<label>Introduction <span>(Website only)</span>&nbsp;<span style="color:red">*</span>&nbsp; Character left : <span style="color:red;font-weight:bold" id="introCounter"></span></label>
		<textarea name="introduction" id="introduction"  maxlength="150"  onkeyup="introCounter()"   style="width:746px;height:120px;"><?php echo $Jobs['introduction'];?></textarea><br />
		<label>Job Description <span>(Both website and SEEK)</span>&nbsp;<span style="color:red">*</span>&nbsp; Character left : <span style="color:red;font-weight:bold" id="descCounter">5000</span></label>
		<textarea name="description" id="description" class="editor1"><?php echo $Jobs['job_description'];?></textarea><br />
		<label>Job Opening Status</label>
		
		<select name="jobopeningstatus">
			<?php foreach($jobOpeningStatus as $jOS){
				if($Jobs['job_opening_status']==$jOS){ ?>
					<option value="<?php echo $jOS;?>"  selected="yes"><?php echo $Jobs['job_opening_status'];?></option>
				<?php }else{?>
					<option value="<?php echo $jOS;?>"><?php echo $jOS;?></option>
			<?php 	}
			} ?>
		</select><br />
		<label>Job Type <span style="color:red">*</span></label>
		<select name="jobType">
			<?php foreach($jobType as $jType){
			if($Jobs['job_type']==$jType){ ?>
					<option value="<?php echo $jType;?>" selected="yes" ><?php echo $jType;?></option>
			<?php }else{ ?>
					<option value="<?php echo $jType;?>" ><?php echo $jType;?></option>
			<?php }
				 } ?>
		</select><br />
		<label>SEEK Job Type <span style="color:red">*</span></label>
		<select name="seekjobType">
			<?php foreach($seekJobType as $key => $value){
			if($Jobs['seek_job_type']==$key){ ?>
					<option value="<?php echo $key;?>" selected="yes"><?php echo $value;?></option>
				<?php }else{  ?>
					<option value="<?php echo $key;?>"> <?php echo $value;?></option>
				<?php }
				?>
			
			<?php } ?>
		</select><br />
		<label>No of Position <span style="color:red">*</span></label>
		<select name="noofposition">
			<?php for($i=1;$i<=10;$i++){
			if($Jobs['no_of_position']==$i){ 
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}  ?>
			
				<option value="<?php echo $i;?>" <?php echo $checked;?>><?php echo $i;?></option>
				
		<?php 	} ?>
		</select><br />
		
		
		<!-- 
		<input type="text" name="noofposition"   value="<?php echo $Jobs['no_of_position'];?>"><br />
		<label>Department <span style="color:red">*</span></label>
		<select name="department">
			<?php foreach($department as $depart){
					if($Jobs['department']==$depart){
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}
				?>
			<option value="<?php echo $depart;?>"  <?php echo $checked;?>><?php echo $depart;?></option>
			<?php } ?>
		</select><br />
		<label>Hiring Manager <span style="color:red">*</span></label>
		<select name="hiringmanager">
			<?php foreach($hiringManager as $hireManager){
			if($Jobs['hiring_manager']==$hireManager){
					$checked = 'selected="yes"';
				}else{
					$checked = 'selected="yes"';
				}
				?>
			<option value="<?php echo $hireManager;?>"  <?php echo $checked;?>><?php echo $hireManager;?></option>
			<?php } ?>
		</select><br />
		<label>Assigned recruiter <span style="color:red">*</span></label>
		<select name="assignedRecruiter">
			<?php foreach($assignedRecruiter as $assignedRec){
			if($Jobs['assigned_recruiter']==$assignedRec){
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}
			?>
			<option value="<?php echo $assignedRec;?>"  <?php echo $checked;?>><?php echo $assignedRec;?></option>
			<?php } ?>
		</select><br />
		 -->
		<label>Published In <span style="color:red">*</span></label>
		<select name="publishedin"  id="publishedin">
			<?php foreach($publishedIn as $publish){
			if($Jobs['published_in']==$publish){
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}
				?>
			<option value="<?php echo $publish;?>" <?php echo $checked;?>><?php echo $publish;?></option>
			<?php } ?>
		</select><br />
		<label>Selling point one <span style="color:red">*</span></label>
		<input type="text"  name="sellingpointone"  maxlength="80"  value="<?php echo $Jobs['selling_point_one']; ?>" id="sellingpointone" onkeyup="javascript: doCheckSpChar('sellingpointone');"><br />
		<label>Selling point two <span style="color:red">*</span></label>
		<input type="text" name="sellingpointtwo"  maxlength="80"   value="<?php echo $Jobs['selling_point_two']; ?>" id="sellingpointtwo" onkeyup="javascript: doCheckSpChar('sellingpointtwo');"><br />
		<label>Selling point three <span style="color:red">*</span></label>
		<input type="text" name="sellingpointthree"   maxlength="80"  value="<?php echo $Jobs['selling_point_three']; ?>" id="sellingpointthree" onkeyup="javascript: doCheckSpChar('sellingpointthree');"><br />
		<label>Salary Range <span style="color:red">*</span></label>
		<select name="salaryRange">
			<?php foreach($salaryRange as $salRan){
				if($Jobs['salary_range']==$salRan){
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}
			?>
			<option value="<?php echo $salRan;?>"  <?php echo $checked;?> ><?php echo $salRan;?></option>
			<?php } ?>
		</select><br />
		<label>Additional Salary Text</label>
		<input type="text" name="addSalText"  value="<?php echo $Jobs['additional_sal_text']; ?>"   id="addSalText" onkeyup="javascript: doCheckSpChar('addSalText');"><br />
				
		<label>State <span style="color:red">*</span></label>
		<select name="state">
			<?php foreach($state as $ste){
			if($Jobs['state']==$ste){
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}
			?>
			<option value="<?php echo $ste;?>" <?php echo $checked;?>><?php echo $ste;?></option>
			<?php } ?>
		</select><br />
		<label>Seek Location <span style="color:red">*</span></label>
		<select name="seekLocation">
			<?php foreach($seekLocation as $sLoc){
				if($Jobs['seek_location']==$sLoc['Xml_ID']){
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}
				?>
			<option value="<?php echo $sLoc['Xml_ID'];?>"  <?php echo $checked;?> ><?php echo $sLoc['Description'];?></option>
			<?php } ?>
		</select><br />
		
		<label>Seek Classification <span style="color:red">*</span></label>
		<select name="seekClassification" id="seekClassification">
			<option value="">Select a Classification</option>
			<?php foreach($seekClassification as $sClassification){
				if($Jobs['seek_classification']==$sClassification['Xml_ID']){
					$seekClassificationId = $sClassification['Xml_ID'];
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}
				?>
			<option value="<?php echo $sClassification['Xml_ID'];?>"  <?php echo $checked;?>><?php echo $sClassification['Description'];?></option>
			<?php } ?>
		</select><br />
		<?php 
			
			$seekSubClassification = array(		
							'Parent_Xml_ID' => $seekClassificationId,
							'status' => 1
							);
							$seekSubClassification = $shDB->selectOnMultipleCondition($seekSubClassification,'`subclassification`'); 
		?>
		<label>Seek Sub-Classification <span style="color:red">*</span></label>
		<select name="seekSubClassification" id="seekSubClassification">
			<option value="">Select sub classification</option>
			<?php foreach($seekSubClassification as $seekSubClass){
			if($Jobs['seek_sub_classification']==$seekSubClass['Xml_ID']){
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}
				?>
			<option value="<?php echo $seekSubClass['Xml_ID']?>"  <?php echo $checked;?>><?php echo $seekSubClass['Description']?></option>
			<?php } ?>
		</select><br />
		<label>Country  <span style="color:red">*</span></label>
		<select name="country">
			<?php foreach($country_list as $country){
			if($Jobs['country']==$country){
					$checked = 'selected="yes"';
				}else{
					$checked = '';
				}
			?>
			<option value="<?php echo $country;?>"  <?php echo $checked;?>><?php echo $country;?></option>
			<?php } ?>
		</select><br />
		<label>Posted On <span style="color:red">*</span></label>
		<input type="text" class="datepicker" name="postedon" value="<?php echo date('d-m-Y',strtotime($Jobs['posted_on']));?>"  style="width:160px;"><br />
		<!-- 
		<label>
		<?php if($Jobs['publish_in_website']==1){
			$checked = 'checked="checked"';
		}else{
			$checked ='';
		}?>
		
		<input type="checkbox" <?php echo $checked; ?> name="publishinwebsite">Publish in website </label><br />
		 -->
		
		<input type="button" value="Submit"  id="btnJobPost">
		</form>
		<?php } elseif($isUpdateSubmit==1) {?>
		<p class="importantnotice" style="color:green">
			The job has been posted successfully. It will be in the website in 37minutes and seek in 1 hour.<br />
			<input type="button" value="View all Jobs" onclick="javascript:changeLocation('index.php?pg=joblist')"> &nbsp; <input type="button" value="View the Job" onclick="javascript:changeLocation('index.php?pg=jobview&id=<?php echo $_REQUEST['id'];?>')"> 
		</p>
		<?php }else{ ?>
			<p class="importantnotice">
		Can not edit now. Please try again.  <br />
		<input type="button" value="Back" onclick="javascript:changeLocation('index.php?pg=joblist&id=<?php echo $_REQUEST['id']?>')"> 
		</p>
		<?php } ?>
		
		
		<br /><br />
	</div>
</div>
<script type="text/javascript">

var introVal = $('#introduction').val();
strLength = introVal.length;


var leftVal = 150-strLength;

if(leftVal<0){
	leftVal = 0;
}
$('#introCounter').html(leftVal);


function introCounter(){
	var introVal = $('#introduction').val();
	strLength = introVal.length;
	

	var leftVal = 150-strLength;

	if(leftVal<0){
		leftVal = 0;
	}
	$('#introCounter').html(leftVal);
	
}

	//<![CDATA[

		// Create all editor instances at the end of the page, so we are sure
		// that the "bottomSpace" div is available in the DOM (IE issue).

		CKEDITOR.replace( 'description',
			{
				sharedSpaces :
				{
					top : 'topSpace',
					bottom : 'bottomSpace'
				},

				// Removes the maximize plugin as it's not usable
				// in a shared toolbar.
				// Removes the resizer as it's not usable in a
				// shared elements path.
				removePlugins : 'maximize,resize'
			} );

		CKEDITOR.instances.description.on('contentDom', function() {
	          CKEDITOR.instances.description.document.on('keypress', function(event) {
		          	
		          	var stringCotent = CKEDITOR.instances.description.getData();
		          	var strLength = stringCotent.length;
		          	var leftVal = 5000-strLength;

	    			if(leftVal<0){
	    				leftVal = 0;
	    			}
	    			$('#descCounter').html(leftVal);
		          	if(strLength>=5000){         	
			       
			         CKEDITOR.instances.description.execCommand('undo',5);
				     	var stringCotent = CKEDITOR.instances.description.getData();
			          	var strLength = stringCotent.length;
			          	var leftVal = 5000-strLength;
			         $('#descCounter').html(leftVal);
		          	 // CKEDITOR.instances.description.setData(stringCotent.substring(0,20));
		          	}
			});
		      	var stringCotent = CKEDITOR.instances.description.getData();
		      	var strLength = stringCotent.length;
		      	var leftVal = 5000-strLength;
		     $('#descCounter').html(leftVal);
	        });
	
		</script>