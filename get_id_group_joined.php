<?php 

ini_set('max_execution_time', 0);

//token của bạn

$token = "EAAA...";
//id người dùng
$id_person = "123";

$url = "https://graph.facebook.com/$id_person/groups?limit=1000&fields=id&access_token=$token";

$array_id = array();

while(true){

	$curl = curl_init();	curl_setopt_array($curl, array(

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

	foreach ($array_fb as $each){

echo $each['id'].'<br>';

	}

	if(!empty($response['paging']['next'])){

		$url = $response['paging']['next'];

	}

	else{

		break;

	}

}
