<?php 
ini_set('max_execution_time', 0);
$id_post = "";//id bài muốn lấy
$token = "";//token của bạn
$id_group = "";//điền id nhóm
$url = "https://graph.facebook.com/$id_group/members?limit=500&fields=id&access_token=$token";
$array_member = array();
$i=0;
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
	foreach ($array_fb as $each) {
		array_push($array_member,$each['id']);
	}
	if($i==3){
		break;
	}
	$i++;
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

$array_dont_react = array_diff($array_member, $array_reactions);
echo implode("<br>",$array_dont_react);
