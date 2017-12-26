<?php
ini_set('max_execution_time', 0);
//token full quyền
$token   = "";
//điền ID nhóm
$id_nhom = "";
//điền ID ban quản trị
$array_admin = ["123","234"];
$link    = "https://graph.facebook.com/$id_nhom/members?fields=id&limit=5000&access_token=$token"; 
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
    $data     = json_decode($response,JSON_UNESCAPED_UNICODE);
    $datas = $data["data"];
    foreach($datas as $each){
        if(in_array($each["id"],$array_admin)) continue;
        $id_mem = $each["id"];
        $link   = "https://graph.facebook.com/$id_nhom/members?method=delete&member=$id_mem&access_token=$token";
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
    if(!empty($data["paging"]["next"])){
        $link = $data["paging"]["next"];
    }
    else{
        break;
    }
}

?>
