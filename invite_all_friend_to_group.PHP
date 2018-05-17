<?php
ini_set('max_execution_time', 0);
//token full quyền
$token   = "";

//điền ID nhóm
$id_nhom = "";
$link    = "https://graph.facebook.com/me/friends?fields=id&limit=5000&access_token=$token"; 
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
$data     = json_decode($response,JSON_UNESCAPED_UNICODE);
$datas = $data["data"];
foreach($datas as $each){
    $id_mem = $each["id"];
    $link   = "https://graph.facebook.com/$id_nhom/members?method=post&member=$id_mem&access_token=$token";
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
?>
