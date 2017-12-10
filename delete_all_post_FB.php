<?php
ini_set('max_execution_time', 0);
//token full quyền
$token      = "";
//điền ID nhóm, hoặc trang, hoặc cá nhân
$id_can_xoa = "";
//Tùy chỉnh thời gian xóa, điền true nếu muốn chọn tính năng này
$option = "false";
if($option=="true"){
    //Lưu ý điền đúng theo quy tắc năm tháng ngày
    //Điền thời gian từ ngày bao nhiêu
    $since = "2016-01-01";
    //Điền thời gian tới ngày bao nhiêu
    $until = "2016-12-30";
    $link  = "https://graph.facebook.com/$id_can_xoa/feed?fields=id&limit=5000&access_token=$token&since=$since&until=$until";
}
else{
   $link = "https://graph.facebook.com/$id_can_xoa/feed?fields=id&limit=5000&access_token=$token"; 
}
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
        $id_lay = $each["id"];
        $link   = "https://graph.facebook.com/$id_lay?method=delete&access_token=$token";
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
