<?php
ini_set('max_execution_time', 0);
$token       = "EAAA..."; //token full quyền
$array_avoid = ["123","345"];//id người muốn tránh bỏ theo dõi


//không chỉnh phần dưới nhé
$array_person = array();

$links = "https://graph.facebook.com/me/friends?limit=5000&fields=id&access_token=$token";
$curls = curl_init();
curl_setopt_array($curls, array(
	CURLOPT_URL => $links,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_SSL_VERIFYHOST => false
));
$reply = curl_exec($curls);
curl_close($curls);
$data  = json_decode($reply,JSON_UNESCAPED_UNICODE);
$data = $data['data'];
foreach($data as $each){
    $array_person[] = $each['id'];
}
foreach($array_person as $each){
  if(!in_array($each,$array_avoid)){
    $links = "https://graph.facebook.com/$each/subscribers?method=delete&access_token=$token";
    $curls = curl_init();
    curl_setopt_array($curls, array(
      CURLOPT_URL => $links,
      CURLOPT_RETURNTRANSFER => false,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false
    ));
    curl_exec($curls);
    curl_close($curls);
    sleep(3);
    }
  }

 


