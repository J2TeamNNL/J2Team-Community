<?php 
$path = $_GET['path'];
if(file_exists($path)){
	echo "1";
	$type = $_GET['type'];
	if($type=='save'){
		$folder_save = $_GET['folder_save'];
		if(!file_exists($folder_save)){
			mkdir($folder_save);
		}
		$array_path = explode('/',$path);
		if(!file_exists("$folder_save/$array_path[1]")){
			mkdir("$folder_save/$array_path[1]");
		}
		copy($path, "$folder_save/$array_path[1]/$array_path[2]");
	}
	unlink($path);
}
else{
	echo "0";
}