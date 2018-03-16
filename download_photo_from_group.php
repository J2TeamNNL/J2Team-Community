<?php
ini_set('max_execution_time', 0);
//token bạn
$token = "EAAAA";
//điền ID nhóm
$id_group = "123";

//không sửa ở dưới
$link    = "https://graph.facebook.com/$id_group/feed?fields=full_picture&limit=1000&access_token=$token"; 
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
        if(isset($each['full_picture'])) {
            $id    = $each['id'];
            $fp    = fopen ("download/$id.jpg" , 'w+');
            $links = $each['full_picture'];
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
    }
    if(!empty($data["paging"]["next"])){
        $link = $data["paging"]["next"];
    }
    else{
        break;
    }
} 
