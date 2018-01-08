<?php 
ini_set('max_execution_time', 0);
//token của bạn
$token = "EAAA...";
//id của bạn
$id_me = "123";
//điền id những nhóm k muốn thoát
$array_avoid = ["364997627165697","123","456","789"];
$url = "https://graph.facebook.com/me/groups?limit=100&fields=id&access_token=$token";
$array_id = array();
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
		array_push($array_id,$each['id']);
	}
	if(!empty($response['paging']['next'])){
		$url = $response['paging']['next'];
	}
	else{
		break;
	}
}
$array_id = array_diff($array_id,$array_avoid);
foreach ($array_id as $id_group) {
	$url = "https://graph.facebook.com/$id_group/members?member=$id_me&method=delete&access_token=$token";
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => false,
		CURLOPT_TIMEOUT => 0,
	    CURLOPT_SSL_VERIFYPEER => false,
	    CURLOPT_SSL_VERIFYHOST => false
	));
	curl_exec($curl);
	curl_close($curl);
	sleep(3);
}
