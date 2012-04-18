<?php 
class sh_DB {
		
	 public $hostname_logon = 'localhost';				//Database server LOCATION
	 public $database_logon = 'oscint_catercare';		//Database NAME
	 public $username_logon = 'oscint_leon';		//Database USERNAME
	 public $password_logon = 'leonosc123';			//Database PASSWORD
	
	 	
	public function __construct() {	
		$this->dbconnect();
	}
	
	public function __destruct() {	
		$this->dbclose();
	}

	function dbconnect(){
		$connections = mysql_connect($this->hostname_logon, $this->username_logon, $this->password_logon) or die ('Unabale to connect to the database');
		mysql_select_db($this->database_logon) or die ('Unable to select database!');	
		return $connections;
	}
	
	function dbclose(){
		//$connections = mysql_connect($this->hostname_logon, $this->username_logon, $this->password_logon) or die ('Unabale to connect to the database');
		//mysql_close($connections);
	}
	
	public function withPagination($sql = ''){
		if($sql==''){
			return false;
		}
		
	
				
		$pager = new PS_Pagination($sql);
		$rs = $pager->paginate();
				
		if(!$rs) die(mysql_error());
				
		while($row = mysql_fetch_array($rs)) {
			$result[] = $row;
		}
		
		if($result){
			$allResult['records'] = $result;
			$allResult['pagination'] = $pager->renderFullNav();
			return $allResult;
		}
		
		return 'query result empty';			
	}
	
function selectalbum($table = '',$field='', $id = ''){
		
		if($table == ''){
				return false;
			}
			$allResult = '';
		if(($id == '')||($field == '')){
			$qry = "SELECT * from $table";
			}else{
			$qry = "SELECT * from $table WHERE $field = '$id'";
			}			

			$qry.=" ORDER BY album_name ASC";
		$result123 = $this->qry($qry);
		while($row = mysql_fetch_array($result123)) {
			$result[] = $row;
		}
		if($result){
		$allResult = $this->withPagination($qry);
		return $allResult;
		}else{
				return false;
			}	
				
	}
	
	function select($table = '',$field='', $id = ''){
		
		if($table == ''){
				return false;
			}
			$allResult = '';
		if(($id == '')||($field == '')){
			$qry = "SELECT * from $table";
			}else{
			$qry = "SELECT * from $table WHERE $field = '$id'";
			}			

			$qry.=" ORDER BY id DESC";
		
		$result123 = $this->qry($qry);
		while($row = mysql_fetch_array($result123)) {
			$result[] = $row;
		}
		if($result){
		$allResult = $this->withPagination($qry);
		return $allResult;
		}else{
				return false;
			}	
				
	}
	function selectWithOrder($table = '',$ord=''){
		
		if($table == ''){
				return false;
			}
			$allResult = '';
		if(($id == '')||($field == '')){
			$qry = "SELECT * from $table";
			}else{
			$qry = "SELECT * from $table WHERE $field = '$id'";
			}			

			$qry.=" ".$ord;
		
		$result123 = $this->qry($qry);
		while($row = mysql_fetch_array($result123)) {
			$result[] = $row;
		}
		if($result){
		$allResult = $this->withPagination($qry);
		return $allResult;
		}else{
				return false;
			}	
				
	}	
function selectOnMultipleConditionWithPaging($data = '',$table = ''){
		
		if(($table == '')){
				return false;
			}
		if($data == ''){
			$qry = "SELECT * from $table;";			
		}else{
		$qry = "SELECT * from $table WHERE ";	
		$arraySize = sizeof($data);
		$count = 1;
		foreach($data as $key => $val){
					$qry .= "$key = '$val'";
					
					if($count<$arraySize){
						$qry .= " AND ";
					}
					$count++;
				}				
		}
				
		$Result = $this->withPagination($qry);
		return  $Result;
			
	}
function selectOnMultipleConditionWithPagingWithOrder($data = '',$table = '',$ord=''){
		
		if(($table == '')){
				return false;
			}
		if($data == ''){
			$qry = "SELECT * from $table;";			
		}else{
		$qry = "SELECT * from $table WHERE ";	
		$arraySize = sizeof($data);
		$count = 1;
		foreach($data as $key => $val){
					$qry .= "$key = '$val'";
					
					if($count<$arraySize){
						$qry .= " AND ";
					}
					$count++;
				}				
		}
		if(!$ord=='')
		{
			$qry=$qry.$ord;
		}
				
		$Result = $this->withPagination($qry);
		return  $Result;
			
	}	
function selectWithoutPaging($table = '',$field='', $id = ''){
		
		if($table == ''){
				return false;
			}
			$allResult = '';
		if(($id == '')||($field == '')){
			$qry = "SELECT * from $table";
			}else{
			$qry = "SELECT * from $table WHERE $field = '$id'";
			}			

			$qry.=" ORDER BY id DESC";
		$result123 = $this->qry($qry);
		while($row = mysql_fetch_array($result123)) {
			$result[] = $row;
		}
		if($result){
			return $result;
		}else{
				return false;
			}				
	}

	function totalCount($data = '',$table = ''){
		if(($table == '')||($data=='')){
				return false;
			}
		$qry = "SELECT id from $table WHERE ";	
		$arraySize = sizeof($data);
		$count = 1;
		foreach($data as $key => $val){
					$qry .= "$key = '$val'";
					
					if($count<$arraySize){
						$qry .= " AND ";
					}
					$count++;
				}
		$qry .= ";";
		
		$result = $this->qry($qry);
		
		$total = mysql_num_rows($result);
		if($total){
				return $total;
			}else{
				return 0;
			}
		
	}
function totalCountOrCondition($data = '',$table = ''){
		if(($table == '')||($data=='')){
				return false;
			}
		$qry = "SELECT id from $table WHERE ";	
		$arraySize = sizeof($data);
		$count = 1;
		foreach($data as $key => $val){
					$qry .= "$key = '$val'";
					
					if($count<$arraySize){
						$qry .= " OR ";
					}
					$count++;
				}
		$qry .= ";";
		
		$result = $this->qry($qry);
		
		$total = mysql_num_rows($result);
		if($total){
				return $total;
			}else{
				return 0;
			}
		
	}
function totalCountWithoutCondition($table = ''){
		if(($table == '')){
				return false;
			}
		$qry = "SELECT id from $table ;";			
		$result = $this->qry($qry);
		
		$total = mysql_num_rows($result);
		if($total){
				return $total;
			}else{
				return 0;
			}
		
	}

function selectOnDate($column='',$sdate = '',$edate = '',$table=''){
	if(($table == '')||($column=='')||($edate=='')||($sdate=='')){
				return false;
			}
			
	$qry = "select * from $table where $column between '$sdate' and '$edate'";
	
	$result = $this->qry($qry);
	
	$total = mysql_num_rows($result);
		if($total){
				return $total;
			}else{
				return 0;
			}	
	
}
function searchOnMultipleCondition($data = '',$table = '',$orderby = '', $way = ''){
		
		if(($table == '')){
				return false;
			}
		if($data == ''){
			$qry = "SELECT * from $table;";			
		}else{
		$qry = "SELECT * from $table WHERE ";	
		$arraySize = sizeof($data);
		$count = 1;
		foreach($data as $key => $val){
					$qry .= "$key LIKE '%$val%'";
					
					if($count<$arraySize){
						$qry .= " OR ";
					}
					$count++;
				}
			
		if($orderby!=''){
			if($way == ''){
			$qry .= "ORDER BY $orderby ASC";
			}else{
			$qry .= "ORDER BY $orderby DESC";
			}
		}
		
		$qry .= ";";
		}
		
		// $allResult = $this->qry($qry);
		 $allResult = mysql_query($qry) or die(mysql_error());
		while($row = mysql_fetch_array($allResult)) {
			$result[] = $row;
		}	
		if($result){
				return $result;
			}else{
				return false;
			}	
	}
function selectOnMultipleCondition($data = '',$table = '',$orderby = '', $way = ''){
		
		if(($table == '')){
				return false;
			}
		if($data == ''){
			$qry = "SELECT * from $table;";			
		}else{
		$qry = "SELECT * from $table WHERE ";	
		$arraySize = sizeof($data);
		$count = 1;
		foreach($data as $key => $val){
					$qry .= "$key = '$val'";
					
					if($count<$arraySize){
						$qry .= " AND ";
					}
					$count++;
				}
			
		if($orderby!=''){
			if($way != ''){
				if($way == 'ASC'){
				$qry .= "ORDER BY $orderby ASC";
				}
				else{
				$qry .= "ORDER BY $orderby DESC";
				}
			}
			else{
				$qry .= "ORDER BY $orderby ASC";
			}
		}
		
		$qry .= ";";
		}

		$allResult = $this->qry($qry);
		
		while($row = mysql_fetch_array($allResult)) {
			$result[] = $row;
		}	
		if($result){
				return $result;
			}else{
				return false;
			}	
	}
function selectOnMultipleOrCondition($data = '',$table = '',$orderby = 'id', $way = 'DESC'){
		
		if(($table == '')){
				return false;
			}
		if($data == ''){
			$qry = "SELECT * from $table;";			
		}else{
		$qry = "SELECT * from $table WHERE ";	
		$arraySize = sizeof($data);
		$count = 1;
		foreach($data as $key => $val){
					$qry .= "$key = '$val'";
					
					if($count<$arraySize){
						$qry .= " OR ";
					}
					$count++;
				}
			$qry .= "ORDER BY id DESC";
		/*	
		if($orderby!=''){
			if($way == ''){
			$qry .= "ORDER BY $orderby DESC";
			}else{
			$qry .= "ORDER BY $orderby ASC";
			}
		}
		*/
		$qry .= ";";
		}
			
		
		$allResult = $this->qry($qry);
		
		while($row = mysql_fetch_array($allResult)) {
			$result[] = $row;
		}	
		if($result){
				return $result;
			}else{
				return false;
			}	
	}
function deleteOnMultipleCondition($data = '',$table = ''){
		
		if(($table == '')||($data=='')){
				return false;
			}
		$qry = "DELETE from $table WHERE ";	
		$arraySize = sizeof($data);
		$count = 1;
		foreach($data as $key => $val){
					$qry .= "$key = '$val'";
					
					if($count<$arraySize){
						$qry .= " AND ";
					}
					$count++;
				}
		$qry .= ";";
		$allResult = $this->qry($qry);
		if($allResult){
				return $result;
			}else{
				return false;
			}	
	}
	
function search($searchfield = '',$searchString = '',$table = ''){
		
		
		$searchfield = trim($searchfield);
		if(($table == '')||($searchString == '')||($searchfield == '')){
				return false;
			}
			
		//$qry = "SELECT useremail FROM $table WHERE useremail LIKE '%$searchString%' LIMIT 10";
		
		$qry = "SELECT * FROM $table WHERE $searchfield LIKE '%$searchString%'";
		
		
		//$sql = mysql_query("SELECT * FROM $table WHERE $searchfield LIKE '%$searchString%'");
		
		$sql = mysql_query($qry);

		while ($row = mysql_fetch_array($sql)) {
			$result[] = $row;
		} 
		
		if($result){
				return $result;
			}else{
				return false;
			}

				
	}
	
	
	function update($data = '',$id = '',$table = ''){
		
		if(($data == '')||($id == '')||($table == '')){
				return false;
			}
			
			$qry = "UPDATE `$table` SET ";
			$arraySize = sizeof($data);
			$count = 1;
			foreach($data as $key => $val){
					$qry .= "$key = '$val'";
					
					if($count<$arraySize){
						$qry .= ", ";
					}
					$count++;
				}
			$qry .= " WHERE id='$id'";
		
		
		//$result = $this->qry($qry);
		
		 $result = mysql_query($qry) or die(mysql_error());
		if($result == true){
				return true;
			}else{
				return false;
			}		
	}
	
	
function updateonfield($data = '',$id = '',$field='',$table = ''){
		
		if(($data == '')||($id == '')||($table == '')||($field == '')){
				return false;
			}
			
			$qry = "UPDATE `$table` SET ";
			$arraySize = sizeof($data);
			$count = 1;
			foreach($data as $key => $val){
					$qry .= "$key = '$val'";
					
					if($count<$arraySize){
						$qry .= ", ";
					}
					$count++;
				}
			$qry .= " WHERE $field = '$id'";
		$qry .= ';';
		
		
		 $result = mysql_query($qry) or die(mysql_error());
		if($result == true){
				return true;
			}else{
				return false;
			}		
	}
	
	function insert($data = '',$table = ''){
		if(($data == '')||($table =='')){
			return false;
		}
		$qry = "INSERT into $table (";
		$count = sizeof($data);
		
		$id = 1;
		$sampleQry = "INSERT INTO Persons (FirstName, LastName, Age)
						VALUES (1, 'Griffin', '35')";
		
		foreach($data as $key => $val){
			$qry .= "$key ";
			if($id<$count){
				$qry .= ", ";
			}
			$id++;
		}
		
		$qry .= ") VALUES (";
		$id2 = 1;
		foreach($data as $key => $val){
			$qry .= '\''.$val.'\' ';
			if($id2<$count){
				$qry .= ", ";
			}
			$id2++;
		}
		
		$qry .= ");";
		
		// $result = $this->qry($qry);
		 $result = mysql_query($qry) or die(mysql_error());
		if($result == true){
				return mysql_insert_id();
			}else{
				return false;
			}
		
	}
	
	function delStatus($id = '', $field = '',$table = ''){
		if(($id == '')||($field =='')||($table =='')){
			return false;
		}
		$qry = "UPDATE $table SET $field ='0' WHERE id='$id'";
		$result = $this->qry($qry);
		if($result == true){
				return true;
			}else{
				return false;
			}		
	}
	
	function delRecord($id = '',$table = ''){
		if(($id == '')||($table =='')){
			return false;
		}
		$qry = "DELETE FROM $table WHERE id = $id";
		$result = $this->qry($qry);
		if($result == true){
				return true;
			}else{
				return false;
			}
		
	}
	
	function lastIdFromTable($data = '',$table='',$order = '',$returnval = ''){
		
	$allResult = '';
	if(($table == '')){
				return false;
			}
		if($data == ''){
			$qry = "SELECT * from $table ";			
		}else{
		$qry = "SELECT * from $table WHERE ";	
		$arraySize = sizeof($data);
		$count = 1;
		foreach($data as $key => $val){
					$qry .= "$key = '$val' ";
					
					if($count<$arraySize){
						$qry .= "AND ";
					}
					$count++;
				}
		
		}
		
		$qry .= "ORDER BY $order DESC LIMIT 1;";
			
		$result123 = $this->qry($qry);
		while($row = mysql_fetch_array($result123)) {
			$result[] = $row;
		}
		if($result){
			return $result[0]["$returnval"];
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
