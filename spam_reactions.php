<?php
ini_set('max_execution_time', 0);
$token       = "EAAA..."; //token full quyền
$person = "123"; //id người muốn bão 
$type = "LOVE"; //Có thể là HAHA, LIKE, ANGRY, LOVE, SAD, WOW

$array_post = array();
$links = "https://graph.facebook.com/$person/feed?fields=id&access_token=$token";
while(true){
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
  if(isset($data["data"]) && count($data["data"])>0){
    $datas = $data["data"];
    foreach($datas as $each){
      $array_post[] = $each['id'];
    }
  }
  else{
    break;
  }
  if(!empty($data["paging"]['next'])){
    $links = $data["paging"]['next'];
  }
  else break;
}

foreach($array_post as $post){
  $links = "https://graph.facebook.com/$post/reactions?method=POST&type=$type&access_token=$token";
  $curls = curl_init();
  curl_setopt_array($curls, array(
    CURLOPT_URL => $links,
    CURLOPT_RETURNTRANSFER => false,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false
  ));
  $reply = curl_exec($curls);
  curl_close($curls);
  sleep(3);
}
