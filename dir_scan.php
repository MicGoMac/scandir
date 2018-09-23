<?php
//clean up those files created by a specific date, which were created by mistake
//$currDir=dirname(__FILE__)."/";


include_once("pdo.php");
$startDir="/volume1/shared/";

echo "start scan";
//scan level 1 
$level_1_dirs = Listfolders($startDir);

//print_r($level_1_dirs); //exit();

foreach ($level_1_dirs as $d){
	$id = dir_exist($dir_exist_prepared, $d);
	
	if ($id===false){
		new_dir( $dbh, $d, 0, 2);
	}else{
		//echo findParent_id( $dir_exist_prepared, $dir);
		echo "id>$id dir exists\n";
	}
}

//level 2
  

function findParent_id( $dir_exist_prepared, $dir){
	$pi=pathinfo($dir);
	$pa_path = $pi["dirname"] . "/";
	return dir_exist( $dir_exist_prepared , $fullpath);
}
 

function add_Zero( $str ) {
    while (strlen($str) < 3 ){
    $str= "0".$str;
    }
    return $str;
} 


function checkDir ( $dir ) {
	//echo $ddir."\n";
 	//works on FILES in a given Directory. Skip any Dir inside
   	$dir_arr = Listfolders($dir);
   	$dir_arr_count = count($dir_arr);
   	$dir_str=implode("|", $dir_arr);
   	$curr_dir_md5 = md5($dir_str);

   	
   	$file_arr = Listfiles($dir, "*" , 'is_file');
   	$file_arr_count = count($file_arr);
   	$file_str=implode("|", $file_arr);
   	$curr_file_md5 = md5($file_str);
   	
   	//db of this dir
   	// $sql = "select * from `dirs` where fullpath = $dir";
   	//$id
   	// $sql = "select * from `dirs` where parent_id = $id";
   	
 }

//a modern way of list dir in dir
//leave ."*" empty for folders
function Listfolders($dir){
	//check if $dir ends with /
	if ( substr( $dir, -1) != "/" ){
		$dir .= "/";
	}
	
	$folders = array_filter(glob($dir."*"), "is_dir");
	$sys_folders = array_filter(glob($dir."@*"), "is_dir");
	return array_diff( $folders, $sys_folders);
}

 
//e.g. Listfiles($sdir, ".JPG", 'is_file');
//leave $ext empty for folders
function Listfiles($dir){
	//check if $dir ends with /
	if ( substr( $dir, -1) != "/" ){
		$dir .= "/";
	}
	
	return array_filter(glob($dir."*"), 'is_file');
}
 

/*

`id  
`fullpath  
`parent_id  dirname of fullpath  dir_exist() get's the id
`basename  basename of  of fullpath
`file_count  by actual scan
`dir_count  by actual scan vs select items with parent id my id
`dir_md5  last scan of dirs and md5
`file_md5 last scan of files and md5 
`type_id  except id 7(deleted) , others manual assign
`file_changed  raised if file_md5 not matched
`dir_changed  raised if dir_md5 not matched
`date_checked  auto timestamp OR after a check with + or - result!
`priority  some dir be checked more often, e.g. dc_photo, Ricoh
`level deduced from items in fullpath

*/ 
?>