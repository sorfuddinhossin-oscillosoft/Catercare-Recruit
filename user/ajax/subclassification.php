<?php
include_once '../../class/dbclass.php';
$shDB =new sh_DB();
$classification = trim($_REQUEST['classification']);
	$seekSubClassification = array(		
							'Parent_Xml_ID' => $classification,
							'status' => 1
							);
	$seekSubClassification = $shDB->selectOnMultipleCondition($seekSubClassification,'`subclassification`'); 
	?>
	<option value="">Select sub classification</option>
	<?php foreach($seekSubClassification as $seekSubClass){?>
	<option value="<?php echo $seekSubClass['Xml_ID']?>"><?php echo $seekSubClass['Description']?></option>
	<?php } ?>