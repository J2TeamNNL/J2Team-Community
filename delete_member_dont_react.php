<?php 
ini_set('max_execution_time', 0);
//id bài muốn lấy
$id_post = "123";
//token của bạn
$token = "EAA...";
//điền id nhóm
$id_group = "123";
//điền id người được miễn, ví dụ như ở bên
$array_avoid = ['123','345','567'];
$url = "https://graph.facebook.com/$id_group/members?limit=5000&fields=id&access_token=$token";
$array_member = array();
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
		array_push($array_member,$each['id']);
	}
	if(!empty($response['paging']['next'])){
		$url = $response['paging']['next'];
	}
	else{
		break;
	}
}
$array_reactions = array();
$url = "https://graph.facebook.com/$id_post/reactions?limit=5000&fields=id&access_token=$token";
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
		array_push($array_reactions,$each['id']);
	}
	if(!empty($response['paging']['next'])){
		$url = $response['paging']['next'];
	}
	else{
		break;
	}
}
$url = "https://graph.facebook.com/$id_post/comments?limit=5000&fields=from{id}&access_token=$token";
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
		if(!empty($each['from']['id']))
			array_push($array_reactions,$each['from']['id']);
	}
	if(!empty($response['paging']['next'])){
		$url = $response['paging']['next'];
	}
	else{
		break;
	}
}
$url = "https://graph.facebook.com/$id_post/sharedposts?limit=5000&fields=from{id}&access_token=$token";
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
		if(!empty($each['from']['id']))
			array_push($array_reactions,$each['from']['id']);
	}
	if(!empty($response['paging']['next'])){
		$url = $response['paging']['next'];
	}
	else{
		break;
	}
}
$array_dont_react = array_diff($array_member, $array_reactions, $array_avoid);
foreach($array_dont_react as $each){
	$link   = "https://graph.facebook.com/$id_group/members?method=delete&member=$each&access_token=$token";
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
