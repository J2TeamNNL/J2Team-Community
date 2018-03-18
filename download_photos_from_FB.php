<?php
ini_set('max_execution_time', 0);
//token bạn
$token = "EAAAA";
//điền ID trang page hoặc cá nhân profile
$id ="123";

//không sửa ở dưới
$link    = "https://graph.facebook.com/$id/albums?fields=id&limit=100&access_token=$token"; 
$array_album = array();
while (true) {
    $curl    = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data  = json_decode($response,JSON_UNESCAPED_UNICODE);
    $datas = $data["data"];
    if(count($datas)==0) break;
    foreach($datas as $each){
        array_push($array_album,$each['id']);
    }
    if(!empty($data["paging"]["next"])){
        $link = $data["paging"]["next"];
    }
    else{
        break;
    }
} 
foreach ($array_album as $id_album) {
  $link    = "https://graph.facebook.com/$id_album/photos?fields=images.source&limit=100&access_token=$token";
  while (true) {
    $curl    = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data  = json_decode($response,JSON_UNESCAPED_UNICODE);
    $datas = $data["data"];
    if(count($datas)==0) break;
    foreach($datas as $each){
        $id    = $each['id'];
        $fp    = fopen ("download/$id.jpg" , 'w+');
        $links = $each['images'][0]['source'];
        $curls = curl_init();
        curl_setopt_array($curls, array(
            CURLOPT_URL => $links,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FILE => $fp
        ));
        curl_exec($curls);
        curl_close($curls);
        fclose($fp);
    }
    if(!empty($data["paging"]["next"])){
        $link = $data["paging"]["next"];
    }
    else{
        break;
    }
  }
}
