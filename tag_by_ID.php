<?php 
//điền mỗi ID xuống dòng nhé, mình để mẫu rồi đó
$ids = "11111
11111
11111
11111";
$post_id = "";//id bài muốn bình luận
$token = "";//token của bạn
$text = ""; //điền vào đây lời nhắn bạn muốn gửi
$array = explode(PHP_EOL,$ids);
$message = "";
$dem = 0;
foreach($array as $each){
	$message .= "@[".$each.":0] ";
	$dem++;
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
		sleep(10);
		$message = "";
		$dem=0;
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
