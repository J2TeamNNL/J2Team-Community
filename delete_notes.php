<?php 
ini_set('max_execution_time', 0);
//token của bạn
$token = "EAA...";
//điền id ghi chú không muốn xóa
$array_avoid = ['123','345','567'];
$url = "https://graph.facebook.com/me/notes?limit=100&fields=id&access_token=$token";
$array = array();
while(true){
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 0,
	    CURLOPT_SSL_VERIFYPEER => false,
	    CURLOPT_SSL_VERIFYHOST => false
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($response,JSON_UNESCAPED_UNICODE);
	if(isset($response["data"]) && count($response["data"])>0){
		$array_fb = $response["data"];
	}
	else{
		break;
	}
	foreach ($array_fb as $each) {
		array_push($array,$each['id']);
	}
	if(!empty($response['paging']['next'])){
		$url = $response['paging']['next'];
	}
	else{
		break;
	}
}
$array_delete = array_diff($array, $array_avoid);
foreach($array_delete as $each){
	$link   = "https://graph.facebook.com/$each?method=delete&access_token=$token";
	$curl   = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $link,
		CURLOPT_RETURNTRANSFER => false,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => false
	));
	curl_exec($curl);
	curl_close($curl);
	sleep(5);
}
