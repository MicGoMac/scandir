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
	if (dir_exist($dir_exist_prepare, $d)===false){
		new_dir( $dbh, $d, 0, 2);
	}else{
		echo "dir exists\n";
	}
}
 
/*

function new_dir($dir, $parent_id){
	return;
}

*/

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
	return array_filter(glob($dir."*"), 'is_file');
}
 

/*

CREATE TABLE `dirs` (
  `id` int(11) NOT NULL,
  `fullpath` text COLLATE utf8_unicode_ci,
  `basename` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_count` int(11) NOT NULL DEFAULT '0',
  `dir_count` int(11) NOT NULL DEFAULT '0',
  `dir_md5` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_md5` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_id` tinyint(4) NOT NULL DEFAULT '0',
  `file_changed` int(11) NOT NULL DEFAULT '0',
  `dir_changed` tinyint(4) NOT NULL DEFAULT '0',
  `date_checked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `priority` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/

?>