<?php
/*
reference tutorial:
http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers

*/
 
// note the charset=utf8 param for unicode
$dsn = 'mysql:dbname=nas;host=localhost;charset=utf8';
$user = 'michael';

include_once("pdo_pword.php");



try {
	$dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	die(__FILE__ . '(' . __LINE__ . ')' . ' Connection failed: ' . $e->getMessage());
}


//prepare sql

	$sql = "select id from `dirs` where `fullpath` = ? limit 1";
	$dir_exist_prepared=$dbh->prepare($sql);

	


//end prepare sql

function dir_exist( $dir_exist_prepared , $fullpath){
	//if exist return the id in table, else false
	try {
			if ($dir_exist_prepared->execute( array($fullpath))) {
				//simple fetch. get all returns
				$got_rows = ( $dir_exist_prepared->fetchAll()); 
				if ($got_rows == array()){
					return false;
				}else{
					return $got_rows[0]['id'];
				}
				
			} else {
				print ("DB select failed"); 
			}
			
		} catch (PDOException $e) {
			die(__FILE__ . '(' . __LINE__ . ')' . ' Connection failed: ' . $e->getMessage());
		}
}		

function new_dir( $dbh, $fullpath, $pid, $level){
	//check if already in db
	
	// file_checked, `dir_changed` = 1 so it will be check asap
	$sql="INSERT INTO `dirs` (`fullpath`, `parent_id`, `level`, `dir_changed`, `file_changed`) VALUES ( '$fullpath', $pid, $level, 1, 1);";
	$insert_new_dir_prepare =$dbh->prepare($sql);
 
	try { 
		if ($insert_new_dir_prepare->execute() ) {
			print ("insert ok"); return true; } else {print ("DB execute failed"); return false; 
		}
		  
	} catch (PDOException $e) {
		die(__FILE__ . '(' . __LINE__ . ')' . ' Error: ' . $e->getMessage());
	}
}
//========
// exit();
 
/*

//no placeholder
$sql = "select * from `incomes` where id = 298637  limit 1";
	$sql_prepare=$dbh->prepare($sql);

		try {
		
			if ($sql_prepare->execute()) {					
				//simple fetch. get all returns
				$got_rows = ( $sql_prepare->fetchAll()); 
				print_r($got_rows);
			} else {
				print ("DB select failed"); 
			}
			
			
		} catch (PDOException $e) {
			die(__FILE__ . '(' . __LINE__ . ')' . ' Connection failed: ' . $e->getMessage());
		}
 
 //with placeholder
 $sql = "select * from `incomes` where id = ?";
	$sql_prepare=$dbh->prepare($sql);

		try {
			$id='298637';
			if ($sql_prepare->execute( array($id))) {
				//simple fetch. get all returns
				$got_rows = ( $sql_prepare->fetchAll()); 
				print_r($got_rows);
			} else {
				print ("DB select failed"); 
			}
			
			
		} catch (PDOException $e) {
			die(__FILE__ . '(' . __LINE__ . ')' . ' Connection failed: ' . $e->getMessage());
		}
		
 

 
 
//=====end db setup
  
  
//these samples use simple direct sql without using placeholders.
  
//insert in a table
	
	$sql="INSERT INTO `table_name` (`filename`, `size`) VALUES ('test name2', '400');";
	  
	$sql_prepare =$dbh->prepare($sql);
		
	try { 
		if ($sql_prepare->execute() ) {print ("success"); } else {print ("DB execute failed"); return 0; }
		  
	} catch (PDOException $e) {
		die(__FILE__ . '(' . __LINE__ . ')' . ' Error: ' . $e->getMessage());
	}
 
		
//select from a table
	$sql = "select * from `table_name` where id = 1  limit 1";
	$sql_prepare=$dbh->prepare($sql);

		try {
		
			if ($sql_prepare->execute()) {					
				//simple fetch. get all returns
				$got_rows = ( $sql_prepare->fetchAll()); 
				print_r($got_rows);
			} else {
				print ("DB execute failed"); 
			}
			
			
		} catch (PDOException $e) {
			die(__FILE__ . '(' . __LINE__ . ')' . ' Connection failed: ' . $e->getMessage());
		}
 

// update
$sql = "UPDATE `table_name` SET size='200' where id=1";
$sql_prepare=$dbh->prepare($sql);
$affected_rows = $sql_prepare->execute();
echo $affected_rows.' were affected';

//delete
$sql = "DELETE FROM `table_name` WHERE `id` =11";
$sql_prepare=$dbh->prepare($sql);
$affected_rows = $sql_prepare->execute();
echo $affected_rows.' were affected';
*/
 
?>