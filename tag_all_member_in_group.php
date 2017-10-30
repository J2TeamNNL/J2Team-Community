<?php  
ini_set('max_execution_time', 0);
$post_id = "";//id bài muốn bình luận
$token = "";//token của bạn
$text = ""; //điền vào đây lời nhắn bạn muốn gửi
$id_group = ""; //id nhóm
$array_avoid = []; //điền id những bạn  mà bạn không muốn tag vào
$url = "https://graph.facebook.com/$id_group/members?limit=5000&fields=id&access_token=$token";
$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => "$url",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_TIMEOUT => 0,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
));
$response = curl_exec($curl);
curl_close($curl);
$data      = json_decode($response,JSON_UNESCAPED_UNICODE);
$datas     = $data["data"];
$message = "";
$dem = 0;
foreach($datas as $each){
	$message .= "@[".$each["id"].":0] ";
	$dem++;
	if(in_array($each["id"], $array_avoid)) {
		continue;
	}
	//cứ 5 bạn thì sẽ tag 1 lần, tránh bị FB hiểu nhầm spam, và sẽ tự động tag mỗi 10 giây cho đến hết danh sách
	if($dem == 5){
		$message .= "
$text";
		$curl = curl_init();
		$message = curl_escape($curl,$message);
		$url = "https://graph.facebook.com/$post_id/comments?method=post&message=$message&access_token=$token";
		curl_setopt_array($curl, array(
			CURLOPT_URL => "$url",
			CURLOPT_RETURNTRANSFER => false,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false
		));
		curl_exec($curl);
		curl_close($curl);
		$dem=0;
		sleep(10);
		$message = "";
	}
}
$message .= "
$text";
$curl = curl_init();
$message = curl_escape($curl,$message);
$url = "https://graph.facebook.com/$post_id/comments?method=post&message=$message&access_token=$token";
curl_setopt_array($curl, array(
	CURLOPT_URL => "$url",
	CURLOPT_RETURNTRANSFER => false,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_SSL_VERIFYHOST => false
));
curl_exec($curl);
curl_close($curl);
