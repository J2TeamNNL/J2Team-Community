<?php 
$source      = $_GET['source'];
$id          = $_GET['id'];
$id_object   = $_GET['id_object'];
$name_object = $_GET['name_object'];
$folder      = $_GET['folder'];
$album       = $_GET['album'];

$path = "$folder/";
if(!file_exists($path)){
	mkdir($path);
}
$path .= "$name_object ($id_object)/";
if(!file_exists($path)){
	mkdir($path);
}
$path .= "$album/";
if(!file_exists($path)){
	mkdir($path);
}
$path .= "$id.jpg";

$fp    = fopen ($path, 'w+');
$curls = curl_init();
curl_setopt_array($curls, array(
    CURLOPT_URL => $source,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_FILE => $fp
));
curl_exec($curls);
curl_close($curls);
fclose($fp);